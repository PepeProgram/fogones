<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de métodos de cocción */
    use app\controllers\metodoController;

    /* Comprueba si viene del módulo de métodos de cocción */
    if (isset($_POST['modulo_metodo'])) {

        /* Llama al controlador de grupos de platos */
        $insMetodo = new metodoController();

        /* Comprueba de qué formulario viene el hidden */
        switch ($_POST['modulo_metodo']) {
            case 'guardar':
                echo $insMetodo->guardarMetodoControlador();
                break;
            case 'actualizar':
                echo $insMetodo->actualizarMetodoControlador();
                break;
            
            case 'eliminar':
                echo $insMetodo->eliminarMetodoControlador();
                break;
            
            default:
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Error al guardar los datos",
                    "texto"=>"Se ha producido un errorcito inesperado. Inténtelo de nuevo",
                    "icono"=>"error"
                ];
                echo json_encode($alerta);
                exit();
                break;
        }

    } else {
        session_destroy();
        header("Location: ".APP_URL."principal/");
    }