<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";

    /* Carga el controlador de grupos de plato */
    use app\controllers\grupoPlatoController;

?>

<section id="contenido">
    <header class="tituloPagina">
        <h2>Grupos de platos</h2>
    </header>
    <div class="contentControl">

        <div id="formAgregarGrupo" class="formAgregarAutor oculto">
            <div class="cabeceraForm">
                <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="desactivarFormulario('formAgregarGrupo');"></button>
            </div>
            <form action="<?php echo APP_URL; ?>app/ajax/grupoPlatoAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
                <input type="hidden" id="accionForm" name="" value="">
                <input type="hidden" id="idForm" name="id_Form" value="">
                <div class="autor">
                    <div class="fotoautor">
                        <img src="<?php echo APP_URL; ?>app/views/photos/groups_photos/default.png" alt="Foto del Grupo de platos" id="fotoGrupo">
                    </div>
                    <div class="tituloAutor">
                        <label for="nombreGrupo">Nombre del Grupo:</label>
                        <input type="text" id="nombreGrupo" class="nombreAutor" name="nombre_grupo" maxlength="80" required value="" placeholder="Nombre del Grupo de Platos" title="Introduzca el nombre del Grupo de Platos. Sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 80 caracteres" pattern="[(),;:%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,80}">
                    </div>
                    <div class="opcionesAutores">
                        <button id="cambiarFotoGrupo" type="button" class="fa-solid fa-camera desactivar" title="Añadir Foto" onclick="document.querySelector('#fotoGrupo-0').click();"></button>
                        <label for="fotoGrupo-0" class="oculto">Archivo Imagen</label>
                        <input type="file" name="foto_grupo" id="fotoGrupo-0" class="file-input" accept=".jpg, .jpeg, .png" onchange="previewImage(this, 'fotoGrupo', '<?php echo APP_URL; ?>app/views/photos/groups_photos/default.png');">
                        <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Grupo de Platos"></button>
                    </div>
                </div>
            </form>
        </div>

        <form name="Buscar Grupos" action="" class="filtrarTablas">
            <label for="busquedaGrupos">Buscar Grupo de platos</label>
            <input type="text" name="busquedaGrupos" id="busquedaGrupos" class="input" onkeyup="filtrarTablas(this.id, 'grupoList');">
        </form>
        <div class="botonesLista">
            <a href="#formAgregarGrupo">
                <button class="btn" type="button" onclick="activarFormulario('modulo_grupo', 'formAgregarGrupo', 'guardar', '');">Añadir Grupo</button>
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
                <tbody id="grupoList">
                    <?php
                        /* Crea una instancia del controlador de grupos de plato */
                        $listaGrupos = new grupoPlatoController();

                        /* Llama al método de la lista de grupos para obtener los grupos */
                        $listaGrupos = $listaGrupos->listarGruposPlatosControlador();

                        /* Recorre la lista de grupos para insertar cada grupo en una fila de la tabla */
                        foreach ($listaGrupos as $grupo) {
                            
                        
                    ?>

                        <tr class='userUserList' id='<?php echo $grupo->getId_grupo(); ?>'>
                            <td class="fotoPeque">
                                <div class='fotoAutorLista foto'>
                                    <img src='<?php echo APP_URL; ?>app/views/photos/groups_photos/<?php echo $grupo->getFoto_grupo(); ?>' alt='Foto de <?php echo $grupo->getNombre_grupo(); ?>'>
                                </div>
                            </td>
                            <td><?php echo $grupo->getNombre_grupo(); ?></td>
                            <td>
                                <div class='opcionesAutores'>
                                    <button class='fa-regular fa-pen-to-square' title='Actualizar datos de <?php echo $grupo->getNombre_grupo(); ?>' onclick='activarFormulario("modulo_grupo", "formAgregarGrupo", "actualizar", <?php echo json_encode($grupo); ?>);'></button>
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/grupoPlatoAjax.php" method="POST" autocomplete="off" name="Eliminar <?php echo $grupo->getNombre_grupo()?>">
                                        <input type="hidden" name="modulo_grupo" value="eliminar">
                                        <input type="hidden" name="id_grupo" value="<?php echo $grupo->getId_grupo() ?>">

                                        <button class='fa-solid fa-square-xmark userDel' title='Eliminar <?php echo $grupo->getNombre_grupo(); ?>' type="submit"></button>
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