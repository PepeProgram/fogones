<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de usuario para crear los objetos usuario */
    use app\models\userModel;

    /* Crea la clase hija de la clase principal */
    class userController extends mainModel{

        /* REGISTRAR USUARIO */
        public function registrarUsuarioControlador(){

            /* Obtiene los datos del formulario utilizando la función limpiarCadena para evitar SQL injection */
            $nombre = $this->limpiarCadena($_POST['nombre_usuario']);
            $apellido1 = $this->limpiarCadena($_POST['ap1_usuario']);
            $apellido2 = $this->limpiarCadena($_POST['ap2_usuario']);
            $login = $this->limpiarCadena($_POST['login_usuario']);
            $clave1 = $this->limpiarCadena($_POST['clave_1_usuario']);
            $clave2 = $this->limpiarCadena($_POST['clave_2_usuario']);
            $email = $this->limpiarCadena($_POST['email_usuario']);
            $sobre = $this->limpiarCadena($_POST['sobre_usuario']);

            /* Verifica que están todos los campos obligatorios */
            if ($nombre == "" || $apellido1 == "" || $login == "" || $clave1 == "" || $clave2 == "" || $email == "") {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Rellene todos los campos obligatorios",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* VERIFICA LOS PATRONES DE LOS DATOS */
            
            /* Nombre */
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el NOMBRE",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Primer apellido */
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido1)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el PRIMER APELLIDO",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Segundo apellido */
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{0,40}", $apellido2)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el SEGUNDO APELLIDO",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Nombre de Usuario */
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $login)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el NOMBRE DE USUARIO",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Verifica que el usuario no existe */
            $check_usuario = $this->ejecutarConsulta("SELECT login_usuario FROM usuarios WHERE login_usuario='$login'");

            if ($check_usuario->rowCount()>0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error en el formulario",
                    "texto"=>"Ya hay un usuario con ese nombre.\n Por favor, elija otro.",
                    "icono"=>"error"
                ];
                /* Codifica la variable como datos JSON */
                return json_encode($alerta);
                /* Detiene la ejecución del script */
                exit();
            }

            
            /* Contraseñas */
            if ($this->verificarDatos("(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$", $clave1) || $this->verificarDatos("(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$", $clave2)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe las CONTRASEÑAS",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Contraseñas iguales */
            if ($clave1 != $clave2) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe las CONTRASEÑAS",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            } else {
                /* Encripta la clave */
                $clave = password_hash($clave1, PASSWORD_BCRYPT, ["cost" => 10]);
            }

            /* Correo electrónico */
            if ($email != "") {

                /* Verifica que el correo es válido */
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    /* Verifica que el correo no existe */
                    $check_mail = $this->ejecutarConsulta("SELECT email_usuario FROM usuarios WHERE email_usuario='$email'");
                    if ($check_mail->rowCount()>0) {
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error en el formulario",
                            "texto"=>"Ya hay un usuario con ese correo electrónico",
                            "icono"=>"error"
                        ];
                        /* Codifica la variable como datos JSON */
                        return json_encode($alerta);
                        /* Detiene la ejecución del script */
                        exit();
                    }
                } else {

                    /* Establece los valores para llamar al ajax.js para sacar la ventana de alerta */
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"Error en el formulario",
                        "texto"=>"Debe introducir un correo electrónico válido",
                        "icono"=>"error"
                    ];
                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);
                    /* Detiene la ejecución del script */
                    exit();
                }
                
            }

            /* FOTO DEL USUARIO SI LA HA PUESTO */
            
            /* Establece el directorio de imágenes */
            $img_dir = "../views/photos/user_photos/";

            /* Comprueba si hay imagen en el input */
            if ($_FILES['foto_usuario']['name'] != "" && $_FILES['foto_usuario']['size']>0) {
                
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

                /* Comprobar el formato de la imagen */
                if (mime_content_type($_FILES['foto_usuario']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_usuario']['tmp_name']) != "image/png") {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error de imagen.",
                        "texto" => "El formato de imagen no está permitido",
                        "icono" => "error"
                    ];
    
                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);
    
                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Verifica el tamaño del archivo de imagen */
                if (($_FILES['foto_usuario']['size']/1024) > 5120) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error de imagen.",
                        "texto" => "El tamaño del archivo de imagen es mayor del permitido (5 Mb)",
                        "icono" => "error"
                    ];
    
                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);
    
                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Define el nuevo nombre de la imagen sustituyendo espacios en el nombre del usuario por "_" y añadiendo un número aleatorio antes de la extensión */
                $foto = str_ireplace(" ", "_", $login);
                $foto .= "_".rand(0, 10000);

                /* Coloca la extensión al archivo de imagen dependiendo de su tipo */
                switch (mime_content_type($_FILES['foto_usuario']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto .= ".jpg";
                        break;
                    case 'image/png':
                        $foto .= ".png";
                        break;
                }

                /* Establece permisos en el directorio de fotos */
                chmod($img_dir, 0777);

                /* Sube el archivo al directorio de fotos */
                if (!move_uploaded_file($_FILES['foto_usuario']['tmp_name'], $img_dir.$foto)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error al guardar la imagen.",
                        "texto" => "No se ha podido guardar su foto, pero su registro se producirá igualmente.\nIntente cambiarla más tarde.",
                        "icono" => "error"
                    ];
    
                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene el script */
                    exit();
    
                }

            } else {
                $foto = "";
            }
            
            /* Construye el array de datos para enviar al modelo principal y registrar los datos */
            $usuario_datos_reg = [
                [
                    "campo_nombre"=>"nombre_usuario",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                [
                    "campo_nombre"=>"ap1_usuario",
                    "campo_marcador"=>":Apellido1",
                    "campo_valor"=>$apellido1
                ],
                [
                    "campo_nombre"=>"ap2_usuario",
                    "campo_marcador"=>":Apellido2",
                    "campo_valor"=>$apellido2
                ],
                [
                    "campo_nombre"=>"login_usuario",
                    "campo_marcador"=>":Login",
                    "campo_valor"=>$login
                ],
                [
                    "campo_nombre"=>"clave_usuario",
                    "campo_marcador"=>":Clave",
                    "campo_valor"=>$clave
                ],
                [
                    "campo_nombre"=>"email_usuario",
                    "campo_marcador"=>":Email",
                    "campo_valor"=>$email
                ],
                [
                    "campo_nombre"=>"foto_usuario",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto
                ],
                [
                    "campo_nombre"=>"sobre_usuario",
                    "campo_marcador"=>":Sobre",
                    "campo_valor"=>$sobre
                ],
                [
                    "campo_nombre"=>"creado_usuario",
                    "campo_marcador"=>":Creado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ],
                [
                    "campo_nombre"=>"actualizado_usuario",
                    "campo_marcador"=>":Actualizado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ],

            ];

            /* Guarda el usuario llamando al método del mainModel */
            $registrar_usuario = $this->guardarDatos("usuarios", $usuario_datos_reg);

            /* Comprueba si se han insertado los datos */
            if ($registrar_usuario->rowCount() == 1) {
                /* Ventana de Éxito y limpia el formulario */
                $alerta = [
                    "tipo" => "limpiarRegistro",
                    "titulo" => "Felicidades!!!",
                    "texto" => "El usuario ".$nombre." ".$apellido1." ha sido registrado correctamente.",
                    "icono" => "success"
                ];

            } else {
                /* Elimina el archivo de foto que hemos subido al servidor si no se ha podido registrar el usuario */
                if (is_file($img_dir.$foto)) {
                    chmod($img_dir.$foto, 777);
                    unlink($img_dir.$foto);
                }

                /* Muestra la ventana de error */
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error inesperado",
                    "texto"=>"No hemos podido registrar el usuario. Por favor, inténtelo de nuevo más tarde.",
                    "icono"=>"error"
                ];
            }
            
            /* Devuelve la ventana de información */
            return json_encode($alerta);
            
        }

        /* LISTAR TODOS LOS USUARIOS */
        public function listarUsuariosControlador(){
            
            $vista_actual = explode("/", $_SERVER['REQUEST_URI']);

            /* Comprueba si hay algo después de la vista usuarios para listar todos, los redactores o los administradores */
            if (isset($vista_actual[3]) && $vista_actual[3] != "") {
                $vista_actual = $this->limpiarCadena($vista_actual[3]);
                switch ($vista_actual) {
                    case 'redactores':
                        echo '
                            <tr>
                                <th class="headerUserTitle" colspan="7"><h3>Redactores</h3></th>
                            </tr>
                            ';

                        /* Crea la búsqueda de los redactores */
                        $consulta = "SELECT * FROM usuarios WHERE id_usuario IN (SELECT id_usuario FROM redactores)";
                        break;

                    case 'revisores':
                        echo '
                            <tr>
                                <th class="headerUserTitle" colspan="7"><h3>Revisores</h3></th>
                            </tr>
                            ';

                        /* Crea la búsqueda de los redactores */
                        $consulta = "SELECT * FROM usuarios WHERE id_usuario IN (SELECT id_usuario FROM revisores)";
                        break;
                    
                    case 'administradores':
                        echo '
                            <tr>
                                <th class="headerUserTitle" colspan="7"><h3>Administradores</h3></th>
                            </tr>
                            ';

                        /* Crea la búsqueda de los administradores */
                        $consulta = "SELECT * FROM usuarios WHERE id_usuario IN (SELECT id_usuario FROM administradores)";
                        break;
                    
                    default:
                        echo '
                            <tr>
                                <th class="headerUserTitle" colspan="7"><h3>Todos los usuarios</h3></th>
                            </tr>
                            ';

                        /* Crea la búsqueda de todos los usuarios si han introducido cualquier otra cosa después de la url */
                        $consulta = "SELECT * FROM usuarios";
                        break;
                }
            } else {
                echo '
                    <tr>
                        <th class="headerUserTitle" colspan="7"><h3>Todos los usuarios</h3></th>
                    </tr>
                    ';
                /* Crea la búsqueda de todos los usuarios */
                $consulta = "SELECT * FROM usuarios";
            }


            /* Ejecuta la búsqueda */
            $datos = $this->ejecutarConsulta($consulta);

            /* Convierte el resultado a array */
            if ($datos->rowCount()>0) {
                $datos = $datos->fetchAll();
            }

            /* Crea un nuevo array para guardar todos los usuarios */
            $lista_usuarios = array();
            /* Recorre todo el array de datos para insertar en la tabla */

            foreach($datos as $fila){
                
                /* Construye la búsqueda para ver si el usuario es redactor */
                $consulta_redactor = "SELECT * FROM redactores WHERE id_usuario = ".$fila['id_usuario'];

                /* Comprueba si el usuario está en la tabla de redactores */
                if ($this->ejecutarConsulta($consulta_redactor)->rowCount()>0) {
                    $redactor = true;
                } else {
                    $redactor = false;
                }

                /* Construye la búsqueda para ver si el usuario es administrador */
                $consulta_administrador = "SELECT * FROM administradores WHERE id_usuario = ".$fila['id_usuario'];

                /* Comprueba si el usuario está en la tabla de Administradores */
                if ($this->ejecutarConsulta($consulta_administrador)->rowCount()>0) {
                    $administrador = true;
                } else {
                    $administrador = false;
                }

                /* Crea una nueva instancia de usuario */
                $usuario = new userModel($fila['id_usuario'], $fila['nombre_usuario'], $fila['ap1_usuario'], $fila['ap2_usuario'], $fila['login_usuario'], $fila['clave_usuario'], $fila['email_usuario'], $fila['sobre_usuario'], $fila['foto_usuario'], $fila['creado_usuario'], $fila['actualizado_usuario']);
                
                array_push($lista_usuarios, $usuario);
                
            }
            return $lista_usuarios;
        }

        /* ELIMINAR USUARIOS */
        public function eliminarUsuarioControlador(){

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
            $id = $this->limpiarCadena($_POST['id_usuario']);

            /* Comprobar que no se está borrando a si mismo */
            if ($id==$_SESSION['id']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes eliminarte a ti mismo. Solicita a otro administrador que te elimine",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verificar que el usuario existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el usuario en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Elimina el usuario del sistema */
            $eliminarUsuario = $this->eliminarRegistro("usuarios", "id_usuario", $id);

            if ($eliminarUsuario->rowCount()==1) {
                if (is_file("../views/photos/user_photos/".$datos['foto_usuario'])) {
                    chmod("../views/photos/user_photos/".$datos['foto_usuario'], 0777);
                    unlink("../views/photos/user_photos/".$datos['foto_usuario']);
                }
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Usuario eliminado",
                    "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no ha podido ser eliminado",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }
        
        /* NOMBRAR O QUITAR REDACTOR */
        public function cambiarRedactorUsuarioControlador(){
            
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
            $id = $this->limpiarCadena($_POST['id_usuario']);
            
            /* Comprobar que no se está cambiando a si mismo */
            if ($id==$_SESSION['id']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes cambiar tu propio rol. Solicita a otro administrador que lo haga",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verificar el usuario */
            $datos=$this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el usuario en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }
            
            /* Verificar si el usuario es redactor o no */
            $check_redactor = $this->ejecutarConsulta("SELECT * FROM redactores WHERE id_usuario='$id'");

            if ($check_redactor->rowCount()>0) {

                /* Elimina el usuario de redactores */
                $eliminarRedactor = $this->eliminarRegistro("redactores", "id_usuario", $id);

                /* Comprueba que se ha eliminado correctamente */
                if ($eliminarRedactor->rowCount()==1) {
                    $alerta = [
                        "tipo"=>"recargar",
                        "titulo"=>"Usuario eliminado de redactores",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." ha sido eliminado de redactores",
                        "icono"=>"success"
                    ];
                } else {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no ha podido ser eliminado de redactores. Inténtelo más tarde",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
                
            } else {
                
                /* Crea el array para guardar los datos */
                $redactor = [
                    [
                        "campo_nombre"=>"id_usuario",
                        "campo_marcador"=>":Nombre",
                        "campo_valor"=>$id
                    ]
                ];

                /* Añade al usuario a redactores */
                $agregarRedactor = $this->guardarDatos("redactores", $redactor);

                /* Comprueba que se ha guardado correctamente */
                if ($agregarRedactor->rowCount()==1) {
                    $alerta = [
                        "tipo"=>"recargar",
                        "titulo"=>"Usuario añadido a redactores",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." ha sido añadido a redactores",
                        "icono"=>"success"
                    ];
                } else {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no ha podido ser añadido a redactores. Inténtelo más tarde",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
            }
        }
        
        /* NOMBRAR O QUITAR REVISOR */
        public function cambiarRevisorUsuarioControlador(){
            
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
            $id = $this->limpiarCadena($_POST['id_usuario']);
            
            /* Comprobar que no se está cambiando a si mismo */
            if ($id==$_SESSION['id']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes cambiar tu propio rol. Solicita a otro administrador que lo haga",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verificar el usuario */
            $datos=$this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el usuario en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }
            
            /* Verificar si el usuario es revisor o no */
            $check_revisor = $this->ejecutarConsulta("SELECT * FROM revisores WHERE id_usuario='$id'");

            if ($check_revisor->rowCount()>0) {

                /* Elimina el usuario de revisores */
                $eliminarRevisor = $this->eliminarRegistro("revisores", "id_usuario", $id);

                /* Comprueba que se ha eliminado correctamente */
                if ($eliminarRevisor->rowCount()==1) {
                    $alerta = [
                        "tipo"=>"recargar",
                        "titulo"=>"Usuario eliminado de revisores",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." ha sido eliminado de revisores",
                        "icono"=>"success"
                    ];
                } else {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no ha podido ser eliminado de redactores. Inténtelo más tarde",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
                
            } else {
                
                /* Crea el array para guardar los datos */
                $revisor = [
                    [
                        "campo_nombre"=>"id_usuario",
                        "campo_marcador"=>":Nombre",
                        "campo_valor"=>$id
                    ]
                ];

                /* Añade al usuario a revisores */
                $agregarRevisor = $this->guardarDatos("revisores", $revisor);

                /* Comprueba que se ha guardado correctamente */
                if ($agregarRevisor->rowCount()==1) {
                    $alerta = [
                        "tipo"=>"recargar",
                        "titulo"=>"Usuario añadido a revisores",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." ha sido añadido a revisores",
                        "icono"=>"success"
                    ];
                } else {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no ha podido ser añadido a revisores. Inténtelo más tarde",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
            }
        }
        
        /* NOMBRAR O QUITAR ADMINISTRADOR */
        public function cambiarAdministradorUsuarioControlador(){
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
            $id = $this->limpiarCadena($_POST['id_usuario']);
            
            /* Comprobar que no se está cambiando a si mismo */
            if ($id==$_SESSION['id']) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No puedes cambiar tu propio rol. Solicita a otro administrador que lo haga",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* Verificar el usuario */
            $datos=$this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario='$id'");
            
            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el usuario en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Verificar si el usuario es administrador o no */
            $check_administrador = $this->ejecutarConsulta("SELECT * FROM administradores WHERE id_usuario='$id'");

            if ($check_administrador->rowCount()>0) {

                /* Elimina el usuario de administradores */
                $eliminarAdministrador = $this->eliminarRegistro("administradores", "id_usuario", $id);

                /* Comprueba que se ha eliminado correctamente */
                if ($eliminarAdministrador->rowCount()==1) {
                    $alerta = [
                        "tipo"=>"recargar",
                        "titulo"=>"Usuario eliminado de administradores",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." ha sido eliminado de administradores",
                        "icono"=>"success"
                    ];
                } else {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no ha podido ser eliminado de administradores. Inténtelo más tarde",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
                
            } else {
                
                /* Crea el array para guardar los datos */
                $administrador = [
                    [
                        "campo_nombre"=>"id_usuario",
                        "campo_marcador"=>":Id",
                        "campo_valor"=>$id
                    ]
                ];
                
                /* Añade al usuario a administradores */
                $agregarAdministrador = $this->guardarDatos("administradores", $administrador);
                
                /* Comprueba que se ha guardado correctamente */
                if ($agregarAdministrador->rowCount()==1) {
                    $alerta = [
                        "tipo"=>"recargar",
                        "titulo"=>"Usuario añadido a administradores",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." ha sido añadido a administradores",
                        "icono"=>"success"
                    ];
                } else {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"El usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no ha podido ser añadido a administradores. Inténtelo más tarde",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
            }


            
        }

        /* ACTUALIZAR USUARIOS */
        public function actualizarUsuarioControlador(){
            /* Recuperar id del usuario */
            $id = $this->limpiarCadena($_POST['id_usuario']);

            /* Verificar que el usuario existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario='$id'");

            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El usuario $id no existe",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Comprobar que ha puesto usuario y contraseña */
            $login_usuario = $this->limpiarCadena($_POST['login_usuario']);
            $login_clave = $this->limpiarCadena($_POST['login_clave']);

            if ($login_usuario == "" || $login_clave == "") {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"No se puede actualizar",
                    "texto"=>"Introduzca su nombre de usuario y su clave",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verificar que el login coincide con el patrón requerido */
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}", $login_usuario)) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"No se puede actualizar",
                    "texto"=>"Compruebe el NOMBRE DE USUARIO",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verificar que la contraseña coincide con el patrón requerido */
            if ($this->verificarDatos("(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$", $login_clave)) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"No se puede actualizar",
                    "texto"=>"Compruebe que ha introducido la CLAVE correctamente",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verifica que el usuario que está enviando la actualización existe */
            $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='$login_usuario' AND id_usuario='".$_SESSION['id']."'");

            if ($check_user->rowCount()==1) {
                $check_user = $check_user->fetch();

                /* Verifica que usuario y contraseña son correctos */
                if ($check_user['login_usuario']!=$login_usuario || !password_verify($login_clave, $check_user['clave_usuario'])) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"No se puede actualizar",
                        "texto"=>"Verifique su NOMBRE DE USUARIO o su CONTRASEÑA",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica si la cuenta es propia o de otro usuario */
                if ($id != $check_user['id_usuario']) {
                    
                    /* Verifica si el usuario es administrador */
                    $check_admin = $this->ejecutarConsulta("SELECT * FROM administradores WHERE id_usuario='".$check_user['id_usuario']."'");
                    
                    if ($check_admin->rowCount()<=0) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"No se puede actualizar",
                            "texto"=>"No puede actualizar una cuenta ajena si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
            
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"No se puede actualizar",
                    "texto"=>"Verifique su NOMBRE DE USUARIO o su CONTRASEÑA",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* Recupera datos del formulario */
            $nombre = $this->limpiarCadena($_POST['nombre_usuario']);
            $apellido1 = $this->limpiarCadena($_POST['ap1_usuario']);
            $apellido2 = $this->limpiarCadena($_POST['ap2_usuario']);
            $email = $this->limpiarCadena($_POST['email_usuario']);
            $clave1 = $this->limpiarCadena($_POST['clave_1_usuario']);
            $clave2 = $this->limpiarCadena($_POST['clave_2_usuario']);
            $sobre = $this->limpiarCadena($_POST['sobre_usuario']);

            /* Verifica que están todos los campos obligatorios */
            if ($nombre == "" || $apellido1 == "" || $email == "") {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error en el formulario",
                    "texto"=>"Rellene todos los campos obligatorios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verifica que el nombre coincide con el patrón */
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error en el formulario",
                    "texto"=>"Compruebe el NOMBRE",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* Verifica que el primer apellido coincide con el patrón */
            if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido1)) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error en el formulario",
                    "texto"=>"Compruebe el PRIMER APELLIDO",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verifica que el segundo apellido, si existe, coincide con el patrón */
            if ($apellido2 != "" && $this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido2)) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error en el formulario",
                    "texto"=>"Compruebe el SEGUNDO APELLIDO",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verifica si se ha cambiado el email */
            if ($email != $datos['email_usuario']) {
                
                /* Verifica que el email es válido si se ha cambiado */
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    
                    /* Verifica que el correo electrónico no existe */
                    $check_mail = $this->ejecutarConsulta("SELECT email_usuario FROM usuarios WHERE email_usuario='$email'");

                    if ($check_mail->rowCount()>0) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Error en el formulario",
                            "texto"=>"Ya hay otro usuario con ese correo electrónico",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                    
                } else {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error en el formulario",
                        "texto"=>"Debe introducir un correo electrónico válido",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }

            /* Verifica si se han cambiado las claves */
            if ($clave1 != "" || $clave2 != "") {
                
                /* Verifica que las claves coinciden con el formato si se cambian */
                if ($this->verificarDatos("(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$", $clave1) || $this->verificarDatos("(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$", $clave2)) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error en el formulario",
                        "texto"=>"El formato de la contraseña no es correcto",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {

                    /* Comprueba si las claves son iguales */
                    if ($clave1 != $clave2) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Error en el formulario",
                            "texto"=>"Las claves no coinciden",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    } else {
                        /* Encripta la clave */
                        $clave = password_hash($clave1, PASSWORD_BCRYPT. ["cost"=>10]);
                    }
                    
                }
                
            } else {
                $clave = $datos['clave_usuario'];
            }

            /* Array de datos que se envía para actualizar los datos del usuario */
            $usuario_datos_up = [
                [
                    "campo_nombre"=>"nombre_usuario",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                [
                    "campo_nombre"=>"ap1_usuario",
                    "campo_marcador"=>":Ap1",
                    "campo_valor"=>$apellido1
                ],
                [
                    "campo_nombre"=>"ap2_usuario",
                    "campo_marcador"=>":Ap2",
                    "campo_valor"=>$apellido2
                ],
                [
                    "campo_nombre"=>"email_usuario",
                    "campo_marcador"=>":Email",
                    "campo_valor"=>$email
                ],
                [
                    "campo_nombre"=>"sobre_usuario",
                    "campo_marcador"=>":Sobre",
                    "campo_valor"=>$sobre
                ],
                [
                    "campo_nombre"=>"clave_usuario",
                    "campo_marcador"=>":Clave",
                    "campo_valor"=>$clave
                ],
                [
                    "campo_nombre"=>"actualizado_usuario",
                    "campo_marcador"=>":Actualizado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ]
            ];

            /* Array para establecer la condición para actualizar el usuario seleccionado */

            $condicion = [
                "condicion_campo"=>"id_usuario",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];
            
            /* Llama al modelo principal para actualizar los datos */
            if ($this->actualizarDatos("usuarios", $usuario_datos_up, $condicion)) {
                
                /* Actualiza la sesión si está actualizando la propia cuenta */
                if ($id == $_SESSION['id']) {
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellido1'] = $apellido1;
                    $_SESSION['apellido2'] = $apellido2;
                }

                /* Ventana de éxito en la actualización */
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Felicidades!!!",
                    "texto"=>"El usuario ".$nombre." ".$apellido1." ha sido actualizado",
                    "icono"=>"success"
                ];
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error inesperado",
                    "texto"=>"No hemos podido actualizar los datos. Por favor, inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }

        /* ELIMINAR LA FOTO DEL USUARIO */
        public function eliminarFotoUsuarioControlador(){

            /* Recuperar el id del usuario a cambiar la foto */
            $id = $this->limpiarCadena($_POST['id_usuario']);

            /* Verifica que el usuario existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario = '$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al eliminar la foto.",
                    "texto"=>"El usuario solicitado no existe",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit;
            } else {
                $datos = $datos->fetch();
            }

            /* Verifica que el usuario que está enviando la actualización existe */
            $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario='".$_SESSION['id']."'");

            if ($check_user->rowCount()==1) {
                $check_user = $check_user->fetch();

                /* Verifica si la cuenta es propia o de otro usuario */
                if ($id != $check_user['id_usuario']) {
                    
                    /* Verifica si el usuario es administrador */
                    $check_admin = $this->ejecutarConsulta("SELECT * FROM administradores WHERE id_usuario='".$check_user['id_usuario']."'");
                    
                    if ($check_admin->rowCount()<=0) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Error al eliminar la foto",
                            "texto"=>"No puede eliminar una foto ajena si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
            
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al eliminar la foto",
                    "texto"=>"Inicie sesión primero con su nombre de usuario y contraseña",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Directorio de imágenes */
            $img_dir = "../views/photos/user_photos/";

            /* Permisos del directorio */
            chmod($img_dir, 0777);

            /* Verifica que existe el archivo de foto */
            if (is_file($img_dir.$datos['foto_usuario'])) {
                
                /* Permisos del archivo de foto */
                chmod($img_dir.$datos['foto_usuario'], 0777);
                
                /* Borra el archivo */
                if (!unlink($img_dir.$datos['foto_usuario'])) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error al eliminar la foto",
                        "texto"=>"Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al eliminar la foto",
                    "texto"=>"No se ha podido encontrar la foto del usuario en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* Actualiza la base de datos */
            $usuario_datos_up = [
                [
                    "campo_nombre"=>"foto_usuario",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>""
                ],
                [
                    "campo_nombre"=>"actualizado_usuario",
                    "campo_marcador"=>":Actualizado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_usuario",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            if ($this->actualizarDatos("usuarios", $usuario_datos_up, $condicion)) {
                /* Actualiza la sesión si está borrando la foto del propio usuario */
                if ($id==$_SESSION['id']) {
                    $_SESSION['foto'] = "";
                }

                /* Recarga la página con ventana de alerta */
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Foto eliminada!!!",
                    "texto"=>"Fotografía del usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." eliminada correctamente",
                    "icono"=>"success"
                ];
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al eliminar la foto",
                    "texto"=>"No se ha podido eliminar la foto de ".$datos['nombre_usuario']." ".$datos['ap1_usuario'].". Inténtelo de nuevo más tarde.",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);


            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"vas a eliminar la foto de un usuario",
                "icono"=>"success"
            ];
            return json_encode($alerta);
            exit();
        }
        
        /* ACTUALIZAR LA FOTO DEL USUARIO */
        public function actualizarFotoUsuarioControlador(){
            
            /* Recuperar el id del usuario a cambiar la foto */
            $id = $this->limpiarCadena($_POST['id_usuario']);

            /* Verifica que el usuario existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario = '$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al actualizar la foto.",
                    "texto"=>"El usuario solicitado no existe",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit;
            } else {
                $datos = $datos->fetch();
            }

            /* Verifica que el usuario que está enviando la actualización existe */
            $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE id_usuario='".$_SESSION['id']."'");

            if ($check_user->rowCount()==1) {
                $check_user = $check_user->fetch();

                /* Verifica si la cuenta es propia o de otro usuario */
                if ($id != $check_user['id_usuario']) {
                    
                    /* Verifica si el usuario es administrador */
                    $check_admin = $this->ejecutarConsulta("SELECT * FROM administradores WHERE id_usuario='".$check_user['id_usuario']."'");
                    
                    if ($check_admin->rowCount()<=0) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Error al actualizar la foto",
                            "texto"=>"No puede actualizar una foto ajena si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
            
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al actualizar la foto",
                    "texto"=>"Inicie sesión primero con su nombre de usuario y contraseña",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* directorio de imágenes */
            $img_dir = "../views/photos/user_photos/";

            /* Verifica que se ha seleccionado una foto */
            if ($_FILES['foto_usuario']['name'] == "" && $_FILES['foto_usuario']['name']<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al actualizar la foto",
                    "texto"=>"Debe seleccionar un archivo de imagen para enviar",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verifica el formato de las imágenes */
            if (mime_content_type($_FILES['foto_usuario']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_usuario']['tmp_name']) != "image/png") {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al actualizar la foto",
                    "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Verifica el tamaño de la imagen */
            if ($_FILES['foto_usuario']['size']/1024 > 5120) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al actualizar la foto",
                    "texto"=>"El tamaño del archivo de imagen es mayor que el permitido (5 Mb)",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Crea el directorio de imágenes si no está creado */
            if(!file_exists($img_dir)){
                if (!mkdir($img_dir, 0777)) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error inesperado",
                        "texto"=>"No se ha podido crear el directorio de imágenes. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }

            /* Define el nuevo nombre del archivo de imagen */
            $foto = str_ireplace(" ", "_", $datos['login_usuario']);
            $foto .= "_".rand(0,100);
            

            /* Pone la extensión al archivo de imagen */
            switch (mime_content_type($_FILES['foto_usuario']['tmp_name'])) {
                case 'image/jpeg':
                    $foto .= ".jpg";
                    break;
                
                case 'image/png':
                    $foto .= ".png";
                    break;
            }

            /* Permisos del directorio de fotos por si acaso */
            chmod($img_dir, 0777);

            /* Sube el archivo al directorio de fotos */
            if (!move_uploaded_file($_FILES['foto_usuario']['tmp_name'], $img_dir.$foto)) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error al actualizar la foto",
                    "texto"=>"No se ha podido guardar la imagen. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Elimina la imagen anterior si la había pero la extensión es distinta */
            if (is_file($img_dir.$datos['foto_usuario']) && $datos['foto_usuario']!=$foto) {
                chmod($img_dir.$datos['foto_usuario'], 0777);
                unlink($img_dir.$datos['foto_usuario']);
            }

            /* Actualizar la base de datos */
            $usuario_datos_up = [
                [
                    "campo_nombre"=>"foto_usuario",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto
                ],
                [
                    "campo_nombre"=>"actualizado_usuario",
                    "campo_marcador"=>":Actualizado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_usuario",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            if ($this->actualizarDatos("usuarios", $usuario_datos_up, $condicion)) {
                /* Actualiza la sesión si se cambia la propia cuenta */
                if ($id == $_SESSION['id']) {
                    $_SESSION['foto'] = $foto;
                }

                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Felicidades!!!",
                    "texto"=>"Foto del usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." actualizada correctamente",
                    "icono"=>"success"
                ];
            } else {
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Error al actualizar su imagen",
                    "texto"=>"La foto del usuario ".$datos['nombre_usuario']." ".$datos['ap1_usuario']." no se ha podido actualizar en este momento",
                    "icono"=>"success"
                ];
            }
            return json_encode($alerta);
            

            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"vas a cambiar la foto de un usuario",
                "icono"=>"success"
            ];
            return json_encode($alerta);
            exit();
        }
    }