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
    <h1>Últimas recetas añadidas</h1>
</header>
<section id="ultimasAgregadas" class="columns">
    <div class="column"><h1>Estos son los tipos de letra</h1></div>
    <div class="column"><h2>Estos son los tipos de letra</h2></div>
    <div class="column"><h3>Estos son los tipos de letra</h3></div>
    <div class="column"><h4>Estos son los tipos de letra</h4></div>
    <div class="column"><h5>Estos son los tipos de letra</h5></div>
    <div class="column"><span>Estos son los tipos de letra</span></div>
    <div class="column"><h1>Estos son los tipos de letra</h1></div>
    <div class="column"><h2>Estos son los tipos de letra</h2></div>
    <div class="column"><h3>Estos son los tipos de letra</h3></div>
    <div class="column"><h4>Estos son los tipos de letra</h4></div>
    <div class="column"><h5>Estos son los tipos de letra</h5></div>
    <div class="column"><span>Estos son los tipos de letra</span></div>
    <div class="column"><h1>Estos son los tipos de letra</h1></div>
    <div class="column"><h2>Estos son los tipos de letra</h2></div>
    <div class="column"><h3>Estos son los tipos de letra</h3></div>
    <div class="column"><h4>Estos son los tipos de letra</h4></div>
    <div class="column"><h5>Estos son los tipos de letra</h5></div>
    <div class="column"><span>Estos son los tipos de letra</span></div>
</section>