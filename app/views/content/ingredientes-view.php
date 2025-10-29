<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";

    /* Carga el controlador de ingredientes */
    use app\controllers\ingredienteController;

    /* Carga el controlador de alérgenos */
    use app\controllers\alergenoController;

?>
<section name="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Ingredientes</h2>
    </header>
    <div class="contentControl">

        <div id="formAgregarIngrediente" class="formAgregarIngrediente oculto">
            
            <div class="cabeceraForm">
                <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="desactivarFormulario('formAgregarIngrediente');"></button>
            </div>
            
            <form action="<?php echo APP_URL; ?>app/ajax/ingredienteAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
                <input type="hidden" id="accionForm" name="" value="">
                <input type="hidden" id="idForm" name="id_Form" value="">
                <div class="autor">
                    
                    <div class="tituloAutor">
                        <label for="nombreIngrediente">Nombre del Ingrediente:</label>
                        <input type="text" id="nombreIngrediente" class="nombreAutor" name="nombre_ingrediente" maxlength="80" required value="" placeholder="Nombre del Ingrediente" title="Introduzca el nombre del Ingrediente. Sólo puede contener letras, números, .,-,_ y espacios" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}">
                    </div>
                    <div class="opcionesAutores">
                        <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Ingrediente"></button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Select para seleccionar un ingrediente para añadir al alérgeno -->
        <div id="selectAgregarAlergeno" class="formAgregarIngrediente oculto">
            <div class="cabeceraForm">
                <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="desactivarFormulario('selectAgregarAlergeno');"></button>
            </div>
            <form action="<?php echo APP_URL; ?>app/ajax/ingredienteAjax.php" class="FormularioAjax" method="POST" name="">
                <input type="hidden" id="accionFormAgregar" name="" value="">
                <input type="hidden" id="idFormAgregar" name="id_Form" value="">
                <input type="hidden" id="alergenos" name="alergenos" value="agregarAlergeno">
                <div class="autor">
                    <div class="tituloAutor">
                        <label for="agregarAlergeno" class="labelForm">Seleccione un alérgeno</label>
                        <select name="agregarAlergeno" id="alergeno" size="5" required>

                            <!-- Crea una instancia del controlador de alérgenos para obtener la lista -->
                            <?php
                                $listaAlergenos = new alergenoController();
                                $listaAlergenos = $listaAlergenos->listarAlergenosControlador();
                                
                                /* Recorre la lista para poner los alérgenos en las opciones */
                                foreach ($listaAlergenos as $alergeno) {
                                    echo "<option value='".$alergeno->getId_alergeno()."'>".$alergeno->getNombre_alergeno()."</option>";
                                }
                            ?>

                        </select>
                    </div>
                    <div class="opcionesAutores">
                        <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Agregar alérgeno"></button>
                    </div>
                </div>
            </form>
        </div>

        <form name="Buscar Ingredientes" action="" class="filtrarTablas">
            <label for="busquedaIngredientes">Buscar Ingrediente</label>
            <input type="text" name="busquedaIngredientes" id="busquedaIngredientes" class="input" onkeyup="filtrarTablas(this.id, 'ingredienteList');">
        </form>
        <div class="botonesLista">

            <!-- Botón para ver todos los ingredientes -->
            <a href=<?php echo APP_URL."ingredientes" ?>>
                <button class="btn">Todos</button>
            </a>

            <!-- Botón para agregar un ingrediente -->
            <a href="#formAgregarIngrediente">
                <button class="btn" type="button" onclick="activarFormulario('modulo_ingrediente', 'formAgregarIngrediente', 'guardar', '');">Añadir Ingrediente</button>
            </a>

            <!-- Comprueba si hay utensilios pendientes de revisión -->
            <?php 
                $ingredientesPendientes = new ingredienteController();
                if ($ingredientesPendientes->revisaringredientesControlador()) {
                    $ocultar = "";
                }
                else{
                    $ocultar = "oculto";
                }
            ?>
            
            <!-- Botón para ver los ingredientes pendientes de revisión -->
            <a href=<?php echo APP_URL."ingredientes/paraRevisar/" ?> class="<?php echo $ocultar ?>">
                <button class="btn btnAlerta">Pendientes de Revisión!!!</button>
            </a>
        </div>
        <div class="listaUsuarios">
            <table class="userList peque">
                <thead>
                    <tr class="headerUserList">
                        <th>Nombre</th>
                        <th>Alergenos</th>
                        <th>Opc.</th>
                        <th>Ac.</th>
                    </tr>
                </thead>
                <tbody id="ingredienteList">
                    <?php
                        /* Crea una instancia del controlador de Ingredientes */
                        $listaIngredientes = new ingredienteController();

                        /* Llama al método de la lista de ingredientes para obtener los ingredientes */
                        $listaIngredientes = $listaIngredientes->listarIngredientesControlador();

                        /* Recorre la lista de ingredientes para insertar cada ingrediente en una fila de la tabla */
                        foreach ($listaIngredientes as $ingrediente) {

                            /* Comprueba si el ingrediente está activo o no */
                            if ($ingrediente->getActivo_ingrediente()) {
                                $iconoIngrediente = "fa-regular fa-square-check";
                                $tituloIngrediente = "Desactivar ";
                                $colorIngrediente = "green";
                            } else {
                                $iconoIngrediente = "fa-regular fa-square";
                                $tituloIngrediente = "Activar ";
                                $colorIngrediente = "grey";
                            }

                            /* Obtiene los alérgenos del ingrediente */
                            $alergenos = $ingrediente->getAlergenos_ingrediente();
                            
                        
                    ?>

                        <tr class='userUserList' id='<?php echo $ingrediente->getId_ingrediente(); ?>'>
                            <td>
                                <?php echo $ingrediente->getNombre_ingrediente(); ?>
                            </td>
                            <td>
                                <div class="opcionesAutores">

                                    <!-- Recorre el array de alérgenos del ingrediente para obtener los datos de los alérgenos -->
                                    <?php
                                        foreach ($alergenos as $alergeno) {

                                            /* Crea una instancia del controlador de ingredientes para obtener los datos de cada alérgeno */
                                            $obtenerDatos = new ingredienteController();

                                            /* Obtiene los datos del alérgeno */
                                            $datos_alergeno = $obtenerDatos->seleccionarDatos('Unico', 'alergenos', 'id_alergeno', $alergeno);
                                            
                                            /* Convierte a array los datos del alérgeno */
                                            $datos_alergeno = $datos_alergeno->fetch();
                                            
                                            /* Obtiene el icono del alérgeno */
                                            $fotoAlergeno = $datos_alergeno['foto_alergeno'];
                                            
                                            /* Concatena la ruta y el nombre de la foto */
                                            $fotoAlergeno = APP_URL."app/views/photos/alergen_photos/".$fotoAlergeno;

                                            /* Obtiene el nombre del alérgeno */
                                            $nombreAlergeno = $datos_alergeno['nombre_alergeno'];
                                    ?>
                                    <div class="iconoAlergenoLista">
                                        <img src="<?php echo $fotoAlergeno?>" alt="<?php echo $nombreAlergeno ?>" title="<?php echo $nombreAlergeno ?>">

                                        <!-- Botón para eliminar un alérgeno de un ingrediente -->
                                        <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/ingredienteAjax.php" method="POST" autocomplete="off" name="Quitar <?php echo $datos_alergeno['nombre_alergeno']?> a <?php echo $ingrediente->getNombre_ingrediente()?>">
                                            <input type="hidden" name="modulo_ingrediente" value="actualizar">
                                            <input type="hidden" name="id_ingrediente" value="<?php echo $ingrediente->getId_ingrediente() ?>">
                                            <input type="hidden" name="id_alergeno" value="<?php echo $datos_alergeno['id_alergeno'] ?>">
                                            <input type="hidden" id="alergenos" name="alergenos" value="quitarAlergeno">


                                            <button class='fa-regular fa-circle-xmark btnQuitarAlergeno userDel' title='Quitar <?php echo $nombreAlergeno ?> a <?php echo $ingrediente->getNombre_ingrediente(); ?>' type="submit"></button>
                                        </form>
                                        

                                    </div>    
                                        
                                    <?php
                                        }
                                    ?>

                                    <!-- Botón para agregar alérgenos a un ingrediente -->
                                    <button class="btnAlergenoLista" title='Actualizar datos de ' onclick='activarFormulario("modulo_ingrediente", "selectAgregarAlergeno", "actualizar", <?php echo json_encode($ingrediente); ?>);'>
                                        <img src="<?php echo APP_URL."app/views/photos/alergen_photos/sinfoto.png" ?>" alt="Añadir alérgeno a <?php echo $ingrediente->getNombre_ingrediente() ?>" title="Añadir alérgeno a <?php echo $ingrediente->getNombre_ingrediente() ?>">  
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class='opcionesAutores'>

                                    <!-- Botón para actualizar los datos de un ingrediente -->
                                    <button class='fa-regular fa-pen-to-square' title='Actualizar datos de <?php echo $ingrediente->getNombre_ingrediente(); ?>' onclick='activarFormulario("modulo_ingrediente", "formAgregarIngrediente", "actualizar", <?php echo json_encode($ingrediente); ?>);'></button>

                                    <!-- Botón para eliminar un ingrediente -->
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/ingredienteAjax.php" method="POST" autocomplete="off" name="Eliminar <?php echo $ingrediente->getNombre_ingrediente()?>">
                                        <input type="hidden" name="modulo_ingrediente" value="eliminar">
                                        <input type="hidden" name="id_ingrediente" value="<?php echo $ingrediente->getId_ingrediente() ?>">

                                        <button class='fa-solid fa-square-xmark userDel' title='Eliminar <?php echo $ingrediente->getNombre_ingrediente(); ?>' type="submit"></button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div class="opcionesAutores">

                                    <!-- Botón para activar o desactivar un ingrediente -->
                                    <form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/ingredienteAjax.php" method="POST" autocomplete="off" name="<?php echo $tituloIngrediente.$ingrediente->getNombre_ingrediente()?>">
                                            <input type="hidden" name="modulo_ingrediente" value="cambiarActivo">
                                            <input type="hidden" name="id_ingrediente" value="<?php echo $ingrediente->getId_ingrediente()?>">

                                            <button type="submit" class="<?php echo $iconoIngrediente ?> btnIcon" aria-label="<?php echo $tituloIngrediente.$ingrediente->getNombre_ingrediente()?>" title="<?php echo $tituloIngrediente.$ingrediente->getNombre_ingrediente().'" style="color:'.$colorIngrediente?>">
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