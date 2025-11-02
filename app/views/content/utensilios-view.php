<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";

    /* Carga el controlador de utensilios */
    use app\controllers\utensilioController;

?>
<section name="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Utensilios de Cocina</h2>
    </header>
    <div class="contentControl">


        <!-- Formulario para Añadir un utensilio -->
        <div id="formAgregarUtensilio" class="formAgregarAutor oculto">
            <div class="cabeceraForm">
                <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="desactivarFormulario('formAgregarUtensilio');"></button>
            </div>
            <form action="<?php echo APP_URL; ?>app/ajax/utensilioAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
                <input type="hidden" id="accionForm" name="" value="">
                <input type="hidden" id="idForm" name="id_Form" value="">
                <div class="autor">
                    <div class="fotoautor">
                        <img src="<?php echo APP_URL; ?>app/views/photos/utensilios_photos/default.png" alt="Foto del Utensilio de Cocina" id="fotoUtensilio">
                    </div>
                    <div class="tituloAutor">
                        <label for="nombreUtensilio">Nombre del Utensilio de Cocina:</label>
                        <input type="text" id="nombreUtensilio" class="nombreAutor" name="nombre_utensilio" maxlength="80" required value="" placeholder="Nombre del Utensilio de Cocina" title="Introduzca el nombre del Utensilio de Cocina. Sólo puede contener letras, números, .,-,_ y espacios" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}">
                    </div>
                    <div class="opcionesAutores">
                        <button id="cambiarFotoUtensilio" type="button" class="fa-solid fa-camera desactivar" title="Añadir Foto" onclick="document.querySelector('#fotoUtensilio-0').click();"></button>
                        <label for="fotoUtensilio-0" class="oculto">Archivo Imagen</label>
                        <input type="file" name="foto_utensilio" id="fotoUtensilio-0" class="file-input" accept=".jpg, .jpeg, .png" onchange="previewImage(this, 'fotoUtensilio', '<?php echo APP_URL; ?>app/views/photos/utensilios_photos/default.png');">
                        <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Utensilio de Cocina"></button>
                    </div>
                </div>
            </form>
        </div>

        <form name="Buscar Utensilios" action="" class="filtrarTablas">
            <label for="busquedaUtensilios">Buscar Utensilio de Cocina</label>
            <input type="text" name="busquedaUtensilios" id="busquedaUtensilios" class="input" onkeyup="filtrarTablas(this.id, 'utensilioList');">
        </form>
        <div class="botonesLista">

            <!-- Botón para ver todos los utensilios -->
            <a href=<?php echo APP_URL."utensilios" ?>>
                <button class="btn">Todos</button>
            </a>

            
            <!-- Comprueba si hay utensilios pendientes de revisión -->
            <?php 
                $utensiliosPendientes = new utensilioController();
                if ($utensiliosPendientes->revisarUtensiliosControlador()) {
                    $ocultar = "";
                }
                else{
                    $ocultar = "oculto";
                }
            ?>

            <!-- Botón para añadir un utensilio de cocina -->
            <a href="#formAgregarUtensilio">
                <button class="btn" type="button" onclick="activarFormulario('modulo_utensilio', 'formAgregarUtensilio', 'guardar', '');">Añadir Utensilio de Cocina</button>
            </a>

            <!-- Botón para ver los utensilios pendientes de revisión -->
            <a href=<?php echo APP_URL."utensilios/paraRevisar/" ?> class="<?php echo $ocultar ?>">
                <button class="btn btnAlerta">Pendientes de revisión!!!</button>
            </a>
        </div>
        <div class="listaUsuarios">
            <table class="userList peque">
                <thead>
                    <tr class="headerUserList">
                        <th class="fotoPeque">Foto</th>
                        <th>Nombre</th>
                        <th>Opc.</th>
                        <th>Ac.</th>
                    </tr>
                </thead>
                <tbody id="utensilioList">
                    <?php
                        /* Crea una instancia del controlador de Utensilios de Cocina */
                        $listaUtensilios = new utensilioController();

                        /* Llama al método de la lista de utensilios de cocina para obtener los utensilios de cocina */
                        $listaUtensilios = $listaUtensilios->listarUtensiliosControlador();

                        /* Recorre la lista de utensilios de cocina para insertar cada utensilios en una fila de la tabla */
                        foreach ($listaUtensilios as $utensilio) {

                            /* Comprueba si el utensilio está activo o no */
                            if ($utensilio->getActivo_utensilio()) {
                                $iconoUtensilio = "fa-regular fa-square-check";
                                $tituloUtensilio = "Desactivar ";
                                $colorUtensilio = "green";
                            } else {
                                $iconoUtensilio = "fa-regular fa-square";
                                $tituloUtensilio = "Activar ";
                                $colorUtensilio = "grey";
                            }
                            
                        
                    ?>

                        <tr class='userUserList' id='<?php echo $utensilio->getId_utensilio(); ?>'>
                            <td class="fotoPeque">
                                <div class='fotoAutorLista'>
                                    <img src='<?php echo APP_URL; ?>app/views/photos/utensilios_photos/<?php echo $utensilio->getFoto_utensilio(); ?>' alt='Foto de <?php echo $utensilio->getNombre_utensilio(); ?>'>
                                </div>
                            </td>
                            <td>
                                <?php echo $utensilio->getNombre_utensilio(); ?>
                            </td>
                            <td>
                                <div class='opcionesAutores'>

                                    <!-- Botón para actualizar los datos o la foto de un utensilio -->
                                    <button class='fa-regular fa-pen-to-square' title='Actualizar datos de <?php echo $utensilio->getNombre_utensilio(); ?>' onclick='activarFormulario("modulo_utensilio", "formAgregarUtensilio", "actualizar", <?php echo json_encode($utensilio); ?>);'></button>

                                    <!-- Botón para eliminar un utensilio -->
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/utensilioAjax.php" method="POST" autocomplete="off" name="Eliminar <?php echo $utensilio->getNombre_utensilio()?>">
                                        <input type="hidden" name="modulo_utensilio" value="eliminar">
                                        <input type="hidden" name="id_utensilio" value="<?php echo $utensilio->getId_utensilio() ?>">

                                        <button class='fa-solid fa-square-xmark userDel' title='Eliminar <?php echo $utensilio->getNombre_utensilio(); ?>' type="submit"></button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div class="opcionesAutores">

                                    <!-- Botón para activar o desactivar un utensilio -->
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/utensilioAjax.php" method="POST" autocomplete="off" name="<?php echo $tituloUtensilio.$utensilio->getNombre_utensilio()?>">
                                            <input type="hidden" name="modulo_utensilio" value="cambiarActivo">
                                            <input type="hidden" name="id_utensilio" value="<?php echo $utensilio->getId_utensilio()?>">

                                            <button type="submit" class="<?php echo $iconoUtensilio ?> btnIcon" aria-label="<?php echo $tituloUtensilio.$utensilio->getNombre_utensilio()?>" title="<?php echo $tituloUtensilio.$utensilio->getNombre_utensilio().'" style="color:'.$colorUtensilio?>">
                                            </button> 
                                    </form>
                                </div>
                            </td>

                        </tr>


                    <?php
                        }
                    ?>

                </tbody>
            </table>
        </div>


    </div>
</section>