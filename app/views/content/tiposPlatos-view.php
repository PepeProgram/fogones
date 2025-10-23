<?php
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";

    /* Carga el controlador de tipos de plato */
    use app\controllers\tipoPlatoController;
?>

<section id="contenido">
    <header class="tituloPagina">
        <h2>Tipos de platos</h2>
    </header>
    <div class="contentControl">
        <div id="formAgregarTipo" class="formAgregarAutor oculto">
            <div class="cabeceraForm">
                <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="desactivarFormulario('formAgregarTipo')"></button>
            </div>
            <form action="<?php echo APP_URL; ?>app/ajax/tipoPlatoAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
                <input type="hidden" id="accionForm" name="" value="">
                <input type="hidden" id="idForm" name="id_Form" value="">
                <div class="autor">
                    <div class="fotoautor">
                        <img src="<?php echo APP_URL; ?>app/views/photos/tipos_photos/default.png" alt="Foto del tipo de plato" id="fotoTipo">
                    </div>
                    <div class="tituloAutor">
                        <label for="nombreTipo">Nombre del tipo de plato:</label>
                        <input type="text" id="nombreTipo" class="nombreAutor" name="nombre_tipo" maxlength="80" required value="" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}" placeholder="Nombre del Tipo de platos" title="Introduzca el nombre del Tipo de platos. Sólo puede contener letras, números, .,-,_ y espacios">
                    </div>
                    <div class="opcionesAutores">
                        <button id="cambiarFotoTipo" type="button" class="fa-solid fa-camera desactivar" title="Añadir Foto" onclick="document.querySelector('#fotoTipo-0').click();"></button>
                        <label for="fotoTipo-0" class="oculto"> Archivo Imagen</label>
                        <input type="file" name="foto_tipo" id="fotoTipo-0" class="file-input" accept=".jpg, .jpeg, .png" onchange="previewImage(this, 'fotoTipo', '<?php echo APP_URL; ?>app/views/photos/tipos_photos/default.png');">
                        <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Tipo de platos"></button>
                    </div>
                </div>
            </form>
        </div>

        <form name="Buscar Tipos" action="" class="filtrarTablas">
            <label for="busquedaTipos">Buscar Tipo de platos</label>
            <input type="text" name="busquedaTipos" id="busquedaTipos" class="input" onkeyup="filtrarTablas(this.id, 'tipoList')">
        </form>
        <div class="botonesLista">
            <a href="#formAgregarTipo">
                <button class="btn" type="button" onclick="activarFormulario('modulo_tipo', 'formAgregarTipo', 'guardar', '')">Añadir Tipo</button>
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
                <tbody id="tipoList">
                    <?php
                        /* Crea una instancia del controlador de tipos de plato */
                        $listaTipos = new tipoPLatoController();

                        /* Llama al método de la lista para obtener los tipos */
                        $listaTipos = $listaTipos->listarTiposPlatoControlador();

                        /* Recorre la lista de tipos para insertar cada tipo en una fila de la tabla */
                        foreach($listaTipos as $tipo){
                    ?>

                        <tr class='userUserList' id='<?php echo $tipo->getId_tipo(); ?>'>
                            <td class='fotoPeque'>
                                <div class='fotoAutorLista'>
                                    <img src='<?php echo APP_URL; ?>app/views/photos/tipos_photos/<?php echo $tipo->getFoto_tipo(); ?>' alt='Foto de <?php echo $tipo->getNombre_tipo(); ?>'>
                                </div>
                            </td>
                            <td><?php echo $tipo->getNombre_tipo(); ?></td>
                            <td>
                                <div class="opcionesAutores">
                                    <button class="fa-regular fa-pen-to-square" title='Actualizar datos de <?php echo $tipo->getNombre_tipo(); ?>' onclick='activarFormulario("modulo_tipo", "formAgregarTipo", "actualizar", <?php echo json_encode($tipo); ?>);'></button>
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/tipoPlatoAjax.php" method="POST" autocomplete="off" name="Eliminar <?php echo $tipo->getNombre_tipo()?>">
                                        <input type="hidden" name="modulo_tipo" value="eliminar">
                                        <input type="hidden" name="id_tipo" value="<?php echo $tipo->getId_tipo() ?>">

                                        <button class='fa-solid fa-square-xmark userDel' title='Eliminar <?php echo $tipo->getNombre_tipo(); ?>' type="submit"></button>
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