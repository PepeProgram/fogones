<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de grupo de platos para crear los objetos grupo */
    use app\models\metodoModel;

    /* Crea la clase hija de la clase principal */
    class metodoController extends mainModel{

        /*
        ******************* OJO: *************************************
        RECORDAR QUE LA TABLA DE MÉTODOS DE COCCIÓN SE LLAMA tecnicas
        LOS CAMPOS SON id_tecnica, nombre_tecnica y foto_tecnica
        **************************************************************

        */

        /* LISTAR LOS MÉTODOS DE COCCIÓN */
        public function listarMetodosControlador(){

            /* Ejecuta la búsqueda de Metodos de cocción */
            $metodos = $this->ejecutarConsulta("SELECT * FROM tecnicas ORDER BY nombre_tecnica");

            /* Convierte el resultado a array */
            if ($metodos->rowCount()>0) {
                $metodos = $metodos->fetchAll();
            }

            /* Crea un array para ir guardando los métodos de cocción */
            $lista_metodos = array();

            /* Reorre el array de datos para ir creando objetos e insertándolos en la lista de metodos de cocción */
            foreach ($metodos as $fila) {
                /* Crea una nueva instancia de metodo */
                $metodo = new metodoModel($fila['id_tecnica']);

                /* Añade el metodos a la lista */
                array_push($lista_metodos, $metodo);
            }
            /* Devuelve la lista de metodos de cocción */
            return $lista_metodos;
        }

        /* GUARDAR UN MÉTODO DE COCCIÓN */
        public function guardarMetodoControlador(){

            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un método de cocción",
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
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un método de cocción",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede añadir métodos de cocción si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }

                /* Recupera el nombre del método de cocción */
                if ($_POST['nombre_metodo']) {

                    /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                    /* Nombre */
                    if ($this->verificarDatos("[(),;:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}", $_POST['nombre_metodo'])) {
                        /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                        $alerta = [
                            "tipo" => "simple",
                            "titulo" => "Error en el formulario",
                            "texto" => "El nombre del método de cocción sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres",
                            "icono" => "error"
                        ];

                        /* Codifica la variable como datos JSON */
                        return json_encode($alerta);

                        /* Detiene la ejecución del script */
                        exit();
                    }

                    /* Limpia los datos para evitar SQL Injection */
                    $nombre_metodo = $this->limpiarCadena($_POST['nombre_metodo']);

                    /* Comprueba si el nombre del método ya existe */
                    if ($this->ejecutarConsulta("SELECT * FROM tecnicas WHERE nombre_tecnica='$nombre_metodo'")->rowCount()>0) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Error!!!",
                            "texto"=>"El método de cocción $nombre_metodo ya existe",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }


                } else {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El nombre del método de cocción no puede estar vacío",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                
            }

            /* FOTO DEL MÉTODO DE COCCIÓN */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/metodos_photos/";

            /* Comprueba si hay imágenes en el input */
            if ($_FILES['foto_metodo']['name'] != "" && $_FILES['foto_metodo']['size'] >0 ) {

                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_metodo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_metodo']['tmp_name']) != "image/png") {
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
                if ($_FILES['foto_metodo']['size']/1024 > 5120) {
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
                $foto_metodo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_metodo);
                $foto_metodo = str_ireplace(" ", "_", $foto_metodo);
                $foto_metodo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_metodo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_metodo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_metodo .= ".png";
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
                if (!move_uploaded_file($_FILES['foto_metodo']['tmp_name'], $img_dir.$foto_metodo)) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al actualizar la foto",
                        "texto"=>"No se ha podido guardar la imagen. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }


                
            }
            else {
                $foto_metodo = null;
            }
            
            /* Actualiza la base de datos */
            $metodo_datos_reg = [
                [
                    "campo_nombre"=>"nombre_tecnica",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_metodo
                ],
                [
                    "campo_nombre"=>"foto_tecnica",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_metodo
                ]
            ];

            $registrar_metodo = $this->guardarDatos("tecnicas", $metodo_datos_reg);

            /* Comprobar que se ha guardado correctamente */
            if ($registrar_metodo->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El método de cocción ".$nombre_metodo." ha sido registrado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_metodo)) {
                    chmod($img_dir.$foto_metodo, 777);
                    unlink($img_dir.$foto_metodo);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el método de cocción en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            
            return json_encode($alerta);

        }

        /* ACTUALIZAR UN MÉTODO DE COCCIÓN */
        public function actualizarMetodoControlador(){

            /* Recupera el id del método de cocción */
            $id = $this->limpiarCadena($_POST['id_Form']);

            /* Verifica que el método de cocción existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM tecnicas WHERE id_tecnica='$id'");
            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El método de cocción no existe",
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
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder cambiar los datos de un método de cocción",
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
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder cambiar los datos de un método de cocción",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede cambiar los datos de un método de cocción si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
            }

            /* Recupera el nombre del método de cocción */
            if ($_POST['nombre_metodo']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                    /* Nombre */
                    if ($this->verificarDatos("[(),;:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}", $_POST['nombre_metodo'])) {
                        /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                        $alerta = [
                            "tipo" => "simple",
                            "titulo" => "Error en el formulario",
                            "texto" => "El nombre del método de cocción sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres",
                            "icono" => "error"
                        ];

                        /* Codifica la variable como datos JSON */
                        return json_encode($alerta);

                        /* Detiene la ejecución del script */
                        exit();
                    }

                    /* Limpia los datos para evitar SQL Injection */
                $nombre_metodo = $this->limpiarCadena($_POST['nombre_metodo']);

                /* Comprueba si el nombre del método de cocción ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM tecnicas WHERE nombre_tecnica='$nombre_metodo' AND id_tecnica !='$id'")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El método de cocción $nombre_metodo ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del metodo de cocción no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL MÉTODO DE COCCIÓN */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/metodos_photos/";

            /* Comrueba si hay imágenes en el input */
            if ($_FILES['foto_metodo']['name'] != "" && $_FILES['foto_metodo']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_metodo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_metodo']['tmp_name']) != "image/png") {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar la imagen.",
                        "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png".mime_content_type($_FILES['foto_metodo']['tmp_name']),
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica el tamaño de la imagen */
                if ($_FILES['foto_metodo']['size']/1024 > 5120) {
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
                $foto_metodo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_metodo);
                $foto_metodo = str_ireplace(" ", "_", $foto_metodo);
                $foto_metodo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_metodo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_metodo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_metodo .= ".png";
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
                if (is_file($img_dir.$datos['foto_tecnica'])) {
                    chmod($img_dir.$datos['foto_tecnica'], 0777);
                    unlink($img_dir.$datos['foto_tecnica']);
                }

                /* Sube la nueva imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_metodo']['tmp_name'], $img_dir.$foto_metodo)) {
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
                $foto_metodo = $datos['foto_tecnica'];
            }

            /* Actualiza la base de datos */
            $metodo_datos_up = [
                [
                    "campo_nombre"=>"nombre_tecnica",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_metodo
                ],
                [
                    "campo_nombre"=>"foto_tecnica",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_metodo
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_tecnica",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            /* Comprueba si se han insertado los datos */
            if ($this->actualizarDatos("tecnicas", $metodo_datos_up, $condicion)) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El método de cocción ".$nombre_metodo." ha sido atualizado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_metodo)) {
                    chmod($img_dir.$foto_metodo, 777);
                    unlink($img_dir.$foto_metodo);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);


            $mensaje = $foto_metodo;
            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"vas a actualizar el método con la foto ".$mensaje,
                "icono"=>"success"
            ];
            return json_encode($alerta);
            exit();            

        }

        /* ELIMINAR UN MÉTODO DE COCCIÓN */
        public function eliminarMetodoControlador(){

            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un método de cocción",
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
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un método de cocción",
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

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_metodo']);

            /* Verificar que el tipo existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM tecnicas WHERE id_tecnica='$id'");

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

            /* Elimina el método de cocción del sistema */
            $eliminarMetodo = $this->eliminarRegistro("tecnicas", "id_tecnica", $id);

            if ($eliminarMetodo->rowCount()==1) {
                if (is_file("../views/photos/metodos_photos/".$datos['foto_tecnica'])) {
                    chmod("../views/photos/metodos_photos/".$datos['foto_tecnica'], 0777);
                    unlink("../views/photos/metodos_photos/".$datos['foto_tecnica']);
                }
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Método de cocción eliminado",
                    "texto"=>"El método de cocción ".$datos['nombre_tecnica']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El método de cocción ".$datos['nombre_tecnica']." no ha podido ser eliminado",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);


            /* Comprobar que el controlador va funcionando */

            $mensaje = $datos['nombre_tecnica'];

            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"vas a eliminar el método con la foto ".$mensaje,
                "icono"=>"success"
            ];
            return json_encode($alerta);
            exit();

        }
    }