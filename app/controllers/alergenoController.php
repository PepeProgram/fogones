<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de alergeno para crear los objetos alergeno */
    use app\models\alergenoModel;

    /* Crea la clase hija de la clase principal */
    class alergenoController extends mainModel{

        /* LISTAR ALÉRGENOS */
        public function listarAlergenosControlador(){
            
            /* Ejecuta la búsqueda de alérgenos */
            $consulta = "SELECT * FROM alergenos ORDER BY nombre_alergeno";
            $alergenos = $this->ejecutarConsulta($consulta);

            /* Convierte el resultado a array */
            if ($alergenos->rowCount()>0) {
                $alergenos = $alergenos->fetchAll();
            }

            /* Crea un array para ir guardando los alérgenos */
            $lista_alergenos = array();

            /* Recorre el array de datos para ir creando objetos e insertándolos en el array */
            foreach ($alergenos as $fila) {

                /* Crea una nueva instancia de alérgeno */
                $alergeno = new alergenoModel($fila['id_alergeno'], $fila['nombre_alergeno'], $fila['foto_alergeno']);

                /* Añade el alérgeno a la lista */
                array_push($lista_alergenos, $alergeno);
            }
            /* Devuelve la lista de alérgenos */
            return $lista_alergenos;

        }

        /* ACTUALIZAR ALERGENO */
        public function actualizarAlergenoControlador(){
            /* Recuperar id del alérgeno */
            $id = $this->limpiarCadena($_POST['id_alergeno']);

            /* Verificar que el alérgeno existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM alergenos WHERE id_alergeno = '$id'");

            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El alérgeno no existe",
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

            /* Recupera el nombre del alérgeno */
            if ($_POST['nombre_alergeno'] != "") {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,200}", $_POST['nombre_alergeno'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del alérgeno sólo puede contener letras, números, .,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_alergeno = $this->limpiarCadena($_POST['nombre_alergeno']);
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del alérgeno no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            

            /* FOTO DEL ALÉRGENO */

            /* Comprueba si hay imagen en el input */
            if ($_FILES['foto_alergeno']['name'] != "" && $_FILES['foto_alergeno']['size']>0) {

                /* Verifica el formato de la imagen */
                if (mime_content_type($_FILES['foto_alergeno']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_alergeno']['tmp_name']) != "image/png") {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al actualizar el icono",
                        "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica el tamaño de la imagen */
                if ($_FILES['foto_alergeno']['size']/1024 > 5120) {
                    if ($_FILES['foto_alergeno']['size']/1024 > 5120) {
                        $alerta=[
                            "tipo"=>"recargar",
                            "titulo"=>"Error al actualizar el icono",
                            "texto"=>"El tamaño del archivo de imagen es mayor que el permitido (5 Mb)",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }

                /* Establece el nombre de la nueva imagen */
                $foto_alergeno = iconv( 'UTF-8', 'ASCII//IGNORE', $datos['nombre_alergeno']);
                $foto_alergeno = str_ireplace(" ", "_", $foto_alergeno);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_alergeno']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_alergeno .= ".jpg";
                        break;
                    case 'image/png':
                        $foto_alergeno .= ".png";
                        break;
                }

                /* Establece el directorio de imágenes */
                $img_dir = "../views/photos/alergen_photos/";

                /* Permisos del directorio de imágenes */
                chmod($img_dir, 0777);

                /* Borra la imagen actual si existe */
                if (is_file($img_dir.$datos['foto_alergeno'])) {
                    chmod($img_dir.$datos['foto_alergeno'], 0777);
                    unlink($img_dir.$datos['foto_alergeno']);
                }

                /* Sube la nueva imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_alergeno']['tmp_name'], $img_dir.$foto_alergeno)) {
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
                /* Si no hay foto en el input, le pone el nombre que tenía */
                $foto_alergeno = $datos['foto_alergeno'];
            }

            /* Actualiza la base de datos */
            $alergeno_datos_up = [
                [
                    "campo_nombre"=>"nombre_alergeno",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_alergeno
                ],
                [
                    "campo_nombre"=>"foto_alergeno",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_alergeno
                ],
            ];

            $condicion = [
                "condicion_campo"=>"id_alergeno",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];
            
            if ($this->actualizarDatos("alergenos", $alergeno_datos_up, $condicion)) {
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Felicidades!!!",
                    "texto"=>"Datos del alérgeno ".$datos['nombre_alergeno']." actualizados correctamente",
                    "icono"=>"success"
                ];
            } else {
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Error al actualizar los datos",
                    "texto"=>"Los datos del alérgeno ".$datos['nombre_alergeno']." no han podido ser actualizados. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            


        }
        
        public function guardarAlergenoControlador(){
             /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
             if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un alérgeno",
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
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un alérgeno",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede añadir alérgenos si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Recupera el nombre del alérgeno */
            if ($_POST['nombre_alergeno'] != "") {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,200}", $_POST['nombre_alergeno'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del alérgeno sólo puede contener letras, números, .,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia el nombre para evitar SQL Injection */
                $nombre_alergeno = $this->limpiarCadena($_POST['nombre_alergeno']);
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del alérgeno no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL ALÉRGENO */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/alergen_photos/";

            /* Comprueba si hay imagen en el input */
            if ($_FILES['foto_alergeno']['name'] != "" && $_FILES['foto_alergeno']['size']>0) {

                /* Verifica el formato de la imagen */
                if (mime_content_type($_FILES['foto_alergeno']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_alergeno']['tmp_name']) != "image/png") {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar el icono",
                        "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica el tamaño de la imagen */
                if ($_FILES['foto_alergeno']['size']/1024 > 5120) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar el icono",
                        "texto"=>"El tamaño del archivo de imagen es mayor que el permitido (5 Mb)",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Establece el nombre de la nueva imagen */
                $foto_alergeno = iconv( 'UTF-8', 'ASCII//IGNORE', $nombre_alergeno);
                $foto_alergeno = str_ireplace(" ", "_", $foto_alergeno);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_alergeno']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_alergeno .= ".jpg";
                        break;
                    case 'image/png':
                        $foto_alergeno .= ".png";
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
        
                        /* Codifica la variable como datos JSON */
                        return json_encode($alerta);
        
                        /* Detiene la ejecución del script */
                        exit();
                    }
                }

                /* Permisos del directorio de imágenes */
                chmod($img_dir, 0777);

                /* Sube la nueva imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_alergeno']['tmp_name'], $img_dir.$foto_alergeno)) {
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
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error en el formulario",
                    "texto"=>"Debe añadir un icono para el nuevo alérgeno",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Actualiza la base de datos */
            $alergeno_datos_reg = [
                [
                    "campo_nombre"=>"nombre_alergeno",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_alergeno
                ],
                [
                    "campo_nombre"=>"foto_alergeno",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_alergeno
                ],
            ];
            
            $registrar_alergeno = $this->guardarDatos("alergenos", $alergeno_datos_reg);

            /* Comprueba si se han insertado los datos */
            if ($registrar_alergeno->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El alérgeno ".$nombre_alergeno." ha sido registrado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_alergeno)) {
                    chmod($img_dir.$foto_alergeno, 777);
                    unlink($img_dir.$foto_alergeno);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el alérgeno en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }

        /* ELIMINAR UN GRUPO DE PLATOS */
        public function eliminarAlergenoControlador(){

            /* Comprobar que el usuario es administrador */
            if (!$_SESSION['administrador']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes eliminar alergenos. No eres administrador del sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_alergeno']);

            /* Verificar que el alérgeno existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM alergenos WHERE id_alergeno='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el alérgeno en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Elimina el alérgeno del sistema */
            $eliminarAlergeno = $this->eliminarRegistro("alergenos", "id_alergeno", $id);

            if ($eliminarAlergeno->rowCount()==1) {
                if (is_file("../views/photos/alergen_photos/".$datos['foto_alergeno'])) {
                    chmod("../views/photos/alergen_photos/".$datos['foto_alergeno'], 0777);
                    unlink("../views/photos/alergen_photos/".$datos['foto_alergeno']);
                }
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Alérgeno eliminado",
                    "texto"=>"El alérgeno ".$datos['nombre_alergeno']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El alérgeno ".$datos['nombre_alergeno']." no ha podido ser eliminado",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }

    }