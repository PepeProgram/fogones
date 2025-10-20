<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* Llama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de tipos de platos */
    use app\controllers\tipoPlatoController;

    /* Comprueba si viene del módulo de tipos de platos */
    if (isset($_POST['modulo_tipo'])) {

        /* Llama al controlador de tipos de plato */
        $insTipo = new tipoPlatoController();

        /* Comprueba de qué formulario viene el hidden */
        switch ($_POST['modulo_tipo']) {
            case 'guardar':
                echo $insTipo->guardarTipoPlatoControlador();
                break;
            
            case 'actualizar':
                echo $insTipo->actualizarTipoPlatoControlador();
                break;

            case 'eliminar':
                echo $insTipo->eliminarTipoPlatoControlador();
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
    