<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de grupo de platos para crear los objetos grupo */
    use app\models\grupoPlatoModel;

    /* Crea la clase hija de la clase principal */
    class grupoPlatoController extends mainModel{

        /* LISTAR LOS GRUPOS DE PLATOS */
        public function listarGruposPlatosControlador(){

            /* Ejecuta a búsqueda de grupos de plato */
            $grupos = $this->ejecutarConsulta("SELECT * FROM grupos_plato ORDER BY nombre_grupo");

            /* Convierte el resultado a array */
            if ($grupos->rowCount()>0) {
                $grupos = $grupos->fetchAll();
            }

            /* Crea un array para ir guardando los grupos */
            $lista_grupos = array();

            /* Recorre el array de datos para ir creando objetos e insertándolos en la lista de grupos */
            foreach ($grupos as $fila) {
                /* Crea una nueva instancia de grupo */
                $grupo = new grupoPlatoModel($fila['id_grupo']);

                /* Añade el grupo a la lista */
                array_push($lista_grupos, $grupo);
            }
            /* Devuelve la lista de grupos */
            return $lista_grupos;

        }

        /* GUARDAR UN GRUPO DE PLATOS */
        public function guardarGrupoPlatosControlador(){
            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un grupo de platos",
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
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un grupo de platos",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede añadir grupos de platos si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Recupera el nombre del grupo */
            if ($_POST['nombre_grupo']) {
                $nombre_grupo = $this->limpiarCadena($_POST['nombre_grupo']);

                /* Comprueba si el nombre del grupo ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM grupos_plato WHERE nombre_grupo = '$nombre_grupo' ")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El grupo de platos $nombre_grupo ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del grupo de platos no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL GRUPO DE PLATOS */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/groups_photos/";

            /* Comrueba si hay imágenes en el input */
            if ($_FILES['foto_grupo']['name'] != "" && $_FILES['foto_grupo']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_grupo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_grupo']['tmp_name']) != "image/png") {
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
                if ($_FILES['foto_grupo']['size']/1024 > 5120) {
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
                $foto_grupo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_grupo);
                $foto_grupo = str_ireplace(" ", "_", $foto_grupo);
                $foto_grupo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_grupo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_grupo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_grupo .= ".png";
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
                if (!move_uploaded_file($_FILES['foto_grupo']['tmp_name'], $img_dir.$foto_grupo)) {
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
                $foto_grupo = null;
            }
            
            /* Actualiza la base de datos */
            $grupo_datos_reg = [
                [
                    "campo_nombre"=>"nombre_grupo",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_grupo
                ],
                [
                    "campo_nombre"=>"foto_grupo",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_grupo
                ]
            ];

            $registrar_grupo = $this->guardarDatos("grupos_plato", $grupo_datos_reg);

            if ($registrar_grupo->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El grupo ".$nombre_grupo." ha sido registrado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_grupo)) {
                    chmod($img_dir.$foto_grupo, 777);
                    unlink($img_dir.$foto_grupo);
                }

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el grupo de platos en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }

        /* ACTUALIZAR UN GRUPO DE PLATOS */
        public function actualizarGrupoPlatosControlador(){

            /* Recupera el id del grupo */
            $id = $this->limpiarCadena($_POST['id_Form']);

            /* Verifica que el grupo existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM grupos_plato WHERE id_grupo='$id'");
            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El grupo de platos no existe",
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

            /* Recupera el nombre del grupo */
            if ($_POST['nombre_grupo']) {
                $nombre_grupo = $this->limpiarCadena($_POST['nombre_grupo']);

                /* Comprueba si el nombre del grupo ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM grupos_plato WHERE nombre_grupo='$nombre_grupo' AND id_grupo !='$id'")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El grupo de platos $nombre_grupo ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del grupo de platos no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* FOTO DEL GRUPO DE PLATOS */

            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/groups_photos/";

            /* Comrueba si hay imágenes en el input */
            if ($_FILES['foto_grupo']['name'] != "" && $_FILES['foto_grupo']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_grupo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_grupo']['tmp_name']) != "image/png") {
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
                if ($_FILES['foto_grupo']['size']/1024 > 5120) {
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
                $foto_grupo = iconv('UTF-8', 'ASCII//IGNORE', $nombre_grupo);
                $foto_grupo = str_ireplace(" ", "_", $foto_grupo);
                $foto_grupo .= "_".rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_grupo']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_grupo .= ".jpg";
                        break;
                    
                    case 'image/png':
                        $foto_grupo .= ".png";
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
                if (is_file($img_dir.$datos['foto_grupo'])) {
                    chmod($img_dir.$datos['foto_grupo'], 0777);
                    unlink($img_dir.$datos['foto_grupo']);
                }

                /* Sube la nueva imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_grupo']['tmp_name'], $img_dir.$foto_grupo)) {
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
                $foto_grupo = $datos['foto_grupo'];
            }
            
            /* Actualiza la base de datos */
            $grupo_datos_up = [
                [
                    "campo_nombre"=>"nombre_grupo",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_grupo
                ],
                [
                    "campo_nombre"=>"foto_grupo",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_grupo
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_grupo",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            /* Comprueba si se han insertado los datos */
            if ($this->actualizarDatos("grupos_plato", $grupo_datos_up, $condicion)) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El grupo ".$nombre_grupo." ha sido atualizado correctamente.",
                    "icono" => "success"
                ];
            } else {
                if (is_file($img_dir.$foto_grupo)) {
                    chmod($img_dir.$foto_grupo, 777);
                    unlink($img_dir.$foto_grupo);
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
        public function eliminarGrupoPlatosControlador(){

            /* Comprobar que el usuario es administrador */
            if (!$_SESSION['administrador']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes eliminar usuarios. No eres administrador del sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_grupo']);

            /* Verificar que el grupo existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM grupos_plato WHERE id_grupo='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el Grupo de Platos en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Elimina el grupo de platos del sistema */
            $eliminarGrupo = $this->eliminarRegistro("grupos_plato", "id_grupo", $id);

            if ($eliminarGrupo->rowCount()==1) {
                if (is_file("../views/photos/groups_photos/".$datos['foto_grupo'])) {
                    chmod("../views/photos/groups_photos/".$datos['foto_grupo'], 0777);
                    unlink("../views/photos/groups_photos/".$datos['foto_grupo']);
                }
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Grupo de platos eliminado",
                    "texto"=>"El grupo ".$datos['nombre_grupo']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El grupo ".$datos['nombre_grupo']." no ha podido ser eliminado",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }
    }