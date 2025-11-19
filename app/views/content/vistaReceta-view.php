<?php

    /* Carga la clase receta para poder crear objetos receta */
    use app\models\recetaModel;

    /* Carga la clase utensilio para poder crear objetos utensilio */
    use app\models\utensilioModel;

    /* Comprueba si hay sesión iniciada */
    if ((isset($_SESSION['id']) && isset($_SESSION['nombre']) && isset($_SESSION['login']))) {
        $usuario = $_SESSION['id'];
    } 

    /* Obtiene el id de la receta de la url del index */
    $id_receta = $insLogin->limpiarCadena($url[1]);

    /* Comprueba si la receta existe */
    $datos = $insLogin->seleccionarDatos('Unico', 'recetas', 'id_receta', $id_receta);
    if ($datos->rowCount()<=0) {
        /* Si la receta no existe, vuelta a la página principal */
        echo "
                <script>
                    textoAlerta = {
                        tipo: 'redirigir',
                        icono: 'error',
                        titulo: 'Receta no encontrada',
                        texto: 'La receta solicitada no existe',
                        confirmButtonText: 'Aceptar',
                        colorIcono: 'red',
                        url: '".APP_URL."'};
                    ventanaModal(textoAlerta);
                </script>
            ";
            exit();
    } else {
        /* Convierte a array la respuesta de la consulta */
        $datos = $datos->fetch();

        /* Crea una receta con todos los datos */
        $receta_ver = new recetaModel($datos['id_receta'], $datos['nombre_receta'], $datos['descripcion_receta'], $datos['id_usuario'], $datos['id_grupo'], $datos['n_personas'], $datos['tiempo_receta'], $datos['id_autor'], $datos['id_region'], $datos['id_pais'], $datos['id_zona'], $datos['dificultad'], $datos['elaboracion'], $datos['emplatado'], $datos['foto_receta'], $datos['visualizaciones'], $datos['creado_receta'], $datos['actualizado_receta'], $datos['activo']);

        /* Obtiene un array con los utensilios */
        $utensiliosReceta = [];
        foreach ($receta_ver->getUtensilios() as $utensilioObject) {
            $utensilio = new utensilioModel($utensilioObject['id_utensilio']);
            array_push($utensiliosReceta, $utensilio);
        }

        /* Obtiene los datos del creador de la receta */
        $creador = $insLogin->seleccionarDatos('Unico', 'usuarios', 'id_usuario', $receta_ver->getId_usuario());

        if($creador->rowCount() == 1){
            $creador = $creador->fetch();
            $nombreCreador = $creador['nombre_usuario']." ".$creador['ap1_usuario'];
            $fotoCreador = $creador['foto_usuario'];
        } else {
            $nombreCreador = "Autor desconocido";
        }
        

    }


?>

<script>
    window.addEventListener('load', async function () {
       
        /* Carga los utensilios */
        rellenarUtensiliosReceta('ulListaUtensilios', <?php echo json_encode($utensiliosReceta); ?>);

        /* Carga los ingredientes */
        rellenarIngredientesReceta('ulListaIngredientes', <?php echo json_encode($receta_ver->getIngredientes()); ?>);

        /* Carga las etiquetas */
        rellenarEtiquetasReceta('pieReceta',<?php echo json_encode($receta_ver->getEstilos()); ?>, 'estilos_cocina');
        rellenarEtiquetasReceta('pieReceta',<?php echo json_encode($receta_ver->getTipos_plato()); ?>, 'tipos_plato');
        rellenarEtiquetasReceta('pieReceta',<?php echo json_encode($receta_ver->getId_grupo()); ?>, 'grupos_plato');
        rellenarEtiquetasReceta('pieReceta',<?php echo json_encode($receta_ver->getMetodos()); ?>, 'tecnicas');


    });




</script>


<header class="tituloReceta">
    <div class="nombrePrincipalesInput medio izquierda derecha horizontal centrar top">
        <h1>Ficha completa</h1>
    </div>
    <?php include "./app/views/inc/btn_back.php"; ?>
</header>

