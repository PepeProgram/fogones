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

    if (isset($_POST['id_tipo']) && $_POST['id_tipo'] != "") {
        $idTipo = $buscaRecetas->limpiarCadena($_POST['id_tipo']);
    } else {
        $idTipo = "";
    }

    /* Comprueba si es un listado general o recetas de un autor para poner un formulario u otro */
    if (isset($pagina_actual) && in_array($pagina_actual, ["recetasDe", "misRecetas", "recetasFavoritas"])) {
        
        echo '<form name="Buscar Recetas" action="" class="filtrarTablas col-80 total">
                <label for="busquedaRecetas" class="oculto">Buscar Receta</label>
                <input name="busquedaRecetas" id="busquedaRecetas" type="text" autocomplete="off" class="input" onkeyup="filtrarRecetas(this.id, `tarjetaReceta`);" placeholder="Buscar en título y descripción ..." alt="Buscar en la sección" aria-label="Buscar en esta sección">
             </form>';
    } else{

        echo '<form name="Buscar Recetas" action="" class="filtrarTablas col-80 total horizontal static" method="POST">
                <label for="busquedaRecetas" class="oculto">Buscar Receta</label>
                <input name="busquedaRecetas" id="busquedaRecetas" type="text" autocomplete="off" class="input inputBuscarRecetas" placeholder="Buscar en esta sección ..." alt="Buscar en la sección" aria-label="Buscar en esta sección">
                <button type="submit" class="btnBuscarRecetas" aria-label="Buscar" alt="Buscar"><i class="fa fa-search"></i></button>
                <input type="hidden" name="modulo_receta" value="buscar">
                <input type="hidden" name="id_tipo" value="'.$idTipo.'">
             </form>';
    }

?>

<!-- Obtiene todas las tarjetas en formato JSON -->
 <script type="application/json" id="recetasJSON"><?=
    json_encode($recetas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
?></script>
<div class="total top bottom">
    <div class="col-100 resultadoBusqueda">
        <p class=""><?php echo count($recetas)." recetas encontradas".$busqueda; ?></p>
    </div>
</div>
<section name="Ultimas recetas" id="ultimasAgregadas" class="columns" data-idusuario="<?= isset($_SESSION['id']) ? $_SESSION['id'] : ""; ?>" data-revisor="<?= isset($_SESSION['revisor']) ? $_SESSION['revisor'] : ""; ?>" >
    

</section>

<div class="col-100 centrar">
    <button id="btnVerMas" class="btn btnVerMas centrar">Mostrar más...</button>
</div>
<script type="text/javascript">
    // Reemplaza el historial para que la página actual aparezca como GET
    window.history.replaceState(null, '', window.location.href);
</script>