<?php 
    /* Extrae el título de la página del form */
    if (isset($_POST['titulo_pagina'])) {
        $titulo = $insLogin->limpiarCadena($_POST['titulo_pagina']);
        echo    '<header class="tituloPagina">
                    <h1>'.$titulo.'</h1>
                    <h2 class="oculto">Recetas de <?php echo $titulo; ?></h2>
                </header>';
    } else {
        echo    '<header class="tituloPagina">
                    <h1>
                        <img class="logoSuperior" src="'.APP_URL.'app/views/img/BannerAlargado.png"" alt="Logotipo de Fogones Conectados">
                    </h1>
                    <h2 class="oculto">Listado de recetas</h2>
                </header>';
    }
?>
<!-- Carga el menú de fotos -->
<?php require_once "app/views/inc/menuFotos.php"; ?>

<!-- Carga la lista de recetas -->
<?php require_once "app/views/inc/listaRecetas.php"; ?>