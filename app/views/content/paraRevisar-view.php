<?php 
    /* Carga el controlador de recetas */
    use app\controllers\recetaController;
    
    /* Crea una instancia del controlador de recetas para listarlas */
    $buscaRecetas = new recetaController();
    
    /* Ejecuta la selección para listar las recetas */
    $recetas = $buscaRecetas->listarRecetasControlador();
    


?>
<section name="contenido">
    <header class="tituloPagina">
        <h2>Recetas pendientes de revisión</h2>
    </header>
    
    <div id="listaRecetas" class="listaRecetasContainer col-80 total vertical">
        <div id="listaRecetasCabecera" class="listaRecetasCabecera col-100 total horizontal static">
            <div class="fotoListaRecetas col-20 static">Foto</div>
            <div class="col-100">Nombre Receta</div>
            <div class="">Ver</div>
        </div>

        <!-- Recorre la lista de recetas para poner una en cada fila -->
        <?php
            foreach ($recetas as $receta) {
                /* Establece la foto si hay o foto por defecto */
                if ($receta->getFoto() != "") {
                    $foto = $receta->getFoto();
                } else {
                    $foto = "default.png";
                }
        ?>
                <!-- Fila para cada receta -->
                <div class="listaRecetasFila col-100 medio horizontal static">
                    <div class="fotoListaRecetas foto col-20 medio static">
                        <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/'.$foto; ?>" alt="Foto de <?php echo $receta->getNombre(); ?>" title="Foto de <?php echo $receta->getNombre(); ?>">
                    </div>
                    <div class="col-100 medio vertical">
                        <h4><?php echo $receta->getNombre(); ?></h4>
                        <p class="textoLargo"><?php echo $receta->getDescripcion(); ?></p>
                    </div>
                    <div class="opcionesRecetas medio static">
                        <a href="<?php echo APP_URL.'recetaUpdate/'.$receta->getId(); ?>">
                            <button class="fa-regular fa-pen-to-square btnOpcionesRecetas" title="Revisar <?php echo $receta->getNombre() ?>"></button>
                        </a>
                    </div>
                </div>
        <?php 
            }
        ?>

    </div>
</section>
