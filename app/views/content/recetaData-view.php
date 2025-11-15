<?php
    /* Comprueba si hay sesión iniciada */
    if (!(isset($_SESSION['id']) && isset($_SESSION['nombre']) && isset($_SESSION['login']))) {
        echo "
                <script>
                    textoAlerta = {
                        tipo: 'simple',
                        icono: 'error',
                        titulo: 'Usuario sin identificar',
                        texto: 'No tiene privilegios para realizar esta acción',
                        confirmButtonText: 'Aceptar',
                        colorIcono: 'red',
                        url: '".APP_URL."'};
                    ventanaModal(textoAlerta);
                </script>
            ";
    } 

    /* Comprueba si el usuario es administrador o redactor */
    if (!isset($_SESSION['administrador'])) {

        /* Comprueba si el usuario es redactor */
        if (!isset($_SESSION['redactor'])) {
            # code...
            echo "
            <script>
            textoAlerta = {
                tipo: 'redirigir',
                icono: 'error',
                titulo: 'Acción no permitida',
                texto: 'No puede acceder a esta sección',
                confirmButtonText: 'Aceptar',
                colorIcono: 'red',
                url: '".APP_URL."'};
                ventanaModal(textoAlerta);
                </script>
                ";
                exit();
        }
    }
?>

<script type="text/javascript">

    /* Rellena los select desde la base de datos */
    window.addEventListener('load', function(){

        /* Rellena el select de zonas geográficas */
        rellenarSelect('', 'zonaEnviarReceta', 'zonas', '');

        /* Rellena el select de Estilos de cocina */
        rellenarSelect('', 'estiloCocinaEnviarReceta', 'estilos_cocina', '');
        
        /* Rellena el select de Estilos de cocina */
        rellenarSelect('', 'tipoPlatoEnviarReceta', 'tipos_plato', '');
        
        /* Rellena el select de Métodos de cocción */
        rellenarSelect('', 'metodoEnviarReceta', 'tecnicas', '');
        
        /* Rellena el select de Grupos de platos */
        rellenarSelect('', 'grupoPlatosEnviarReceta', 'grupos_plato', '');
        
        /* Rellena el select de utensilios */
        rellenarSelect('activable', 'selectUtensiliosEnviarReceta', 'utensilios', '' );

        /* Rellena el select de ingredientes */
        rellenarSelect('activable', 'selectIngredientesEnviarReceta', 'ingredientes', '' );
    });
</script>

<header class="tituloPagina">
    <h1>Enviar una nueva receta</h1>
    <?php include "./app/views/inc/btn_back.php"; ?>
</header>

<!-- Formulario para añadir un utensilio -->
<div id="formAgregarUtensilio" class="formAgregarAutor oculto">

    <!-- Crea el input oculto para ir guardando los id de los utensilios que hay en la lista de utensilios -->
    <input type="hidden" name="arrayUtensilios" form="formEnviarReceta" id="arrayUtensilios" class="arrayUtensilios">
    <label for="arrayUtensilios" class="oculto">Lista de utensilios</label>
    
    <!-- Div que contiene el formulario de agregar utensilios nuevos -->
    <div class="cabeceraForm">
        <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="ocultarFormulario('formAgregarUtensilio');"></button>
    </div>
    <form action="<?php echo APP_URL; ?>app/ajax/utensilioAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
        <input type="hidden" id="accionForm_formAgregarUtensilio" name="" value="">
        <input type="hidden" id="idForm_formAgregarUtensilio" name="id_Form" value="">
        <input type="hidden" id="listaForm" name="listaForm" value="listaUtensiliosEnviarReceta">
        <input type="hidden" id="selectForm" name="selectForm" value="selectUtensiliosEnviarReceta">
        <div class="autor">
            <div class="fotoautor">
                <img src="<?php echo APP_URL; ?>app/views/photos/utensilios_photos/default.png" alt="Foto del Utensilio de Cocina" id="fotoUtensilio">
            </div>
            <div class="tituloAutor">
                <label for="nombreUtensilio">Nombre del Utensilio de Cocina:</label>
                <input type="text" id="nombreUtensilio" class="nombreAutor" name="nombre_utensilio" maxlength="80" required value="" placeholder="Nombre del Utensilio de Cocina" maxlength="80" pattern="[()%;a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,:\/\-_ ]{3,80}" title="Introduzca el nombre del Tipo de platos. Sólo puede contener letras, números, (), %, ;, ., ,, :,-,/,_ y espacios. Entre 3 y 80 caracteres">
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

