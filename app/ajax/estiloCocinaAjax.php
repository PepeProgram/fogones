<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de estilos de cicina */
    use app\controllers\estiloCocinaController;

    /* Comprueba si viene del módulo de estilos de cocina */
    if (isset($_POST['modulo_estilo'])) {

        /* Llama al controlador de grupos de platos */
        $insEstilo = new estiloCocinaController();

        /* Comprueba de qué formulario viene el hidden */
        switch ($_POST['modulo_estilo']) {
            case 'guardar':
                echo $insEstilo->guardarEstiloCocinaControlador();
                break;
            case 'actualizar':
                echo $insEstilo->actualizarEstiloCocinaControlador();
                break;
            
            case 'eliminar':
                echo $insEstilo->eliminarEstiloCocinaControlador();
                break;
            
            default:
                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Error al guardar los datos",
                    "texto"=>"Se ha producido un error inesperado. Inténtelo de nuevo",
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