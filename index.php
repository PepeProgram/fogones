<?php
/* Carga el archivo de configuración de nuestra aplicación */
require_once "./config/app.php";

/* Carga el autoload para cargar las clases cuando se necesiten */
require_once "./autoload.php";

/* Carga el el inicio de sesión del navegador */
require_once "./app/views/inc/session_start.php";

/* Obtiene el valor de la variable views que se ha definido en el .htacess (todo lo que venga después de la carpeta del proyecto por la URL) */

if (isset($_GET['views'])) {
    /* Crea un array con las partes de la url que retorna el .htaccess por la url */
    $url = explode("/", $_GET['views']);
} else {
    /* Si no hay variable views, le asigna la vista principal */
    $url = ["principal"];
}
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <!-- Carga el head del html -->
        <?php require_once "./app/views/inc/head.php"; ?>
    </head>

    <body>
        <div class="main-container" id="main-container">
        
            <!-- Cuerpo de la página -->
            <!-- Aquí van a cargarse todas las vistas que vayamos llamando -->

            <?php
                /* Llama al controlador de las vistas y el de sesión, puesto que hereda de ellos */
                use app\controllers\viewsController;
                use app\controllers\loginController;

                /* Crea una instancia del controlador de vistas y del de login */
                $viewsController = new viewsController();
                $insLogin = new loginController();
                
                /* Obtiene la url de la vista que se llame como lo que hay inmediatamente después de fogones en la url */
                $vista = $viewsController->obtenerVistasControlador($url[0]);

                /* Carga la barra de navegación antes de cargar la vista */
                require_once "./app/views/inc/navbar.php";

                /* Comprueba si la vista que devuelve es 404 */
                if ($vista == "404") {

                    /* Carga la vista de error 404 */
                    require_once "./app/views/content/".$vista."-view.php";
                    
                    /* Carga el resto de la página principal */
                    require_once "./app/views/content/principal-view.php";
                } else {
                    /* Carga la vista que viene en la variable */
                    require_once "./app/views/content/".$vista."-view.php";
                }
                
            ?>

        </div>

        <?php
            /* Carga el botón de scrollUp */ 
            require_once "./app/views/inc/botonScroll.php";
            /* Carga el pie de página */
            require_once "./app/views/inc/footer.php";
        ?>
        
        <!-- Carga los scripts de javascript -->
        <?php require_once "./app/views/inc/script.php"; ?>
    </body>

</html>