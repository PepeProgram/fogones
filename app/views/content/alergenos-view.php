<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";
?>
<section name="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Alérgenos</h2>
    </header>
</section>
<div class="columns">
    

        <?php
            /* Carga el controlador de alérgenos */
            use app\controllers\alergenoController;

            /* Crea una instancia del controlador de alérgenos */
            $listaAlergenos = new alergenoController();

            /* Llama al método del controlador para obtener los alérgenos */
            $listaAlergenos = $listaAlergenos->listarAlergenosControlador();

            foreach ($listaAlergenos as $alergeno) {
                
                /* Construye el html para mostrar cada alérgeno */
                $html = '
                    <div class="column">
                        <form action="'.APP_URL.'app/ajax/alergenoAjax.php" method="POST" class="FormularioAjax alergeno" enctype="multipart/form-data" name="¿Actualizar alérgeno?">
                            <input type="hidden" name="modulo_alergeno" value="actualizar">
                            <input type="hidden" name="id_alergeno" value="'.$alergeno->getId_alergeno().'">
                            <div class="fotoalergeno">
                                <img id="iconoAlergeno-'.$alergeno->getId_alergeno().'" src="'.APP_URL.'app/views/photos/alergen_photos/'.$alergeno->getFoto_alergeno().'" alt="Icono de '.$alergeno->getNombre_alergeno().'">
                            </div>
                            <div class="tituloAlergeno">
                                <label for="nombreAlergeno-'.$alergeno->getId_alergeno().'" class="oculto">Nombre</label>
                                <textarea id="nombreAlergeno-'.$alergeno->getId_alergeno().'" name="nombre_alergeno" class="nombreAlergeno" maxlength=230 title="Nombre del alérgeno. Sólo puede contener letras, números, .,-,_ y espacios" required disabled rows=3>'.$alergeno->getNombre_alergeno().'</textarea>
                                <div class="opcionesAlergenos">
                                    <button id="editarAlergeno-'.$alergeno->getId_alergeno().'" type="button" class="fa-solid fa-pen-to-square" title="Editar Alérgeno" onclick="activarBotonesAlergenos(this);"></button>
                                    <button id="cambiarIconoAlergeno-'.$alergeno->getId_alergeno().'" type="button" class="fa-solid fa-camera desactivar" title="Cambiar Icono" onclick="document.querySelector(\'#fotoAlergeno-'.$alergeno->getId_alergeno().'\').click();" disabled></button>
                                    <label for="fotoAlergeno-'.$alergeno->getId_alergeno().'" class="oculto">Archivo imagen</label>
                                    <input type="file" name="foto_alergeno" id="fotoAlergeno-'.$alergeno->getId_alergeno().'" class="file-input" accept=".jpg, .png, .jpeg" onchange="previewImage(this, \'iconoAlergeno-'.$alergeno->getId_alergeno().'\', \''.APP_URL.'app/views/photos/alergen_photos/'.$alergeno->getFoto_alergeno().'\')">
                                    <button id="guardarCambios-'.$alergeno->getId_alergeno().'" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Cambios" disabled></button>
                                </div>
                            </div>
                        </form>
                        <form class="FormularioAjax" action="'.APP_URL. 'app/ajax/alergenoAjax.php" method="POST" autocomplete="off" name="Eliminar '.$alergeno->getNombre_alergeno().'">
                            <input type="hidden" name="modulo_alergeno" value="eliminar">
                            <input type="hidden" name="id_alergeno" value="'.$alergeno->getId_alergeno().'">

                            <button class="fa-solid fa-square-xmark  btnBorrarAlergeno" title="Eliminar'.$alergeno->getNombre_alergeno().'" type="submit"></button>
                        </form>
                    </div>';
                /* Muestra el html en la pantalla */
                echo $html;
            }
        ?>

        <div class="column">
            <form action="<?php echo APP_URL; ?>app/ajax/alergenoAjax.php" class="FormularioAjax alergeno" method="POST" enctype="multipart/form-data" name="¿Crear nuevo alérgeno?">
                <input type="hidden" name="modulo_alergeno" value="guardar">

                <div class="fotoalergeno">
                    <img id="iconoAlergeno" src="<?php echo APP_URL."app/views/photos/alergen_photos/sinfoto.png" ?>" alt="Sin foto">
                </div>
                <div class="tituloAlergeno">
                    <label for="nombreAlergeno-0" class="oculto">Nombre</label>
                    <textarea name="nombre_alergeno" id="nombreAlergeno-0" class="nombreAlergeno" maxlength="230" title="Nombre del alérgeno. Sólo puede contener letras, números, .,-,_ y espacios" required rows="3" disabled></textarea>
                    <div class="opcionesAlergenos">
                        <button id="editarAlergeno-0" type="button" class="fa-regular fa-square-plus" title="Añadir alérgeno" onclick="activarBotonesAlergenos(this);"></button>
                        <button id="cambiarIconoAlergeno-0" type="button" class="fa-solid fa-camera desactivar" title="Añadir Icono" onclick="document.querySelector('#fotoAlergeno-0').click();" disabled></button>
                        <label for="fotoAlergeno-0" class="oculto">Archivo imagen</label>
                        <input type="file" name="foto_alergeno" id="fotoAlergeno-0" class="file-input" accept=".jpg, .png, .jpeg" onchange="previewImage(this, 'iconoAlergeno', '<?php echo APP_URL ?>/app/views/photos/alergen_photos/sinfoto.png');">
                        <button id="guardarCambios-0" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Alérgeno" disabled></button>
                    </div>
                </div>
            </form>
        </div>
    
</div>