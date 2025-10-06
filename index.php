<?php
    /* Carga el archivo de configuración de nuestra aplicación */
    require_once "./config/app.php";
    
    /* Carga el autoload para cargar las clases cuando se necesiten */
    require_once "./autoload.php";

    /* Obtiene el valor de la variable views que se ha definido en el .htacess (todo lo que venga después de la carpeta del proyecto por la URL) */

    if (isset($_GET['views'])) {
        /* Crea un array con las partes de la url que retorna el .htaccess por la url */
        $url=explode("/", $_GET['views']);
    }
    else{
        /* Si no hay variable views, le asigna la vista principal */
        $url=["principal"];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Carga el head del html -->
    <?php require_once "./app/views/inc/head.php"; ?>
</head>
<body>
    
    <!-- Carga los scripts de javascript -->
    <?php require_once "./app/views/inc/script.php"; ?>
</body>
</html>