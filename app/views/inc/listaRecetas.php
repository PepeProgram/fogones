<?php 
    /* Carga el controlador de recetas */
    use app\controllers\recetaController;

    /* Carga el modelo de recetas */
    use app\models\recetaModel;

    /* Carga el modelo de alérgenos */
    use app\models\alergenoModel;

    /* Crea una instancia del controlador de recetas para listarlas */
    $buscaRecetas = new recetaController();

    /* Ejecuta la selección para listar las recetas */
    $recetas = $buscaRecetas->listarRecetasControlador();

?>


<form name="Buscar Recetas" action="" class="filtrarTablas col-80 total">
    <label for="busquedaRecetas" class="oculto">Buscar Receta</label>
    <input name="busquedaRecetas" id="busquedaRecetas" type="text" autocomplete="off" class="input" onkeyup="filtrarRecetas(this.id, 'tarjetaReceta');" placeholder="Buscar en título y descripción ...">
</form>
<section name="Ultimas recetas" id="ultimasAgregadas" class="columns">
    <?php
        /* Establece el directorio de fotos */
        $img_dir = APP_URL.'app/views/photos/recetas_photos/';

        /* Establece el directorio de iconos de los alérgenos */
        $icon_dir = APP_URL.'app/views/photos/alergen_photos/';

        /* Comprueba si hay sesión iniciada */
        if (isset($_SESSION['id'])) {
                $id_usuario_ver = $_SESSION['id'];
        } else {
            $id_usuario_ver = "";
        }

        foreach ($recetas as $receta) {
            /* Establece la foto si hay o foto por defecto */
            if ($receta->getFoto() != "") {
                $foto = $receta->getFoto();
            } else {
                $foto = "default.png";
            }

            /* Recupera los alérgenos */
            $alergenos = $receta->getAlergenos();

    ?>
            <div class="column tarjetaReceta col-100 vertical top">
                
                <div class="fotoTarjetaReceta col-100 static">
                    <img src="<?php echo $img_dir.$foto; ?>" alt="Foto de <?php echo $receta->getNombre(); ?>" title="Foto de <?php echo $receta->getNombre(); ?>">
                </div>
                
                <div class="col-100 static total vertical">
                    <h3>
                        <a href="">
                            <?php echo $receta->getNombre(); ?>
                        </a>
                    </h3>
                    <div id="dif-<?php echo $receta->getId(); ?>" class="iconoDificultad horizontal static pointer" title="Dificultad <?php echo $receta->getDificultad(); ?> de 5">
                        <script>rellenarDificultad("dif-<?php echo $receta->getId(); ?>", <?php echo $receta->getDificultad(); ?>)</script>
                    </div>
                    <div class="col-100">
                        <p class="textoLargo"><?php echo $receta->getDescripcion(); ?></p>
                    </div>
                </div>
                <div class="etiquetasTarjeta col-100 total horizontal static">
                    <div class="etiqueta tiempo static pointer" title="Tiempo de elaboración <?php echo date("h:m",strtotime($receta->getTiempo())) ?>">
                        <i class="fa-solid fa-clock-rotate-left"></i><?php echo " ".substr($receta->getTiempo(), 0, 5); ?>
                    </div>
                    <div class="iconoEtiqueta horizontal static">
                        <?php 
                            /* Coloca los iconos de los alérgenos */
                            foreach ($alergenos as $alergeno) {
                                echo    '<div class="foto pointer">
                                            <img src="'.$icon_dir.$alergeno->getFoto_alergeno().'" alt="'.$alergeno->getNombre_alergeno().'" title="Alérgeno: '.$alergeno->getNombre_alergeno().'"></img>
                                        </div>';
                            }
                        ?>
                    </div>
                    <?php 
                        if ((isset($_SESSION['revisor']) && $_SESSION['revisor'] == true) || $id_usuario_ver == $receta->getId_usuario()) {
                        
                    ?>
                            <div class="opcionesAutores btnRecetaUpdate">
                                <a href="<?php echo APP_URL.'recetaUpdate/'.$receta->getId(); ?>">
                                    <button class="fa-regular fa-pen-to-square" title='Editar receta <?php echo $receta->getNombre(); ?>'></button>
                                </a>
                            </div>
                    <?php     
                        }
                    ?>
                </div>
            </div>
    <?php 
        }
    ?>


</section>