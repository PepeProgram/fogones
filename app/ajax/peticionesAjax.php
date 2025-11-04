<?php
    /* Llama al archivo de configuración */
    require_once "../../config/app.php";

    /* LLama al archivo de inicio de sesión */
    require_once "../views/inc/session_start.php";

    /* Llama al autoload para cargar las clases cuando se llaman */
    require_once "../../autoload.php";

    /* Usa el controlador de peticiones */
    use app\controllers\peticionesController;

    /* Crea la instancia del controlador */
    $listElementos = new peticionesController();

    /* Llama al método del controlador para obtener el listado */
    echo $listElementos->listarElementosControlador();