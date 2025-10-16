<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Carga los scripts js */
    /* require_once "../views/inc/script.php"; */

    /* usa el controlador de usuario */
    use app\controllers\userController;

    /* usa el controlador de login */
    use app\controllers\loginController;

    /* Comprueba si se viene desde el módulo de usuario */
    if (isset($_POST['modulo_usuario'])) {
        
        /* LLama al controlador de usuario creando una instancia del controlador de usuario */
        $insUsuario = new userController();

        /* LLama al controlador de login creando una instancia del controlador de login */
        # $insLogin = new loginController();
        
        /* Comprueba de qué formulario viene el hidden */
        switch ($_POST['modulo_usuario']) {
            case 'registrar':
                echo $insUsuario->registrarUsuarioControlador();
                break;
            
            case 'eliminar':
                echo $insUsuario->eliminarUsuarioControlador();
                break;
            
            case 'actualizar':
                echo $insUsuario->actualizarUsuarioControlador();
                break;
            
            case 'cambiarRedactor':
                echo $insUsuario->cambiarRedactorUsuarioControlador();
                break;
                
            case 'cambiarAdministrador':
                echo $insUsuario->cambiarAdministradorUsuarioControlador();
                break;
                
            case 'eliminarFoto':
                echo $insUsuario->eliminarFotoUsuarioControlador();
                break;

            case 'actualizarFoto':
                echo $insUsuario->actualizarFotoUsuarioControlador();
                break;

            case 'entrar':
                echo $insLogin->iniciarSesionControlador();
                break;


            default:
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Error al procesar los datos",
                    "texto"=>"Se ha producido un error inesperado. Inténtelo de nuevo",
                    "icono"=>"error"
                ];
                echo json_encode($alerta);
                exit();
                break;
        }
        /* Si no viene del módulo usuario, destruye la sesión y a la calle. */
    } else {
        session_destroy();
        header("Location: ".APP_URL."principal/");
    }
    



