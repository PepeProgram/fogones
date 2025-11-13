<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de estilos de cocina para crear los objetos estilo */
    use app\models\estiloCocinaModel;

    /* Crea la clase hija de la clase principal */
    class estiloCocinaController extends mainModel{

        /* LISTAR LOS ESTILOS DE COCINA */
        public function listarEstilosCocinaControlador(){

            /* Ejecuta a búsqueda de estilos de cocina */
            $estilos = $this->ejecutarConsulta("SELECT * FROM estilos_cocina ORDER BY nombre_estilo");

            /* Convierte el resultado a array */
            if ($estilos->rowCount()>0) {
                $estilos = $estilos->fetchAll();
            }

            /* Crea un array para ir guardando los estilos */
            $lista_estilos = array();

            /* Recorre el array de datos para ir creando objetos e insertándolos en la lista de estilos */
            foreach ($estilos as $fila) {
                /* Crea una nueva instancia de estilo */
                $estilo = new estiloCocinaModel($fila['id_estilo']);

                /* Añade el estilo a la lista */
                array_push($lista_estilos, $estilo);
            }
            /* Devuelve la lista de estilos */
            return $lista_estilos;

        }

        /* GUARDAR UN ESTILO DE COCINA */
        public function guardarEstiloCocinaControlador(){
            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un estilo de cocina",
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
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un estilo de cocina",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede añadir estilos de cocina si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Recupera el nombre del estilo */
            if ($_POST['nombre_estilo']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[(),;:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}", $_POST['nombre_estilo'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del estilo de cocina sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_estilo = $this->limpiarCadena($_POST['nombre_estilo']);

                /* Comprueba si el nombre del estilo ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM estilos_cocina WHERE nombre_estilo = '$nombre_estilo' ")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El Estilo de Cocina $nombre_estilo ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del estilo de cocina no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL ESTILO DE COCINA */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/styles_photos/";

            /* Comprueba si hay imágenes en el input */
            if ($_FILES['foto_estilo']['name'] != "" && $_FILES['foto_estilo']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_estilo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_estilo']['tmp_name']) != "image/png") {
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
                if ($_FILES['foto_estilo']['size']/1024 > 5120) {
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
                $foto_estilo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_estilo);
                $foto_estilo = str_ireplace(" ", "_", $foto_estilo);
                $foto_estilo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_estilo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_estilo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_estilo .= ".png";
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
                if (!move_uploaded_file($_FILES['foto_estilo']['tmp_name'], $img_dir.$foto_estilo)) {
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
                $foto_estilo = null;
            }
            
            /* Actualiza la base de datos */
            $estilo_datos_reg = [
                [
                    "campo_nombre"=>"nombre_estilo",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_estilo
                ],
                [
                    "campo_nombre"=>"foto_estilo",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_estilo
                ]
            ];

            $registrar_estilo = $this->guardarDatos("estilos_cocina", $estilo_datos_reg);

            if ($registrar_estilo->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El grupo ".$nombre_estilo." ha sido registrado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_estilo)) {
                    chmod($img_dir.$foto_estilo, 777);
                    unlink($img_dir.$foto_estilo);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el estilo de cocina en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }

        /* ACTUALIZAR UN ESTILO DE COCINA */
        public function actualizarEstiloCocinaControlador(){

            /* Recupera el id del estilo */
            $id = $this->limpiarCadena($_POST['id_Form']);

            /* Verifica que el estilo existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM estilos_cocina WHERE id_estilo='$id'");
            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El estilo de cocina no existe",
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

            /* Recupera el nombre del estilo */
            if ($_POST['nombre_estilo']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[(),;:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}", $_POST['nombre_estilo'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del estilo de cocina sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_estilo = $this->limpiarCadena($_POST['nombre_estilo']);

                /* Comprueba si el nombre del estilo ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM estilos_cocina WHERE nombre_estilo='$nombre_estilo' AND id_estilo !='$id'")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El estilo de cocina $nombre_estilo ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del estilo de cocina no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL ESTILO DE COCINA */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/styles_photos/";

            /* Comrueba si hay imágenes en el input */
            if ($_FILES['foto_estilo']['name'] != "" && $_FILES['foto_estilo']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_estilo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_estilo']['tmp_name']) != "image/png") {
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
                if ($_FILES['foto_estilo']['size']/1024 > 5120) {
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
                $foto_estilo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_estilo);
                $foto_estilo = str_ireplace(" ", "_", $foto_estilo);
                $foto_estilo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_estilo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_estilo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_estilo .= ".png";
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
                if (is_file($img_dir.$datos['foto_estilo'])) {
                    chmod($img_dir.$datos['foto_estilo'], 0777);
                    unlink($img_dir.$datos['foto_estilo']);
                }

                /* Sube la nueva imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_estilo']['tmp_name'], $img_dir.$foto_estilo)) {
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
                $foto_estilo = $datos['foto_estilo'];
            }
            
            /* Actualiza la base de datos */
            $estilo_datos_up = [
                [
                    "campo_nombre"=>"nombre_estilo",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_estilo
                ],
                [
                    "campo_nombre"=>"foto_estilo",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_estilo
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_estilo",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            /* Comprueba si se han insertado los datos */
            if ($this->actualizarDatos("estilos_cocina", $estilo_datos_up, $condicion)) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El estilo de cocina ".$nombre_estilo." ha sido atualizado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_estilo)) {
                    chmod($img_dir.$foto_estilo, 777);
                    unlink($img_dir.$foto_estilo);
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
        
        /* ELIMINAR UN GRUPO DE PLATOS */
        public function eliminarEstiloCocinaControlador(){

            /* Comprobar que el usuario es administrador */
            if (!$_SESSION['administrador']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes eliminar estilos de cocina. No eres administrador del sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_estilo']);

            /* Verificar que el estilo de cocina existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM estilos_cocina WHERE id_estilo='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el estilo de cocina en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Elimina el estilo de cocina del sistema */
            $eliminarEstilo = $this->eliminarRegistro("estilos_cocina", "id_estilo", $id);

            if ($eliminarEstilo->rowCount()==1) {
                if (is_file("../views/photos/styles_photos/".$datos['foto_estilo'])) {
                    chmod("../views/photos/styles_photos/".$datos['foto_estilo'], 0777);
                    unlink("../views/photos/styles_photos/".$datos['foto_estilo']);
                }
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Estilo de cocina eliminado",
                    "texto"=>"El estilo ".$datos['nombre_estilo']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El estilo de cocina ".$datos['nombre_estilo']." no ha podido ser eliminado",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }
    }