<!-- Formulario para añadir un ingrediente -->
<div id="formAgregarIngrediente" class="formAgregarIngrediente oculto">

    <!-- Crea el input oculto para ir guardando los id de los ingredientes que hay en la lista de ingredientes -->
    <input type="hidden" name="arrayIngredientes" form="formEnviarReceta" id="arrayIngredientes" class="arrayIngredientes">
    <label for="arrayIngredientes" class="oculto">Lista de ingredientes</label>

    <!-- Div que contiene el formulario de agregar ingredientes nuevos -->
    <div class="cabeceraForm">
        <button class="fa-solid fa-xmark" title="Cerrar Formulario" onclick="ocultarFormulario('formAgregarIngrediente');"></button>
    </div>
    <form action="<?php echo APP_URL; ?>app/ajax/ingredienteAjax.php" class="FormularioAjax" method="POST" enctype="multipart/form-data" name="">
        <input type="hidden" id="accionForm_formAgregarIngrediente" name="" value="">
        <input type="hidden" id="idForm_formAgregarIngrediente" name="id_Form" value="">
        <input type="hidden" id="listaForm" name="listaForm" value="listaIngredientesEnviarReceta">
        <input type="hidden" id="selectForm" name="selectForm" value="selectIngredientesEnviarReceta">
        <div class="autor">
            <div class="tituloAutor">
                <label for="nombreIngrediente">Nombre del Ingrediente:</label>
                <input type="text" id="nombreIngrediente" class="nombreAutor" name="nombre_ingrediente" maxlength="80" required value="" placeholder="Nombre del Ingrediente" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,:\/\-_ ]{3,80}" title="Introduzca el nombre del Tipo de platos. Sólo puede contener letras, números, (), %, ;, ., ,, :,-,/,_ y espacios, un mínimo 3 y máximo 80 caracteres">
            </div>
            <div class="opcionesAutores">
                <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Ingrediente"></button>
            </div>
        </div>
    </form>
</div>
<p class="notas centrar">Los campos con * son obligatorios</p>

