<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de utensilios de cocina */
    use app\controllers\utensilioController;

    /* Comprueba si viene del módulo de utensilios de cocina */
    if (isset($_POST['modulo_utensilio'])) {

        /* Llama al controlador de utensilios de cocina */
        $insUtensilio = new utensilioController();

        /* Comprueba de qué formulario viene el hidden */
        switch ($_POST['modulo_utensilio']) {
            case 'guardar':
                echo $insUtensilio->guardarUtensilioControlador();
                break;
            case 'actualizar':
                echo $insUtensilio->actualizarUtensilioControlador();
                break;
            
            case 'eliminar':
                echo $insUtensilio->eliminarUtensilioControlador();
                break;
            
            case 'cambiarActivo':
                echo $insUtensilio->cambiarActivoUtensilioControlador();
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