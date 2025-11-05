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

                /* Comprueba si va a actualizar los datos o los alérgenos */
                if (isset($_POST['alergenos'])) {

                    /* Comprueba si va a agregar o quitar un alérgeno al ingrediente */
                    if ($_POST['alergenos'] == 'agregarAlergeno') {
                        echo $insIngrediente->agregarAlergenoIngredienteControlador();
                    } elseif($_POST['alergenos'] == 'quitarAlergeno') {
                        echo $insIngrediente->quitarAlergenoIngredienteControlador();

                    } else{
                        $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al guardar los datos",
                        "texto"=>"Se ha producido un errorcito inesperado. Inténtelo de nuevo",
                        "icono"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                    
                }
                else{
                    echo $insIngrediente->actualizarIngredienteControlador();
                }
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
                    "texto"=>"Se ha producido un errorcito inesperado. Inténtelo de nuevo",
                    "icono"=>"error"
                ];
                echo json_encode($alerta);
                exit();
                break;
        } 
    } elseif (isset($_POST['subform_modulo_receta'])) {
        
        /* Llama al controlador de ingredientes */
        $insIngrediente = new ingredienteController();

        /* Comprueba lo que tiene que hacer con los datos */
        switch ($_POST['subform_modulo_receta']) {
            case 'guardar':
                
                /* Recupera la respuesta del controlador */
                $alerta = $insIngrediente->guardarIngredienteControlador();

                /* Convierte la respuesta a array */
                $arrayAlerta = json_decode($alerta, true);

                /* Cambia el tipo de ventana de recargar a simple */
                $arrayAlerta['tipo'] = 'simple';

                /* Añade la clave formulario para indicar que viene del formulario ingrediente */
                $arrayAlerta['formulario'] = 'ingrediente';

                /* Vuelve a convertir la respuesta en string json y la devuelve */
                echo json_encode($arrayAlerta);
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
        /* session_destroy();
        header("Location: ".APP_URL."principal/"); */
    }