<!-- Formulario para enviar la receta -->
<form action="<?php echo APP_URL; ?>app/ajax/recetaAjax.php" id="formEnviarReceta" method="POST" class="FormularioAjax" enctype="multipart/form-data" name="Guardar Receta?">
    
    <!-- Campo que indica que viene del módulo recetas y la acción que tiene que realizar -->
    <input type="hidden" name="modulo_receta" value="guardar">
    
    <!-- Cabecera de la receta con la foto -->
    <section name="resumen" id="cabeceraEnviarReceta" class="cabeceraEnviarReceta col-100 horizontal total">

        <!-- Foto de la receta -->
        <div id="fotoCabeceraEnviarReceta" class="fotoCabeceraEnviarReceta foto col-25 total vertical izquierda">
            <img id="fotoReceta" src="<?php echo APP_URL.'app/views/photos/recetas_photos/default.png' ?>" alt="Receta Sin Foto">
            <div id="btnsFotoReceta" class="btnsFotoReceta">
                <button id="quitarFotoReceta" type="button" class="fa-solid fa-square-xmark btnFotoReceta userDel" title="Quitar Foto" onclick="eliminarFotoReceta();"></button>
                <label for="fotoReceta-0" class="oculto">Archivo Imagen</label>
                <input type="file" name="foto_receta" id="fotoReceta-0" class="file-input" accept=".jpg, .jpeg, .png" onchange="previewImage(this, 'fotoReceta', '<?php echo APP_URL; ?>app/views/photos/recetas_photos/default.png');">
                <button id="cambiarFotoReceta" type="button" class="fa-solid fa-camera btnFotoReceta" title="Añadir Foto en formato jpg o png. Máximo 5 Mb." onclick="document.querySelector('#fotoReceta-0').click();"></button>
            </div>
        </div>

        <!-- Ficha corta de la receta -->
        <div id="containerDatosPrincipalesEnviarReceta" class="containerDatosPrincipalesEnviarReceta col-75 total derecha vertical">
            
            <!-- Nombre, nº de personas, dificultad -->
            <div class="nombrePrincipalesInput medio izquierda derecha top horizontal">
                <div class="vertical col-40 medio izquierda top">
                    <label for="nombreReceta" class="labelForm">Nombre del plato*</label>
                    <input type="text" name="nombreReceta" id="nombreReceta" class="input  nombreReceta" maxlength="255" pattern="[\(\)%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,:;\/\-_ ]{3,255}" title="Introduzca el nombre del Tipo de platos. Sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios, entre 3 y 255 caracteres">
                </div>
                <div class="vertical col-20 medio top">
                    <label for="numeroPersonasEnviarReceta" class="labelForm">Pax.*</label>
                    <input type="number" name="numeroPersonasEnviarReceta" id="numeroPersonasEnviarReceta" class="input numeroPersonasEnviarReceta" min="1">
                </div>
                <div class="vertical col-20 medio top">
                    <label for="tiempoElaboracionEnviarReceta" class="labelForm">Tiempo*</label>
                    <input type="time" name="tiempoElaboracionEnviarReceta" id="tiempoElaboracionEnviarReceta" class="input tiempoElaboracionEnviarReceta">
                </div>
                <div class="vertical col-20 medio derecha top">
                    <label for="dificultadEnviarReceta" class="labelForm">Dificultad*</label>
                    <select name="dificultadEnviarReceta" id="dificultadEnviarReceta" class="input dificultadEnviarReceta">
                        <option value="0" selected disabled>Seleccione</option>
                        <option value="1" class="selectDificultadEnviarReceta">
                            &starf;&star;&star;&star;&star;
                        </option>
                        <option value="2" class="selectDificultadEnviarReceta">
                            &starf;&starf;&star;&star;&star;
                        </option>
                        <option value="3" class="selectDificultadEnviarReceta">
                            &starf;&starf;&starf;&star;&star;
                        </option>
                        <option value="4" class="selectDificultadEnviarReceta">
                            &starf;&starf;&starf;&starf;&star;
                        </option>
                        <option value="5" class="selectDificultadEnviarReceta">
                            &starf;&starf;&starf;&starf;&starf;
                        </option>
                    </select>
                </div>
            </div>

            <div class="datosPrincipalesEnviarReceta col-100 horizontal bottom">
                
                <!-- Estilo de cocina -->
                <div class="selectEnviarReceta col-25 medio izquierda vertical">
                    <label for="estiloCocinaEnviarReceta" class="labelForm">Estilo de Cocina<span class="notas"><br>Ctrl-click para más de uno</span></label>
                    <select name="estiloCocinaEnviarReceta[]" id="estiloCocinaEnviarReceta" class="input estiloCocinaEnviarReceta" multiple>
                        <option value="0" class="selectEstiloCocinaEnviarReceta oculto" selected disabled>Seleccione estilos de cocina</option>

                    </select>
                </div>
                
                <!-- Tipo de plato -->
                <div class="selectEnviarReceta col-25 medio vertical">
                    <label for="tipoPlatoEnviarReceta" class="labelForm">Tipo de plato*<span class="notas"><br>Ctrl-click para más de uno</span></label>
                    <select name="tipoPlatoEnviarReceta[]" id="tipoPlatoEnviarReceta" class="input tipoPlatoEnviarReceta" multiple>
                        <option value="0" class="selectTipoPlatoEnviarReceta oculto" selected disabled>Seleccione tipos de plato</option>

                    </select>
                </div>
                
                <!-- Método de cocción -->
                <div class="selectEnviarReceta col-25 medio vertical">
                    <label for="metodoEnviarReceta" class="labelForm">Métodos<span class="notas"><br>Ctrl-click para más de uno</span></label>
                    <select name="metodoEnviarReceta[]" id="metodoEnviarReceta" class="input metodoEnviarReceta" multiple>
                        <option value="0" class="selectMetodoEnviarReceta oculto" selected disabled>Seleccione métodos de cocción</option>
                        
                    </select>
                </div>

                <!-- Grupo de platos -->
                <div class="selectEnviarReceta col-25 medio vertical derecha">
                    <label for="grupoPlatosEnviarReceta" class="labelForm">Grupo de Platos*<span class="notas"><br>Seleccione uno</span></label>
                    <select name="grupoPlatosEnviarReceta" id="grupoPlatosEnviarReceta" class="input grupoPlatosEnviarReceta" size="4">
                        <option value="0" class="selectGrupoPlatosEnviarReceta oculto" selected disabled>Seleccione un grupo de platos</option>

                    </select>
                </div>
            </div>

            <!-- Descripción Corta de la receta -->
            <div id="descripcionEnviarReceta" class="descripcionEnviarReceta col-100 vertical">
                <label for="descripcionCorta" class="labelForm">Descripción Corta de la Receta*</label>
                <textarea name="descripcionCorta" rows="4" id="descripcionCorta" class="descripcionCorta inputText" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,:\/\-_ ]{3,255}" maxlength="255" title="Introduzca una descripción corta. Sólo puede contener letras, números, ., ,, :, -,/,_ y espacios. Mínimo 3 caracteres y máximo 255"></textarea>
            </div>
        </div>
    </section>

    <!-- Localización, utensilios, ingredientes -->
    <section name="Localización, utensilios e ingredientes" id="localizacionUtensiliosIngredientes" class="localizacionUtensiliosIngredientes col-100 horizontal total top bottom">

        <!-- Área geográfica, país, region -->
        <div id="geografiaEnviarReceta" class="geografiaEnviarReceta vertical col-20 izquierda top">

            <div class="selectEnviarReceta col-100 medio izquierda vertical top">
                <label for="zonaEnviarReceta" class="labelForm">Zona Geográfica</label>
                <select name="zonaEnviarReceta" id="zonaEnviarReceta" class="zonaEnviarReceta input" onchange="rellenarSelect(this.value, 'paisEnviarReceta', 'paises', 'id_zona');">
                    <option value="0" class="selectZonaEnviarReceta">Seleccione uno</option>


                </select>
            </div>
            <div class="selectEnviarReceta col-100 medio izquierda vertical top">
                <label for="paisEnviarReceta" class="labelForm">País</label>
                <select name="paisEnviarReceta" id="paisEnviarReceta" class="paisEnviarReceta input" onchange="rellenarSelect(this.value, 'regionEnviarReceta', 'regiones', 'id_pais');">
                    <option value="0" class="selectPaisEnviarReceta">Seleccione uno</option>


                </select>
            </div>
            <div class="selectEnviarReceta col-100 medio izquierda vertical top">
                <label for="regionEnviarReceta" class="labelForm">Región o estado</label>
                <select name="regionEnviarReceta" id="regionEnviarReceta" class="regionEnviarReceta input">
                    <option value="0" class="selectRegionEnviarReceta">Seleccione uno</option>


                </select>
            </div>
        </div>

        <!-- Utensilios -->
        <div id="utensiliosEnviarReceta" class="utensiliosEnviarReceta vertical static col-40 top">

            <div class="selectEnviarReceta medio vertical top col-100">
                <fieldset id="containerListaUtensiliosEnviarReceta" class="containerListaUtensiliosEnviarReceta vertical col-100 static listasEnviarReceta">
                    <legend class="tituloListas">Lista de utensilios:</legend>
                    <!-- Lista de los utensilios que se van añadiendo a la receta -->
                    <ul id="listaUtensiliosEnviarReceta">
                        
                    </ul>
                    <!-- ¡¡¡NOTA!!!: El array donde se guardan los id de los utensilios de la lista está junto al formulario de agregar nuevos utensiliosj para poder seleccionarlo de forma más fácil al añadir un nuevo utensilio -->
                </fieldset>
            </div>

            <div id="agregarUtensiliosEnviarReceta" class="agregarUtensiliosEnviarReceta vertical col-100">
                <div class="selectEnviarReceta col-100 medio vertical top bottom">
                    <label for="selectUtensiliosEnviarReceta" class="labelForm">Seleccione utensilios</label>
                    <select name="selectUtensiliosEnviarReceta" id="selectUtensiliosEnviarReceta" class="selectUtensiliosEnviarReceta input" size="5">
                        <option value="0" class="optionUtensiliosEnviarReceta oculto" disabled>Añada utensilios a la lista</option>
                    
                    </select>
                </div>
                <div class="selectEnviarReceta medio izquierda col-100 horizontal top">

                    <!-- Botón para agregar un utensilio a la lista -->
                    <button id="btnSeleccionarUtensiliosEnviarReceta" class="btnSeleccionarUtensiliosEnviarReceta btn btnListas col-50" onclick="agregarElementoLista(event, 'selectUtensiliosEnviarReceta', 'listaUtensiliosEnviarReceta', 'arrayUtensilios');">Añadir a lista</button>

                    <!-- Botón para añadir un nuevo utensilio de cocina -->
                    <button id="btnAgregarUtensiliosEnviarReceta" class="btnAgregarUtensiliosEnviarReceta btn btnListas col-50" type="button" onclick="activarFormulario('subform_modulo_receta', 'formAgregarUtensilio', 'guardar', '');">Añadir Nuevo</button>

                </div>
            </div>
            
        </div>

        <!-- Ingredientes -->

        <div id="ingredientesEnviarReceta" class="ingredientesEnviarReceta vertical static col-40 top">
            <div class="selectEnviarReceta medio vertical derecha top col-100">
                <fieldset id="containerListaIngredientesEnviarReceta" class="containerListaIngredientesEnviarReceta vertical col-100 listasEnviarReceta">
                    <legend class="tituloListas">Lista de Ingredientes:</legend>
                    <!-- Lista de los utensilios que se van añadiendo a la receta -->
                    <ul id="listaIngredientesEnviarReceta">
                        
                    </ul>
                    <!-- ¡¡¡NOTA!!!: El array donde se guardan los id de los ingredientes de la lista está junto al formulario de agregar nuevos ingredientes para poder seleccionarlo de forma más fácil al añadir un nuevo ingrediente -->
    
                </fieldset>

            </div>

            <div id="agregarIngredientesEnviarReceta" class="agregarIngredientesEnviarReceta vertical col-100">
                <div class="selectEnviarReceta col-100 medio vertical top bottom derecha">
                    <label for="selectIngredientesEnviarReceta" class="labelForm">Seleccione ingredientes*</label>
                    <select name="selectIngredientesEnviarReceta" id="selectIngredientesEnviarReceta" class="selectIngredientesEnviarReceta input" size="5">
                        <option value="0" class="optionIngredientesEnviarReceta oculto" disabled>Añadir a la lista</option>
                    </select>
                </div>
                <div class="selectEnviarReceta medio derecha horizontal top col-100">

                    <!-- Botón para agregar un ingrediente a la lista -->
                    <button id="btnSeleccionarIngredientesEnviarReceta" class="btnSeleccionarIngredientesEnviarReceta btn btnListas col-50" onclick="agregarElementoLista(event, 'selectIngredientesEnviarReceta', 'listaIngredientesEnviarReceta', 'arrayIngredientes');">Añadir a lista</button>

                    <!-- Botón para añadir un nuevo ingrediente -->
                    <button id="btnAgregarIngredientesEnviarReceta" class="btnAgregarIngredientesEnviarReceta btn btnListas col-50" type="button" onclick="activarFormulario('subform_modulo_receta', 'formAgregarIngrediente', 'guardar', '');">Añadir Nuevo</button>

                </div>
            </div>
            
        </div>

    </section>

    <!-- Elaboración y emplatado -->
    <section name="elaboracion y emplatado" id="elaboracionEmplatadoEnviarReceta" class="elaboracionEmplatadoEnviarReceta total horizontal top">
        <div class="elaboracionEnviarReceta col-50 medio izquierda vertical">
            <label for="elaboracionEnviarReceta" class="labelForm">Elaboración:*</label>
            <textarea name="elaboracionEnviarReceta" id="elaboracionEnviarReceta" rows="12" class="elaboracionEnviarReceta inputText" pattern="[()a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,:;\n\r\/\-_ ]{3, }" title="Explique la elaboración de la receta. Sólo puede contener letras, números, ., ,, :, ;, -,/,_, espacios y retornos de línea. Mínimo 3 caracteres"></textarea>
        </div>
        <div class="emplatadoEnviarReceta col-50 medio derecha vertical">
            <label for="emplatadoEnviarReceta" class="labelForm">Sugerencias de emplatado:</label>
            <textarea name="emplatadoEnviarReceta" id="emplatadoEnviarReceta" rows="12" class="emplatadoEnviarReceta inputText" pattern="[()a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.;:\/\-_ ]{3, }" title="Describa una o más sugerencias de emplatado. Sólo puede contener letras, números, ., ,, :, ;, -,/,_, espacios y retornos de línea."></textarea>
        </div>
    </section>

    <!-- Enviar receta -->
    <section name='Enviar receta' id="enviarReceta" class="enviarReceta total horizontal">
        <button type="submit" form="formEnviarReceta" value="submit" class="btn col-100">Guardar Receta</button> 
    </section>
</form>