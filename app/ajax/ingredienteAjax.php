<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de ingredientes */
    use app\controllers\ingredienteController;

    /* Comprueba si viene del módulo de ingrediente */
    if (isset($_POST['modulo_ingrediente'])) {

        /* Llama al controlador de ingredientes */
        $insIngrediente = new ingredienteController();

        /* Comprueba de qué formulario viene el hidden */
        switch ($_POST['modulo_ingrediente']) {
            case 'guardar':
                echo $insIngrediente->guardarIngredienteControlador();
                break;
            case 'actualizar':
                echo $insIngrediente->actualizarIngredienteControlador();
                break;
            
            case 'eliminar':
                echo $insIngrediente->eliminarIngredienteControlador();
                break;
            
            case 'cambiarActivo':
                echo $insIngrediente->cambiarActivoIngredienteControlador();
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