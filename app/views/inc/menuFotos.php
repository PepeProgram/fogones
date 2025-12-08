<?php 
    /* Carga el controlador de tipos de plato */
    use app\controllers\tipoPlatoController;

    /* Crea una instancia del controlador de tipos de plato */
    $buscarTipos = new tipoPLatoController();

    /* Obtiene los tipos de plato */
    $tiposPlato = $buscarTipos->listarTiposPlatoControlador();



?>

<div id="menuFotosContenedor" class="menuFotosContenedor">
    <button class="scrollBtn left" onclick="scrollMenuFotos(this);">&lt;</button>
    <section id="menuFotos" class="menuFotos">


        <?php
        
            foreach ($tiposPlato as $tipoPlato) {

                echo '
                    <form action="listaFiltrada" method="POST">
                        <input type="hidden" name="id_tipo" value="'.$tipoPlato->getId_tipo().'">
                        <input type="hidden" name="titulo_pagina" value="'.$tipoPlato->getNombre_tipo().'">
                            <button class="opcionMenuFotos">
                                <div class="divFotoMenu">
                                    <img src="'.APP_URL.'app/views/photos/tipos_photos/'.$tipoPlato->getFoto_tipo().'" alt="'.$tipoPlato->getNombre_tipo().'" class="fotoMenu">
                                </div>
                                <div class="leyendaMenu">
                                    '.$tipoPlato->getNombre_tipo().'
                                </div>
                            </button>
                    </form>
                ';
            
            }
            
        
        ?>
    </section>
    <button class="scrollBtn right" onclick="scrollMenuFotos(this);">&gt;</button>
</div>