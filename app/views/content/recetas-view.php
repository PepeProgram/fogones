<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";
    
    /* Carga el controlador de recetas */
    use app\controllers\recetaController;
    
    /* Crea una instancia del controlador de recetas para listarlas */
    $buscaRecetas = new recetaController();
    
    /* Ejecuta la selección para listar las recetas */
    $recetas = $buscaRecetas->listarRecetasControlador();
    


?>
<section name="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Recetas</h2>
    </header>
    <form name="Buscar Recetas" action="" class="filtrarTablas">
        <label for="busquedaRecetas">Buscar Receta</label>
        <input name="busquedaRecetas" id="busquedaRecetas" type="text" autocomplete="off" class="input" onkeyup="filtrarRecetas(this.id, 'listaRecetasFila');">
    </form>
    <div class="botonesLista total">
        <a href=<?php echo APP_URL."recetas" ?>>
            <button class="btn">Todas</button>
        </a>
        <a href=<?php echo APP_URL."recetaData/" ?>>
            <button class="btn">Añadir Receta</button>
        </a>

        <!-- Comprueba si hay recetas pendientes de revisión -->
        <?php 
            $recetasPendientes = new recetaController();
            if ($recetasPendientes->revisarRecetasControlador()) {
                $ocultar = "";
            }
            else{
                $ocultar = "oculto";
            }
        ?>

            <!-- Botón para ver las recetas pendientes de revisión -->
        <a href=<?php echo APP_URL."paraRevisar/" ?> class="<?php echo $ocultar ?>">
            <button class="btn btnAlerta">Pendientes de Revisión!!!</button>
        </a>
    </div>
    <div id="listaRecetas" class="listaRecetasContainer col-80 total vertical">
        <div id="listaRecetasCabecera" class="listaRecetasCabecera col-100 total horizontal static">
            <div class="fotoListaRecetas col-20 static">Foto</div>
            <div class="col-60">Nombre Receta</div>
            <div class="col-20 static centrar">Opc.</div>
            <div class="col-10 static centrar">Act.</div>
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
                    <div class="col-80 medio vertical">
                        <h4><?php echo $receta->getNombre(); ?></h4>
                        <p class="textoLargo"><?php echo $receta->getDescripcion(); ?></p>
                    </div>
                    <div class="opcionesRecetas col-20 medio static">
                        <a href="<?php echo APP_URL.'recetaUpdate/'.$receta->getId(); ?>" title="Revisar <?php echo $receta->getNombre(); ?>">
                            <button class="fa-regular fa-pen-to-square btnOpcionesRecetas"></button>
                        </a>
                        <button class="fa-solid fa-square-xmark userDel btnOpcionesRecetas" title="Eliminar <?php echo $receta->getNombre(); ?>"></button>
                    </div>
                    <div class="opcionesRecetas col-10 medio static">
                        <?php if ($receta->getActivo()) {?>

                            <!-- Botón para desactivar una receta -->
                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/recetaAjax.php" method="POST" autocomplete="off" name="Desactivar <?php echo $receta->getNombre(); ?>">
                                <input type="hidden" name="modulo_receta" value="desactivar">
                                <input type="hidden" name="id_receta" value="<?php echo $receta->getId(); ?>">

                                <button type="submit" class="fa-solid fa-check btnOpcionesRecetas checked" aria-label="Desactivar " title="Desactivar <?php echo $receta->getNombre(); ?>">
                                </button> 
                            </form>


                        <?php
                            }
                        ?>
                    </div>
                </div>
        <?php 
            }
        ?>

    </div>
</section>