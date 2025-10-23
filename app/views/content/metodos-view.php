<?php
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";

    /* Carga el controlador de métodos de cocción */
    use app\controllers\metodoController;
?>

<section id="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Métodos de cocción</h2>
    </header>
    <div class="contentControl">
        <div id="formAgregarMetodo" class="formAgregarAutor oculto">
            <div class="cabeceraForm">
                <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="desactivarFormulario('formAgregarMetodo')"></button>
            </div>
            <form action="<?php echo APP_URL; ?>app/ajax/metodoAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
                <input type="hidden" id="accionForm" name="" value="">
                <input type="hidden" id="idForm" name="id_Form" value="">
                <div class="autor">
                    <div class="fotoautor">
                        <img src="<?php echo APP_URL; ?>app/views/photos/metodos_photos/default.png" alt="Foto del método de cocción" id="fotoMetodo">
                    </div>
                    <div class="tituloAutor">
                        <label for="nombreMetodo">Nombre del método de cocción:</label>
                        <input type="text" id="nombreMetodo" class="nombreAutor" name="nombre_metodo" maxlength="80" required value="" placeholder="Nombre del Método de cocción" title="Introduzca el nombre del Método de cocción. Sólo puede contener letras, números, .,-,_ y espacios" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}">
                    </div>
                    <div class="opcionesAutores">
                        <button id="cambiarFotoMetodo" type="button" class="fa-solid fa-camera desactivar" title="Añadir Foto" onclick="document.querySelector('#fotoMetodo-0').click();"></button>
                        <label for="fotoMetodo-0" class="oculto"> Archivo Imagen</label>
                        <input type="file" name="foto_metodo" id="fotoMetodo-0" class="file-input" accept=".jpg, .jpeg, .png" onchange="previewImage(this, 'fotoMetodo', '<?php echo APP_URL; ?>app/views/photos/metodos_photos/default.png');">
                        <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Metodo de cocción"></button>
                    </div>
                </div>
            </form>
        </div>

        <form name="Buscar Metodos" action="" class="filtrarTablas">
            <label for="busquedaMetodos">Buscar Método de cocción</label>
            <input type="text" name="busquedaMetodos" id="busquedaMetodos" class="input" onkeyup="filtrarTablas(this.id, 'metodoList')">
        </form>
        <div class="botonesLista">
            <a href="#formAgregarMetodo">
                <button class="btn" type="button" onclick="activarFormulario('modulo_metodo', 'formAgregarMetodo', 'guardar', '')">Añadir Método de cocción</button>
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
                <tbody id="metodoList">
                    <?php
                        /* Crea una instancia del controlador de métodos de cocción */
                        $listaMetodos = new metodoController();

                        /* Llama al método de la lista para obtener los tipos */
                        $listaMetodos = $listaMetodos->listarMetodosControlador();

                        /* Recorre la lista de tipos para insertar cada tipo en una fila de la tabla */
                        foreach($listaMetodos as $metodo){
                    ?>

                        <tr class='userUserList' id='<?php echo $metodo->getId_metodo(); ?>'>
                            <td class='fotoPeque'>
                                <div class='fotoAutorLista'>
                                    <img src='<?php echo APP_URL; ?>app/views/photos/metodos_photos/<?php echo $metodo->getFoto_metodo(); ?>' alt='Foto de <?php echo $metodo->getNombre_metodo(); ?>'>
                                </div>
                            </td>
                            <td><?php echo $metodo->getNombre_metodo(); ?></td>
                            <td>
                                <div class="opcionesAutores">
                                    <button class="fa-regular fa-pen-to-square" title='Actualizar datos de <?php echo $metodo->getNombre_metodo(); ?>' onclick='activarFormulario("modulo_metodo", "formAgregarMetodo", "actualizar", <?php echo json_encode($metodo); ?>);'></button>
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/metodoAjax.php" method="POST" autocomplete="off" name="Eliminar <?php echo $metodo->getNombre_metodo()?>">
                                        <input type="hidden" name="modulo_metodo" value="eliminar">
                                        <input type="hidden" name="id_metodo" value="<?php echo $metodo->getId_metodo() ?>">

                                        <button class='fa-solid fa-square-xmark userDel' title='Eliminar <?php echo $metodo->getNombre_metodo(); ?>' type="submit"></button>
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