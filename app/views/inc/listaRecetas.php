<?php 
    /* Carga el controlador de recetas */
    use app\controllers\recetaController;

    /* Crea una instancia del controlador de recetas para listarlas */
    $buscaRecetas = new recetaController();

    /* Comprueba si viene de buscar o accede directamente */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['busquedaRecetas'])) {
        $esBusqueda = true;
        $recetas = $buscaRecetas->listarRecetasControlador($esBusqueda);
        $busqueda = " por ".$_POST['busquedaRecetas']." en esta sección";
    } else {
        $esBusqueda = false;
        $busqueda = "";
        $recetas = $buscaRecetas->listarRecetasControlador($esBusqueda);
    }

    /* Obtiene la vista actual para poner el id_tipo en el formulario */
    $vista_actual = explode("/", $_SERVER['REQUEST_URI']);

    if (isset($vista_actual[2]) && $vista_actual[2] != "") {

        $pagina_actual = $buscaRecetas->limpiarCadena($vista_actual[2]);
        switch ($pagina_actual) {
            case 'principal':
                $idTipo = "";
                break;
            case 'aperitivos':
                $idTipo = 1;
                break;
            case 'primerosPlatos':
                $idTipo = 3;
                break;
            case 'segundosPlatos':
                $idTipo = 7;
                break;
            case 'postres':
                $idTipo = 4;
                break;
            case 'guarniciones':
                $idTipo = 11;
                break;
            case 'desayunos':
                $idTipo = 10;
            case 'complementos':
                $idTipo = 12;
                break;
            
            default:
                $idTipo = "";
                break;
        }
    } else {
        $idTipo = "";
    }

    /* Comprueba si es un listado general o recetas de un autor para poner un formulario u otro */
    if (isset($pagina_actual) && in_array($pagina_actual, ["recetasDe", "misRecetas", "recetasFavoritas"])) {
        
        echo '<form name="Buscar Recetas" action="" class="filtrarTablas col-80 total">
                <label for="busquedaRecetas" class="oculto">Buscar Receta</label>
                <input name="busquedaRecetas" id="busquedaRecetas" type="text" autocomplete="off" class="input" onkeyup="filtrarRecetas(this.id, `tarjetaReceta`);" placeholder="Buscar en título y descripción ...">
             </form>';
    } else{

        echo '<form name="Buscar Recetas" action="" class="filtrarTablas col-80 total horizontal static" method="POST">
                <label for="busquedaRecetas" class="oculto">Buscar Receta</label>
                <input name="busquedaRecetas" id="busquedaRecetas" type="text" autocomplete="off" class="input inputBuscarRecetas" placeholder="Buscar en esta sección ...">
                <button type="submit" class="btnBuscarRecetas"><i class="fa fa-search"></i></button>
                <input type="hidden" name="modulo_receta" value="buscar">
                <input type="hidden" name="id_tipo" value="'.$idTipo.'">
             </form>';
    }

?>
<div class="total top bottom">
    <div class="col-100 resultadoBusqueda">
        <p class=""><?php echo count($recetas)." recetas encontradas".$busqueda; ?></p>
    </div>
</div>
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

            /* Comprueba si es favorita */
            $favorita = $receta->checkFavoritos();
            if ($favorita) {
                $heart = '<i class="fa-solid fa-heart userDel"></i>';
                $legend = "Quitar ".$receta->getNombre()." de mis recetas favoritas";
            } else {
                $heart = '<i class="fa-regular fa-heart"></i>';
                $legend = "Añadir ".$receta->getNombre()." a mis recetas favoritas";
            }
            

    ?>
            <div class="column tarjetaReceta col-100 vertical top">
                
                <div class="fotoTarjetaReceta col-100 static">
                    <img src="<?php echo $img_dir.$foto; ?>" alt="Foto de <?php echo $receta->getNombre(); ?>" title="Foto de <?php echo $receta->getNombre(); ?>">
                </div>
                
                <div class="col-100 static total vertical">
                    <h3>
                        <form class="FormularioAjax formFavoritos" action="<?php echo APP_URL ?>app/ajax/recetaAjax.php" method="POST" autocomplete="off" name="<?php echo $legend; ?>">
                            <input type="hidden" name="modulo_receta" value="cambiarFavorito">
                            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario_ver; ?>">
                            <input type="hidden" name="id_receta" value="<?php echo $receta->getId(); ?>">
                            <input type="hidden" name="nombre_receta" value="<?php echo $receta->getNombre(); ?>">
                            
                            
                            <button type="submit" class="btnIcon" aria-label="<?php echo $legend; ?>" title="<?php echo $legend; ?>">
                                <?php echo $heart; ?>
                            </button> 
                        </form>

                        <a href="<?php echo APP_URL ?>vistaReceta/<?php echo $receta->getId(); ?>">
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
                    <div class="etiqueta tiempo static centrar pointer" title="Tiempo de elaboración <?php echo date("h:i",strtotime($receta->getTiempo())) ?>">
                        <i class="fa-solid fa-clock-rotate-left"></i><?php echo " ".substr($receta->getTiempo(), 0, 5); ?>
                    </div>
                    <div class="iconoEtiqueta horizontal static">
                        <?php 
                            /* Coloca los iconos de los alérgenos */
                            foreach ($alergenos as $alergeno) {
                                echo    '<div class="foto pointer">
                                            <img class="alergenoTarjeta" src="'.$icon_dir.$alergeno->getFoto_alergeno().'" alt="'.$alergeno->getNombre_alergeno().'" title="Alérgeno: '.$alergeno->getNombre_alergeno().'"></img>
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

<script type="text/javascript">
    // Reemplaza el historial para que la página actual aparezca como GET
    window.history.replaceState(null, '', window.location.href);
</script>