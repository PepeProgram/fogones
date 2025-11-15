<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de utensilios de cocina para crear los objetos utensilio */
    use app\models\utensilioModel;

    /* Crea la clase hija de la clase principal */
    class utensilioController extends mainModel{

        /* CHEQUEAR SI HAY UTENSILIOS PENDIENTES DE REVISIÓN */
        public function revisarUtensiliosControlador(){
            /* Ejecuta la búsqueda para comprobar si hay pendientes de revisión */
            $utensiliosRevisar = $this->ejecutarConsulta("SELECT * FROM utensilios WHERE activo = 0 ORDER BY nombre_utensilio");

            /* Devuelve true o false */
            if ($utensiliosRevisar->rowCount()>0) {
                return true;
            }
            else{
                return false;
            }
        }

        /* LISTAR LOS UTENSILIOS DE COCINA */
        public function listarUtensiliosControlador(){

            $vista_actual = explode("/", $_SERVER['REQUEST_URI']);

            if (isset($vista_actual[3]) && $vista_actual[3] == "paraRevisar"){

                /* Ejecuta la búsqueda de los utensilios de cocina pendientes de revisión */
                $utensilios = $this->ejecutarConsulta("SELECT * FROM utensilios WHERE activo = 0 ORDER BY nombre_utensilio");
            }
            else{

                /* Ejecuta la búsqueda de todos los utensilios de cocina */
                $utensilios = $this->ejecutarConsulta("SELECT * FROM utensilios ORDER BY nombre_utensilio");
            }


            /* Convierte el resultado a array */
            if ($utensilios->rowCount()>0) {
                $utensilios = $utensilios->fetchAll();
            }

            /* Crea un array para ir guardando los utensilios */
            $lista_utensilios = array();

            /* Recorre el array de datos para ir creando objetos e insertándolos en la lista de utensilios */
            foreach ($utensilios as $fila) {
                /* Crea una nueva instancia de utensilio */
                $utensilio = new utensilioModel($fila['id_utensilio']);

                /* Añade el utensilio a la lista */
                array_push($lista_utensilios, $utensilio);
            }
            /* Devuelve la lista de utensilios */
            return $lista_utensilios;

        }

        /* GUARDAR UN UTENSILIO DE COCINA */
        public function guardarUtensilioControlador(){
            /* Verifica que el usuario ha iniciado sesión, existe y es redactor o administrador */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un utensilio de cocina",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {

                /* Comprobar que el usuario es quien dice ser */
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un utensilio de cocina",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    /* Comprobar que el usuario es administrador o revisor */
                    if (!$_SESSION['administrador']) {
                        if (!$_SESSION['revisor']) {
                            $alerta=[
                                "tipo"=>"simple",
                                "titulo"=>"ERROR GRAVE",
                                "texto"=>"No puedes cambiar el estado de los utensilios. No eres administrador ni revisor",
                                "icono"=>"error"
                            ];
                        }
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Recupera el nombre del utensilio */
            if ($_POST['nombre_utensilio']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[();,:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}", $_POST['nombre_utensilio'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del utensilio de cocina sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_utensilio = $this->limpiarCadena($_POST['nombre_utensilio']);

                /* Comprueba si el nombre del utensilio ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM utensilios WHERE nombre_utensilio = '$nombre_utensilio' ")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El Utensilio de Cocina $nombre_utensilio ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del utensilio de cocina no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL UTENSILIO DE COCINA */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/utensilios_photos/";

            /* Comprueba si hay imágenes en el input */
            if ($_FILES['foto_utensilio']['name'] != "" && $_FILES['foto_utensilio']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_utensilio']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_utensilio']['tmp_name']) != "image/png") {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar la imagen.",
                        "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica el tamaño de la imagen */
                if ($_FILES['foto_utensilio']['size']/1024 > 5120) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar la imagen",
                        "texto"=>"El tamaño del archivo de imagen es mayor que el permitido (5 Mb)",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Establece el nombre de la nueva imagen */
                $foto_utensilio = iconv('UTF-8', 'ASCII//IGNORE', $nombre_utensilio);
                $foto_utensilio = str_ireplace(" ", "_", $foto_utensilio);
                $foto_utensilio .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_utensilio']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_utensilio .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_utensilio .= ".png";
                        break;
                }

                /* Crea el directorio si no está creado */
                if (!file_exists($img_dir)) {
                    
                    /* Comprueba si se ha podido crear y asignarle permisos */
                    if (!mkdir($img_dir, 0777)) {
                        $alerta = [
                            "tipo" => "simple",
                            "titulo" => "Error inesperado.",
                            "texto" => "No se ha podido crear la carpeta de imágenes",
                            "icono" => "error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }

                /* Permisos del directorio de imágenes por si acaso */
                chmod($img_dir, 0777);

                /* Sube la imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_utensilio']['tmp_name'], $img_dir.$foto_utensilio)) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al actualizar la foto",
                        "texto"=>"No se ha podido guardar la imagen. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                
            } else {
                $foto_utensilio = null;
            }
            
            /* Actualiza la base de datos */
            $utensilio_datos_reg = [
                [
                    "campo_nombre"=>"nombre_utensilio",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_utensilio
                ],
                [
                    "campo_nombre"=>"foto_utensilio",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_utensilio
                ]
            ];

            $registrar_utensilio = $this->guardarDatos("utensilios", $utensilio_datos_reg);

            /* Recupera el id y el nombre del último utensilio añadido */
            $ultimoInsert = $this->ejecutarConsulta("SELECT * FROM utensilios ORDER BY id_utensilio DESC LIMIT 1");
            $ultimoInsert = $ultimoInsert->fetch();
            $ultimoId = $ultimoInsert['id_utensilio'];
            $ultimoNombre = $ultimoInsert['nombre_utensilio'];

            if ($registrar_utensilio->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Utensilio guardado!!!",
                    "texto" => "El Utensilio de Cocina ".$nombre_utensilio." ha sido registrado correctamente.",
                    "icono" => "success",
                    "id" => $ultimoId,
                    "nombre" => $ultimoNombre 
                ];
            } else {
                if (is_file($img_dir.$foto_utensilio)) {
                    chmod($img_dir.$foto_utensilio, 777);
                    unlink($img_dir.$foto_utensilio);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el utensilio de cocina en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }

        /* ACTUALIZAR UN UTENSILIO DE COCINA */
        public function actualizarUtensilioControlador(){

            /* Recupera el id del utensilio */
            $id = $this->limpiarCadena($_POST['id_Form']);

            /* Verifica que el utensilio existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM utensilios WHERE id_utensilio='$id'");
            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El utensilio de cocina no existe",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }
            
            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede realizar cambios si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Recupera el nombre del utensilio */
            if ($_POST['nombre_utensilio']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}", $_POST['nombre_utensilio'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del utensilio de cocina sólo puede contener letras, números, .,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_utensilio = $this->limpiarCadena($_POST['nombre_utensilio']);

                /* Comprueba si el nombre del utensilio ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM utensilios WHERE nombre_utensilio='$nombre_utensilio' AND id_utensilio !='$id'")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El utensilio de cocina $nombre_utensilio ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del utensilio de cocina no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL UTENSILIO DE COCINA */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/utensilios_photos/";

            /* Comrueba si hay imágenes en el input */
            if ($_FILES['foto_utensilio']['name'] != "" && $_FILES['foto_utensilio']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_utensilio']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_utensilio']['tmp_name']) != "image/png") {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar la imagen.",
                        "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica el tamaño de la imagen */
                if ($_FILES['foto_utensilio']['size']/1024 > 5120) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar la imagen",
                        "texto"=>"El tamaño del archivo de imagen es mayor que el permitido (5 Mb)",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Establece el nombre de la nueva imagen */
                $foto_utensilio = iconv('UTF-8', 'ASCII//IGNORE', $nombre_utensilio);
                $foto_utensilio = str_ireplace(" ", "_", $foto_utensilio);
                $foto_utensilio .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_utensilio']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_utensilio .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_utensilio .= ".png";
                        break;
                }

                /* Crea el directorio si no está creado */
                if (!file_exists($img_dir)) {
                    
                    /* Comprueba si se ha podido crear y asignarle permisos */
                    if (!mkdir($img_dir, 0777)) {
                        $alerta = [
                            "tipo" => "simple",
                            "titulo" => "Error inesperado.",
                            "texto" => "No se ha podido crear la carpeta de imágenes",
                            "icono" => "error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }

                /* Permisos del directorio de imágenes por si acaso */
                chmod($img_dir, 0777);

                /* Borra la foto anterior si existe */
                if (is_file($img_dir.$datos['foto_utensilio'])) {
                    chmod($img_dir.$datos['foto_utensilio'], 0777);
                    unlink($img_dir.$datos['foto_utensilio']);
                }

                /* Sube la nueva imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_utensilio']['tmp_name'], $img_dir.$foto_utensilio)) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al actualizar la foto",
                        "texto"=>"No se ha podido guardar la imagen. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                
            } else {
                $foto_utensilio = $datos['foto_utensilio'];
            }
            
            /* Actualiza la base de datos */
            $utensilio_datos_up = [
                [
                    "campo_nombre"=>"nombre_utensilio",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_utensilio
                ],
                [
                    "campo_nombre"=>"foto_utensilio",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_utensilio
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_utensilio",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            /* Comprueba si se han insertado los datos */
            if ($this->actualizarDatos("utensilios", $utensilio_datos_up, $condicion)) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El utensilio de cocina ".$nombre_utensilio." ha sido atualizado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_utensilio)) {
                    chmod($img_dir.$foto_utensilio, 777);
                    unlink($img_dir.$foto_utensilio);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }
        
        /* ELIMINAR UN UTENSILIO DE COCINA */
        public function eliminarUtensilioControlador(){

            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder eliminar utensilios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder eliminar utensilios",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede eliminar utensilios si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_utensilio']);

            /* Verificar que el utensilio de cocina existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM utensilios WHERE id_utensilio='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el utensilio de cocina en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Elimina el utensilio de cocina del sistema */
            $eliminarUtensilio = $this->eliminarRegistro("utensilios", "id_utensilio", $id);

            if ($eliminarUtensilio->rowCount()==1) {
                if (is_file("../views/photos/utensilios_photos/".$datos['foto_utensilio'])) {
                    chmod("../views/photos/utensilios_photos/".$datos['foto_utensilio'], 0777);
                    unlink("../views/photos/utensilios_photos/".$datos['foto_utensilio']);
                }
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Utensilio de cocina eliminado",
                    "texto"=>"El utensilio de cocina ".$datos['nombre_utensilio']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El utensilio de cocina ".$datos['nombre_utensilio']." no ha podido ser eliminado",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }

        /* ACTIVAR O DESACTIVAR UN UTENSILIO DE COCINA */
        public function cambiarActivoUtensilioControlador(){
            
            /* Comprobar que el usuario es administrador o revisor */
            if (!$_SESSION['administrador']) {
                if (!$_SESSION['revisor']) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR GRAVE",
                        "texto"=>"No puedes cambiar el estado de los utensilios. No eres administrador del sistema",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
                exit();
            }
            
            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_utensilio']);
            
            /* Verificar el utensilio de cocina */
            $datos=$this->ejecutarConsulta("SELECT * FROM utensilios WHERE id_utensilio='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el utensilio de cocina en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }
            
            /* Recupera los datos del utensilio */
            $activo_utensilio = $this->ejecutarConsulta("SELECT * FROM utensilios WHERE id_utensilio='$id'");
            $activo_utensilio = $activo_utensilio->fetch();
            
            /* Verificar si el utensilio está activo o no */
            if ($activo_utensilio['activo'] == 0) {

                /* Activa el utensilio */
                /* Crea el array para guardar los datos */
                $utensilio_datos_up = [
                    [
                        "campo_nombre"=>"activo",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>1
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_utensilio",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("utensilios", $utensilio_datos_up, $condicion)) {
                    $alerta = [
                        "tipo" => "recargar",
                        "titulo" => "Activado!!!",
                        "texto" => "El utensilio de cocina ".$activo_utensilio['nombre_utensilio']." ha sido activado.",
                        "icono" => "success"
                    ];
                } else {

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error",
                        "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                }
            }
            else{
                /* Desactiva el utensilio */
                /* Crea el array para guardar los datos */
                $utensilio_datos_up = [
                    [
                        "campo_nombre"=>"activo",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>0
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_utensilio",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("utensilios", $utensilio_datos_up, $condicion)) {
                    $alerta = [
                        "tipo" => "recargar",
                        "titulo" => "Desactivado!!!",
                        "texto" => "El utensilio de cocina ".$activo_utensilio['nombre_utensilio']." ha sido desactivado.",
                        "icono" => "success"
                    ];
                } else {

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error",
                        "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                }
                
            }
            return json_encode($alerta);
        }

        /* Activa un utensilio directamente desde la revisión de la receta */
        public function aprobarUtensilioControlador(){

            /* Comprobar que el usuario es administrador o revisor */
            if (!$_SESSION['administrador']) {
                if (!$_SESSION['revisor']) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR GRAVE",
                        "texto"=>"No puedes cambiar el estado de los utensilios. No eres administrador del sistema",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
                exit();
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_utensilio']);

            /* Convertir en array el string de los id */
            $idArray = explode(',', $id);

            /* Recorre el array para activar los utensilios que no estén activos */
            foreach ($idArray as $id) {

                /* Activa el utensilio */
                /* Crea el array para guardar los datos */
                $utensilio_datos_up = [
                    [
                        "campo_nombre"=>"activo",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>1
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_utensilio",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("utensilios", $utensilio_datos_up, $condicion)) {
                    $alerta = [];
                } else {

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error",
                        "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    exit();
                }
                
            }

            return json_encode($alerta);
        }
    }
