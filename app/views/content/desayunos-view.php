<?php 
    /* Carga el controlador de recetas */
    use app\controllers\recetaController;

    /* Crea una instancia del controlador de recetas para listarlas */
    $buscaRecetas = new recetaController();

    /* Ejecuta la selección para listar las recetas */
    $recetas = $buscaRecetas->listarRecetasControlador();

    echo json_encode($recetas);
?>

<header class="tituloPagina">
    <h1>Desayunos y Meriendas</h1>
</header>
