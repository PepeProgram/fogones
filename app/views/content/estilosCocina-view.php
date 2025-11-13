<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";

    /* Carga el controlador de estilos de cocina */
    use app\controllers\estiloCocinaController;

?>
<section name="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Estilos de Cocina</h2>
    </header>
    <div class="contentControl">

        <div id="formAgregarEstilo" class="formAgregarAutor oculto">
            <div class="cabeceraForm">
                <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="desactivarFormulario('formAgregarEstilo');"></button>
            </div>
            <form action="<?php echo APP_URL; ?>app/ajax/estiloCocinaAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
                <input type="hidden" id="accionForm" name="" value="">
                <input type="hidden" id="idForm" name="id_Form" value="">
                <div class="autor">
                    <div class="fotoautor">
                        <img src="<?php echo APP_URL; ?>app/views/photos/styles_photos/default.png" alt="Foto del Estilo de Cocina" id="fotoEstilo">
                    </div>
                    <div class="tituloAutor">
                        <label for="nombreEstilo">Nombre del Estilo de Cocina:</label>
                        <input type="text" id="nombreEstilo" class="nombreAutor" name="nombre_estilo" maxlength="80" required value="" placeholder="Nombre del Estilo de Cocina" title="Introduzca el nombre del Estilo de Cocina. Sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres" pattern="[,;:()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}">
                    </div>
                    <div class="opcionesAutores">
                        <button id="cambiarFotoEstilo" type="button" class="fa-solid fa-camera desactivar" title="Añadir Foto" onclick="document.querySelector('#fotoEstilo-0').click();"></button>
                        <label for="fotoEstilo-0" class="oculto">Archivo Imagen</label>
                        <input type="file" name="foto_estilo" id="fotoEstilo-0" class="file-input" accept=".jpg, .jpeg, .png" onchange="previewImage(this, 'fotoEstilo', '<?php echo APP_URL; ?>app/views/photos/styles_photos/default.png');">
                        <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Estilo de Cocina"></button>
                    </div>
                </div>
            </form>
        </div>

        <form name="Buscar Estilos" action="" class="filtrarTablas">
            <label for="busquedaEstilos">Buscar Estilo de Cocina</label>
            <input type="text" name="busquedaEstilos" id="busquedaEstilos" class="input" onkeyup="filtrarTablas(this.id, 'estiloList');">
        </form>
        <div class="botonesLista">
            <a href="#formAgregarEstilo">
                <button class="btn" type="button" onclick="activarFormulario('modulo_estilo', 'formAgregarEstilo', 'guardar', '');">Añadir Estilo de Cocina</button>
            </a>
        </div>
        <div class="listaUsuarios">
            <table class="userList peque">
                <thead>
                    <tr class="headerUserList">
                        <th class="fotoPeque">Foto</th>
                        <th colspan="2">Nombre</th>
                    </tr>
                </thead>
                <tbody id="estiloList">
                    <?php
                        /* Crea una instancia del controlador de Estilos de Cocina */
                        $listaEstilos = new estiloCocinaController();

                        /* Llama al método de la lista de estilos de cocina para obtener los estilos de cocina */
                        $listaEstilos = $listaEstilos->listarEstilosCocinaControlador();

                        /* Recorre la lista de estilos de cocina para insertar cada estilo en una fila de la tabla */
                        foreach ($listaEstilos as $estilo) {
                            
                        
                    ?>

                        <tr class='userUserList' id='<?php echo $estilo->getId_estilo(); ?>'>
                            <td class="fotoPeque">
                                <div class='fotoAutorLista foto'>
                                    <img src='<?php echo APP_URL; ?>app/views/photos/styles_photos/<?php echo $estilo->getFoto_estilo(); ?>' alt='Foto de <?php echo $estilo->getNombre_estilo(); ?>'>
                                </div>
                            </td>
                            <td><?php echo $estilo->getNombre_estilo(); ?></td>
                            <td>
                                <div class='opcionesAutores'>
                                    <button class='fa-regular fa-pen-to-square' title='Actualizar datos de <?php echo $estilo->getNombre_estilo(); ?>' onclick='activarFormulario("modulo_estilo", "formAgregarEstilo", "actualizar", <?php echo json_encode($estilo); ?>);'></button>
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/estiloCocinaAjax.php" method="POST" autocomplete="off" name="Eliminar <?php echo $estilo->getNombre_estilo()?>">
                                        <input type="hidden" name="modulo_estilo" value="eliminar">
                                        <input type="hidden" name="id_estilo" value="<?php echo $estilo->getId_estilo() ?>">

                                        <button class='fa-solid fa-square-xmark userDel' title='Eliminar <?php echo $estilo->getNombre_estilo(); ?>' type="submit"></button>
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