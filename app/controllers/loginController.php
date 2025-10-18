<?php
    
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Crea la clase hija de la clase principal */
    class loginController extends mainModel{

        /* Controlador Iniciar Sesión */
        public function iniciarSesionControlador(){
            
            /* Obtiene los datos del formulario utilizando la función limpiarCadena para evitar SQL injection */
            $usuario = $this->limpiarCadena($_POST['login_usuario']);
            $clave = $this->limpiarCadena($_POST['login_clave']);

            /* Verifica que los datos no están vacíos */
            if ($usuario == "" || $clave == "") {
                /* Muestra la ventana de alerta */
                echo "
                    <script>
                        textoAlerta = {
                            tipo: 'simple',
                            icono: 'error',
                            titulo: 'Error de autenticación',
                            texto: 'Rellene usuario y contraseña',
                            confirmButtonText: 'Aceptar',
                            colorIcono: 'red'};
                        ventanaModal(textoAlerta);
                    </script>
                ";
            } else {

                /* Verifica que los datos coinciden con los patrones */
                if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario) || $this->verificarDatos("(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$", $clave)) {
                    
                    /* Muestra la ventana de alerta */
                    echo "
                        <script>
                            textoAlerta = {
                                tipo: 'simple',
                                icono: 'error',
                                titulo: 'Error de autenticación',
                                texto: 'Compruebe que el nombre de usuario y la clave coinciden con el formato solicitado',
                                confirmButtonText: 'Aceptar',
                                colorIcono: 'red'};
                            ventanaModal(textoAlerta);
                        </script>
                    ";
                } else {
                    
                    /* Consulta a la base de datos el usuario */
                    $check_usuario = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario = '$usuario'");

                    /* Comprueba si existe el usuario */
                    if ($check_usuario->rowCount()>0) {
                        
                        /* Convierte a array el resultado de la consulta */
                        $check_usuario = $check_usuario->fetch();

                        /* Comprueba si el password encriptado en la base de datos con password_hash es igual al introducido */
                        if ($check_usuario['login_usuario'] == $usuario && password_verify($clave, $check_usuario['clave_usuario'])) {

                            /* Establece la sesión con los datos de usuario */
                            $_SESSION['id'] = $check_usuario['id_usuario'];
                            $_SESSION['nombre'] = $check_usuario['nombre_usuario'];
                            $_SESSION['apellido1'] = $check_usuario['ap1_usuario'];
                            $_SESSION['apellido2'] = $check_usuario['ap2_usuario'];
                            $_SESSION['login'] = $check_usuario['login_usuario'];
                            $_SESSION['foto'] = $check_usuario['foto_usuario'];
                            
                            /* Comprueba si el usuario es redactor */
                            $check_redactor = $this->ejecutarConsulta("SELECT * FROM redactores WHERE id_usuario = ".$check_usuario['id_usuario']);
                            if ($check_redactor->rowCount()>0) {
                                $_SESSION['redactor'] = true;
                            } else {
                                $_SESSION['redactor'] = false;
                            }

                            /* Comprueba si el usuario es revisor */
                            $check_revisor = $this->ejecutarConsulta("SELECT * FROM revisores WHERE id_usuario = ".$check_usuario['id_usuario']);
                            if ($check_revisor->rowCount()>0) {
                                $_SESSION['revisor'] = true;
                            } else {
                                $_SESSION['revisor'] = false;
                            }

                            /* Comprueba si el usuario es administrador */
                            $check_admin = $this->ejecutarConsulta("SELECT * FROM administradores WHERE id_usuario = ".$check_usuario['id_usuario']);
                            if ($check_admin->rowCount()>0) {
                                $_SESSION['administrador'] = true;
                            } else {
                                $_SESSION['administrador'] = false;
                            }

                            /* Comprueba los encabezados para redirigir con php o con javascript */
                            if(headers_sent()){
                                echo "<script>window.location.href='".APP_URL."'</script>";
                            } else {
                                header("Location: ".APP_URL);
                            }
                            

                        } else {
                            /* Muestra la ventana de alerta si la contraseña no coincide */
                            echo "
                                <script>
                                    textoAlerta = {
                                        tipo: 'simple',
                                        icono: 'error',
                                        titulo: 'Error de autenticación',
                                        texto: 'Usuario o contraseña incorrectos',
                                        confirmButtonText: 'Aceptar',
                                        colorIcono: 'red'};
                                    ventanaModal(textoAlerta);
                                </script>
                            "; 
                        }

                    } else {
                        /* Muestra la ventana de alerta si el usuario no existe */
                        echo "
                            <script>
                                textoAlerta = {
                                    tipo: 'simple',
                                    icono: 'error',
                                    titulo: 'Error de autenticación',
                                    texto: 'El usuario o la contraseña son incorrectos',
                                    confirmButtonText: 'Aceptar',
                                    colorIcono: 'red'};
                                ventanaModal(textoAlerta);
                            </script>
                        ";
                    }
                    
                }
                
                
            }
            
        }

        /* Controlador Cerrar Sesión */
        public function cerrarSesionControlador(){
            /* Elimina la sesión */
            session_destroy();

            /* Comprueba si los encabezados se han enviado para redirigir con php o con javascript */
            if (headers_sent()) {
                echo"<script>window.location.href='".APP_URL."'</script>";
            } else {
                header("Location: ".APP_URL);
            }

        }
    }