<div class="recetaContainer">
    
    <!-- Cabecera de la receta con la foto -->
    <section id="cabeceraReceta" name="Resumen de la receta" class="cabeceraReceta col-100 horizontal total">
    
        <?php 
            /* Comprueba si la receta tiene foto o no y la recupera */
            if ($receta_ver->getFoto() != "") {
                $foto_receta = $receta_ver->getFoto();
                $alt_foto = "Foto de ";
            } else {
                $foto_receta = 'default.png';
                $alt_foto = "Receta sin foto";
            }

            /* Recupera los alérgenos */
            $alergenos = $receta_ver->getAlergenos();

            /* Establece el directorio de iconos de los alérgenos */
            $icon_dir = APP_URL.'app/views/photos/alergen_photos/';
        ?>
    
        <!-- Foto de la receta -->
        <div id="fotoCabeceraReceta" class="fotoTarjetaReceta col-50">
            <img id="fotoReceta" src="<?php echo APP_URL.'app/views/photos/recetas_photos/'.$foto_receta ?>" alt="<?php echo $alt_foto.$receta_ver->getFoto(); ?>" title="<?php echo $alt_foto.$receta_ver->getFoto(); ?>">
        </div>
    
        <!-- Resto de datos principales -->
        <div id="datosCabeceraReceta" class="datosCabeceraReceta col-50 vertical total">
    
            <!-- Nombre -->
            <h2><?php echo $receta_ver->getNombre(); ?></h2>
    
            <!-- Fecha de creación -->
            <p class="notas"><?php echo "Creado el ".strftime('%a. %d de %b. de %Y', strtotime($receta_ver->getCreado())) ?></p>

            <div id="descripcionReceta" class="descripcionReceta col-100 izquierda horizontal">
                <p class="textoLargo"><?php echo $receta_ver->getDescripcion(); ?></p>
            </div>
            
            <!-- Creador de la receta -->
            <div class="containerPropietario">
                <div id="propietarioReceta" class="propietarioReceta col-100 izquierda horizontal static">
        
                    <!-- Foto del creador -->
                    <div class='fotoAutorLista foto'>
                        <img src='<?php echo APP_URL; ?>app/views/photos/user_photos/<?php echo $fotoCreador; ?>' alt='Foto de <?php $nombreCreador; ?>'>
                    </div>
        
                    <!-- Nombre del creador -->
                    <h5 class="total"><a href=""><?php echo $nombreCreador ?></a></h5>
                </div>
            </div>
    
            <!-- Alérgenos -->
            <div id="alergenosReceta" class="caracteristicasReceta col-100 vertical">
                <div class="iconoEtiquetaReceta horizontal static">
                    <?php 
                        /* Coloca los iconos de los alérgenos */
                        foreach ($alergenos as $alergeno) {
                            echo    '<div class="fotoReceta pointer">
                                        <img src="'.$icon_dir.$alergeno->getFoto_alergeno().'" alt="'.$alergeno->getNombre_alergeno().'" title="Alérgeno: '.$alergeno->getNombre_alergeno().'"></img>
                                    </div>';
                        }
                    ?>
                </div>
            </div>

            <!-- Características: Dificultad, tiempo de elaboración, etc. -->
            <div id="caracteristicasReceta" class="caracteristicasReceta col-100 horizontal static">

                <!-- Dificultad -->
                <div class="etiquetaCaracteristicasReceta vertical">
                    <p class="notas">Dificultad</p>
                    <div id="dif-<?php echo $receta_ver->getId(); ?>" class="iconoDificultad horizontal static pointer" title="Dificultad <?php echo $receta_ver->getDificultad(); ?> de 5">
                        <script>rellenarDificultad("dif-<?php echo $receta_ver->getId(); ?>", <?php echo $receta_ver->getDificultad(); ?>)</script>
                    </div>
                </div>

                <!-- Tiempo de elaboración -->
                <div class="etiquetaCaracteristicasReceta vertical">
                    <p class="notas">Elaboración</p>
                    <div class="horizontal static" title="Tiempo de elaboración <?php echo " ".substr($receta_ver->getTiempo(), 0, 5); ?>">
                        <?php echo " ".substr($receta_ver->getTiempo(), 0, 5); ?>h.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Desarrollo de la receta -->
    <section id="desarrolloReceta" name="Desarrollo de la receta" class="desarrolloReceta col-100 horizontal total">
        <div id="ingredientesUtensilios" class="ingredientesUtensilios col-33 medio vertical top">
            <div class="col-100 horizontal centrar static">
                <p>Para&nbsp;</p>
                <input type="number" name="nPersonas" id="nPersonas" step="1" class="input col-20 static" value="<?php echo $receta_ver->getPersonas() ?>">
                <label for="nPersonas">&nbsp;Personas</label>
            </div>
            <div id="listaIngredientes" class="listaIngredientes col-100 vertical">
                <h3>Ingredientes</h3>
                <ul id="ulListaIngredientes" class="ulListaIngredienetes">
                
                </ul>
            </div>
            <div id="listaUtensilios" class="listaUtensilios col-100 vertical">
                <h3>Utensilios</h3>
                <ul id="ulListaUtensilios" class="ulListaUtensilios">

                </ul>
            </div>
        </div>
        <div id="elaboracionEmplatado" class="elaboracionEmplatado col-66 medio vertical top">

            <?php 
                
                /* Inicializa la variable para añadir los párrafos */
                $elaboracion = "";
                
                /* Crea un array con cada uno de los párrafos */
                $parrafos = explode("\n", $receta_ver->getElaboracion());
                
                /* Recorre el array de párrafos para comprobar lo que hay hasta el primer : */
                foreach ($parrafos as $parrafo) {

                    /* Escapar la línea completa (evita XSS) */
                    $parrafo_seguro = htmlspecialchars($parrafo, ENT_QUOTES, 'UTF-8');

                    /* Negrita solo hasta el primer ":" si existe */
                    $parrafo_procesado = preg_replace('/^([^:]+):/','<strong>$1</strong>:', $parrafo_seguro);

                    /* Añade el párrafo a la variable */
                    $elaboracion .= "<p class='textoLargo'>{$parrafo_procesado}</p>";
                }
            ?>

            <div id="elaboracionReceta" class="elaboracionReceta col-100 vertical">
                <h3>Elaboración</h3>
                <p class="textoLargo"><?php echo $elaboracion; ?></p>
            </div>
            <div id="emplatadoReceta" class="emplatadoReceta col-100 vertical">
                <h3>Sugerencia de presentación</h3>
                <p class="textoLargo"><?php echo $receta_ver->getEmplatado(); ?></p>
            </div>

        </div>
    </section>

    <!-- Etiquetas -->
     <div class="col-100 horizontal total">
         <fieldset id="pieReceta" class="pieReceta col-100 horizontal total static">
            <legend class="leyendaEtiquetas">Etiquetas</legend>
    
         </fieldset>
     </div>

</div>