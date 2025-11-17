<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de recetas */
    use app\controllers\recetaController;

    /* Comprueba si viene del módulo de recetas */
    if (isset($_POST['modulo_receta'])) {
    
        /* Llama al controlador de recetas */
        $insReceta = new recetaController();

        /* Comprueba lo que tiene que hacer con el formulario */
        switch ($_POST['modulo_receta']) {

            case 'guardar':
                echo $insReceta->guardarRecetaControlador();
                break;
            
            case 'actualizar':
                echo $insReceta->actualizarRecetaControlador();
                break;
            
            case 'eliminar':
                # code...
                break;
            
            case 'aprobar':
                echo $insReceta->aprobarRecetaControlador();
                break;
            
            case 'desactivar':
                echo $insReceta->desactivarRecetaControlador();
                break;
            
            default:
                # code...
                break;
        }
    
    
    } else {
        session_destroy();
        header("Location: ".APP_URL."principal/");
    }

    