<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de tipo de plato para crear los objetos tipo */
    use app\models\tipoPlatoModel;

    /* Crea la clase hija de la clase principal */
    class tipoPLatoController extends mainModel{

        /* LISTAR LOS TIPOS DE PLATO */
        public function listarTiposPlatoControlador(){

            /* Ejecuta la búsqueda de tipos de plato */
            $tipos = $this->ejecutarConsulta("SELECT * FROM tipos_plato ORDER BY nombre_tipo");

            /* Convierte el resultado a array */
            if ($tipos->rowCount()>0) {
                $tipos = $tipos->fetchAll();
            }

            /* Crea un array para ir guardando los tipos */
            $lista_tipos = array();

            /* Reorre el array de datos para ir creando objetos e insertándolos en la lista de tipos */
            foreach ($tipos as $fila) {
                /* Crea una nueva instancia de tipo */
                $tipo = new tipoPlatoModel($fila['id_tipo']);

                /* Añade el tipo a la lista */
                array_push($lista_tipos, $tipo);
            }
            /* Devuelve la lista de tipos */
            return $lista_tipos;
        }

        /* GUARDAR UN TIPO DE PLATO */
        public function guardarTipoPlatoControlador(){

            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un tipo de platos",
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
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un tipo de platos",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede añadir tipos de platos si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Recupera el nombre del tipo de platos */
            if ($_POST['nombre_tipo']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[(),;:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}", $_POST['nombre_tipo'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del tipo de plato sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_tipo = $this->limpiarCadena($_POST['nombre_tipo']);

                /* Comprueba si el nombre del tipo ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM tipos_plato WHERE nombre_tipo='$nombre_tipo'")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El tipo de platos $nombre_tipo ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }


            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del tipo de platos no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* FOTO DEL TIPO DE PLATOS */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/tipos_photos/";

            /* Comprueba si hay imágenes en el input */
            if ($_FILES['foto_tipo']['name'] != "" && $_FILES['foto_tipo']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_tipo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_tipo']['tmp_name']) != "image/png") {
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
                if ($_FILES['foto_tipo']['size']/1024 > 5120) {
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
                $foto_tipo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_tipo);
                $foto_tipo = str_ireplace(" ", "_", $foto_tipo);
                $foto_tipo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_tipo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_tipo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_tipo .= ".png";
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
                if (!move_uploaded_file($_FILES['foto_tipo']['tmp_name'], $img_dir.$foto_tipo)) {
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
                $foto_tipo = null;
            }
            
            /* Actualiza la base de datos */
            $tipo_datos_reg = [
                [
                    "campo_nombre"=>"nombre_tipo",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_tipo
                ],
                [
                    "campo_nombre"=>"foto_tipo",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_tipo
                ]
            ];

            $registrar_tipo = $this->guardarDatos("tipos_plato", $tipo_datos_reg);

            if ($registrar_tipo->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El tipo ".$nombre_tipo." ha sido registrado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_tipo)) {
                    chmod($img_dir.$foto_tipo, 777);
                    unlink($img_dir.$foto_tipo);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el grupo de platos en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"vas a guardar el tipo $nombre_tipo con la foto $foto_tipo",
                "icono"=>"success"
            ];
            return json_encode($alerta);
            exit();
        }

        /* ACTUALIZAR UN TIPO DE PLATO */
        public function actualizarTipoPlatoControlador(){
            
            /* Recupera el id del tipo */
            $id = $this->limpiarCadena($_POST['id_Form']);

            /* Verifica que el tipo existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM tipos_plato WHERE id_tipo='$id'");
            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El tipo de platos no existe",
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

            /* Recupera el nombre del tipo */
            if ($_POST['nombre_tipo']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[(),;:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}", $_POST['nombre_tipo'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del tipo de plato sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_tipo = $this->limpiarCadena($_POST['nombre_tipo']);

                /* Comprueba si el nombre del tipo ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM tipos_plato WHERE nombre_tipo='$nombre_tipo' AND id_tipo !='$id'")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El tipo de platos $nombre_tipo ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del tipo de platos no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
                
            /* FOTO DEL TIPO DE PLATOS */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/tipos_photos/";

            /* Comrueba si hay imágenes en el input */
            if ($_FILES['foto_tipo']['name'] != "" && $_FILES['foto_tipo']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_tipo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_tipo']['tmp_name']) != "image/png") {
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
                if ($_FILES['foto_tipo']['size']/1024 > 5120) {
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
                $foto_tipo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_tipo);
                $foto_tipo = str_ireplace(" ", "_", $foto_tipo);
                $foto_tipo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_tipo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_tipo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_tipo .= ".png";
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
                if (is_file($img_dir.$datos['foto_tipo'])) {
                    chmod($img_dir.$datos['foto_tipo'], 0777);
                    unlink($img_dir.$datos['foto_tipo']);
                }

                /* Sube la nueva imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_tipo']['tmp_name'], $img_dir.$foto_tipo)) {
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
                $foto_tipo = $datos['foto_tipo'];
            }
           
            /* Actualiza la base de datos */
            $tipo_datos_up = [
                [
                    "campo_nombre"=>"nombre_tipo",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_tipo
                ],
                [
                    "campo_nombre"=>"foto_tipo",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_tipo
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_tipo",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            /* Comprueba si se han insertado los datos */
            if ($this->actualizarDatos("tipos_plato", $tipo_datos_up, $condicion)) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El tipo ".$nombre_tipo." ha sido atualizado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_tipo)) {
                    chmod($img_dir.$foto_tipo, 777);
                    unlink($img_dir.$foto_tipo);
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

        /* ELIMINAR UN TIPO DE PLATOS */
        public function eliminarTipoPlatoControlador(){

            /* Comprobar que el usuario es administrador */
            if (!$_SESSION['administrador']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes eliminar tipos de plato. No eres administrador del sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_tipo']);

            /* Verificar que el tipo existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM tipos_plato WHERE id_tipo='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el Tipo de Platos en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Elimina el tipo de platos del sistema */
            $eliminarTipo = $this->eliminarRegistro("tipos_plato", "id_tipo", $id);

            if ($eliminarTipo->rowCount()==1) {
                if (is_file("../views/photos/tipos_photos/".$datos['foto_tipo'])) {
                    chmod("../views/photos/tipos_photos/".$datos['foto_tipo'], 0777);
                    unlink("../views/photos/tipos_photos/".$datos['foto_tipo']);
                }
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Tipo de platos eliminado",
                    "texto"=>"El tipo ".$datos['nombre_tipo']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El tipo ".$datos['nombre_tipo']." no ha podido ser eliminado",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }
    }