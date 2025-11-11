<?php 
    /* Carga el controlador de recetas */
    use app\controllers\recetaController;

    /* Carga el modelo de recetas */
    use app\models\recetaModel;

    /* Crea una instancia del controlador de recetas para listarlas */
    $buscaRecetas = new recetaController();

    /* Ejecuta la selección para listar las recetas */
    $recetas = $buscaRecetas->listarRecetasControlador();

    echo json_encode($recetas);
?>

<header class="tituloPagina">
    <h1>Segundos Platos</h1>
</header>
