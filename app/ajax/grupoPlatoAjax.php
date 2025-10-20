<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de grupos de platos */
    use app\controllers\grupoPlatoController;

    /* Comprueba si viene del módulo de grupos de platos */
    if (isset($_POST['modulo_grupo'])) {

        /* Llama al controlador de grupos de platos */
        $insGrupo = new grupoPlatoController();

        /* Comprueba de qué formulario viene el hidden */
        switch ($_POST['modulo_grupo']) {
            case 'guardar':
                echo $insGrupo->guardarGrupoPlatosControlador();
                break;
            case 'actualizar':
                echo $insGrupo->actualizarGrupoPlatosControlador();
                break;
            
            case 'eliminar':
                echo $insGrupo->eliminarGrupoPlatosControlador();
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