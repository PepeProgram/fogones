<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de utensilios de cocina para crear los objetos utensilio */
    use app\models\ingredienteModel;

    /* Crea la clase hija de la clase principal */
    class ingredienteController extends mainModel{

        /* CHEQUEAR SI HAY INGREDIENTES PENDIENTES DE REVISIÓN */
        public function revisarIngredientesControlador(){
            /* Ejecuta la búsqueda para comprobar si hay pendientes de revisión */
            $ingredientesRevisar = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE activo_ingrediente = 0");

            /* Devuelve true o false */
            if ($ingredientesRevisar->rowCount()>0) {
                return true;
            }
            else{
                return false;
            }

        }

        /* LISTAR LOS INGREDIENTES */
        public function listarIngredientesControlador(){

            $vista_actual = explode("/", $_SERVER['REQUEST_URI']);

            if (isset($vista_actual[3]) && $vista_actual[3] == "paraRevisar"){

                /* Ejecuta la búsqueda de los ingredientes pendientes de revisión */
                $ingredientes = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE activo_ingrediente = 0 ORDER BY nombre_ingrediente");
            }
            else{

                /* Ejecuta la búsqueda de todos los ingredientes */
                $ingredientes = $this->ejecutarConsulta("SELECT * FROM ingredientes ORDER BY nombre_ingrediente");
            }


            /* Convierte el resultado a array */
            if ($ingredientes->rowCount()>0) {
                $ingredientes = $ingredientes->fetchAll();
            }

            /* Crea un array para ir guardando los ingredientes */
            $lista_ingredientes = array();

            /* Recorre el array de datos para ir creando objetos e insertándolos en la lista de ingredientes */
            foreach ($ingredientes as $fila) {
                /* Crea una nueva instancia de ingrediente */
                $ingrediente = new ingredienteModel($fila['id_ingrediente']);

                /* Añade el ingrediente a la lista */
                array_push($lista_ingredientes, $ingrediente);
            }
            /* Devuelve la lista de ingredientes */
            return $lista_ingredientes;

        }

        /* GUARDAR UN UTENSILIO DE COCINA */
        public function guardarIngredienteControlador(){
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
                /* Verificar que el usuario es quien dice ser */
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
                                    "texto"=>"No puedes cambiar el estado de los utensilios. No eres administrador del sistema",
                                    "icono"=>"error"
                                ];
                            }
                            return json_encode($alerta);
                            exit();
                        }
                }
                
            }

            /* Recupera el nombre del ingrediente */
            if ($_POST['nombre_ingrediente']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}", $_POST['nombre_ingrediente'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del ingrediente sólo puede contener letras, números, .,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_ingrediente = $this->limpiarCadena($_POST['nombre_ingrediente']);

                /* Comprueba si el nombre del ingrediente ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM ingredientes WHERE nombre_ingrediente = '$nombre_ingrediente' ")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El Ingrediente $nombre_ingrediente ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del ingrediente no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* Actualiza la base de datos */
            $ingrediente_datos_reg = [
                [
                    "campo_nombre"=>"nombre_ingrediente",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_ingrediente
                ]
            ];

            $registrar_ingrediente = $this->guardarDatos("ingredientes", $ingrediente_datos_reg);

            if ($registrar_ingrediente->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Ingrediente guardado!!!",
                    "texto" => "El Ingrediente ".$nombre_ingrediente." ha sido registrado correctamente.",
                    "icono" => "success"
                ];
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el ingrediente en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }

        /* ACTUALIZAR UN UTENSILIO DE COCINA */
        public function actualizarIngredienteControlador(){

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
        public function eliminarIngredienteControlador(){

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

        /* ACTIVAR O DESACTIVAR UN INGREDIENTE */
        public function cambiarActivoIngredienteControlador(){
            
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
            $id = $this->limpiarCadena($_POST['id_ingrediente']);
            
            /* Verificar el ingrediente */
            $datos=$this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el ingrediente en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }
            
            /* Recupera los datos del ingrediente */
            $activo_ingrediente = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id'");
            $activo_ingrediente = $activo_ingrediente->fetch();
            
            /* Verificar si el ingrediente está activo o no */
            if ($activo_ingrediente['activo_ingrediente'] == 0) {

                /* Activa el ingrediente */
                /* Crea el array para guardar los datos */
                $ingrediente_datos_up = [
                    [
                        "campo_nombre"=>"activo_ingrediente",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>1
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_ingrediente",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("ingredientes", $ingrediente_datos_up, $condicion)) {
                    $alerta = [
                        "tipo" => "recargar",
                        "titulo" => "Felicidades!!!",
                        "texto" => "El ingrediente ".$activo_ingrediente['nombre_ingrediente']." ha sido activado.",
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
                /* Desactiva el ingrediente */
                /* Crea el array para guardar los datos */
                $ingrediente_datos_up = [
                    [
                        "campo_nombre"=>"activo_ingrediente",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>0
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_ingrediente",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("ingredientes", $ingrediente_datos_up, $condicion)) {
                    $alerta = [
                        "tipo" => "recargar",
                        "titulo" => "Felicidades!!!",
                        "texto" => "El ingrediente ".$activo_ingrediente['nombre_ingrediente']." ha sido desactivado.",
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
    }