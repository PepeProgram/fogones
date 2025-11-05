<script type="text/javascript">
    window.addEventListener('load', function(){

        /* Rellena el select de zonas geográficas */
        rellenarSelect('', 'zonaEnviarReceta', 'zonas', '');

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
    <input type="hidden" name="arrayUtensilios" id="arrayUtensilios" class="arrayUtensilios">
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

<!-- Formulario para añadir un ingrediente -->

<div id="formAgregarIngrediente" class="formAgregarIngrediente oculto">

    <!-- Crea el input oculto para ir guardando los id de los ingredientes que hay en la lista de ingredientes -->
    <input type="hidden" name="arrayIngredientes" id="arrayIngredientes" class="arrayIngredientes">
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
                <input type="text" id="nombreIngrediente" class="nombreAutor" name="nombre_ingrediente" maxlength="80" required value="" placeholder="Nombre del Ingrediente" title="Introduzca el nombre del Ingrediente. Sólo puede contener letras, números, .,-,_ y espacios" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}">
            </div>
            <div class="opcionesAutores">
                <button id="guardarCambios" type="submit" class="fa-solid fa-floppy-disk desactivar" title="Guardar Ingrediente"></button>
            </div>
        </div>
    </form>
</div>

<!-- Cabecera de la receta con la foto -->
<form action="#" id="formEnviarReceta" class="EnviarReceta">

    <section name="resumen" id="cabeceraEnviarReceta" class="cabeceraEnviarReceta col-100 horizontal total">
        <div id="fotoCabeceraEnviarReceta" class="fotoCabeceraEnviarReceta foto col-25 total izquierda">
            <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/default.png' ?>" alt="Receta Sin Foto">
        </div>

        <!-- Ficha corta de la receta -->
        <div id="containerDatosPrincipalesEnviarReceta" class="containerDatosPrincipalesEnviarReceta col-75 total derecha vertical">
            
            <!-- Nombre, nº de personas, dificultad -->
            <div class="nombrePrincipalesInput medio izquierda derecha top horizontal">
                <div class="vertical col-40 medio izquierda top">
                    <label for="nombreReceta" class="labelForm">Nombre del plato:</label>
                    <input type="text" name="nombreReceta" id="nombreReceta" class="input nombreReceta">
                </div>
                <div class="vertical col-20 medio top">
                    <label for="numeroPersonasEnviarReceta" class="labelForm">Pax.</label>
                    <input type="number" name="numeroPersonasEnviarReceta" id="numeroPersonasEnviarReceta" class="input numeroPersonasEnviarReceta">
                </div>
                <div class="vertical col-20 medio top">
                    <label for="tiempoElaboracionEnviarReceta" class="labelForm">Tiempo</label>
                    <input type="time" name="tiempoElaboracionEnviarReceta" id="tiempoElaboracionEnviarReceta" class="input tiempoElaboracionEnviarReceta">
                </div>
                <div class="vertical col-20 medio derecha top">
                    <label for="dificultadEnviarReceta" class="labelForm">Dificultad</label>
                    <select name="dificultadEnviarReceta" id="dificultadEnviarReceta" class="input dificultadEnviarReceta">
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

            <!-- Estilo de cocina, Tipo de plato, métodos de cocción, grupo de platos -->
            <div class="datosPrincipalesEnviarReceta col-100 horizontal bottom">
                <div class="selectEnviarReceta col-25 medio izquierda vertical">
                    <label for="estiloCocinaEnviarReceta" class="labelForm">Estilo de Cocina<span class="notas"><br>Ctrl-click para más de uno</span></label>
                    <select name="estiloCocinaEnviarReceta" id="estiloCocinaEnviarReceta" class="input estiloCocinaEnviarReceta" multiple>
                        <option value="8" class="selectEstiloCocinaEnviarReceta">De Autor</option>
                        <option value="3" class="selectEstiloCocinaEnviarReceta">Internacional</option>
                        <option value="1" class="selectEstiloCocinaEnviarReceta">Mediterránea</option>
                        <option value="4" class="selectEstiloCocinaEnviarReceta">Molecular</option>
                        <option value="9" class="selectEstiloCocinaEnviarReceta">Vegana</option>
                    </select>
                </div>
                
                <div class="selectEnviarReceta col-25 medio vertical">
                    <label for="tipoPlatoEnviarReceta" class="labelForm">Tipo de plato<span class="notas"><br>Ctrl-click para más de uno</span></label>
                    <select name="tipoPlatoEnviarReceta" id="tipoPlatoEnviarReceta" class="input tipoPlatoEnviarReceta" multiple>
                        <option value="1" class="selectTipoPlatoEnviarReceta">Aperitivos</option>
                        <option value="9" class="selectTipoPlatoEnviarReceta">Para Picar</option>
                        <option value="4" class="selectTipoPlatoEnviarReceta">Postres</option>
                        <option value="3" class="selectTipoPlatoEnviarReceta">Primeros Platos</option>
                        <option value="7" class="selectTipoPlatoEnviarReceta">Segundos Platos</option>
                    </select>
                </div>
                
                <div class="selectEnviarReceta col-25 medio vertical">
                    <label for="metodoEnviarReceta" class="labelForm">Métodos de Cocción<span class="notas"><br>Ctrl-click para más de uno</span></label>
                    <select name="metodoEnviarReceta" id="metodoEnviarReceta" class="input metodoEnviarReceta" multiple>
                        <option value="12" class="selectMetodoEnviarReceta">Fritos</option>
                        <option value="13" class="selectMetodoEnviarReceta">Hervir</option>
                        <option value="11" class="selectMetodoEnviarReceta">Papillote</option>
                    </select>
                </div>

                <div class="selectEnviarReceta col-25 medio vertical derecha">
                    <label for="grupoPlatosEnviarReceta" class="labelForm">Grupo de Platos<span class="notas"><br>Seleccione uno</span></label>
                    <select name="grupoPlatosEnviarReceta" id="grupoPlatosEnviarReceta" class="input grupoPlatosEnviarReceta">
                        <option value="6" class="selectGrupoPlatosEnviarReceta">Bollería y pastelería</option>
                        <option value="1" class="selectGrupoPlatosEnviarReceta">Carnes</option>
                        <option value="4" class="selectGrupoPlatosEnviarReceta">Dulces</option>
                        <option value="5" class="selectGrupoPlatosEnviarReceta">Frutas</option>
                        <option value="13" class="selectGrupoPlatosEnviarReceta">Masas</option>
                    </select>
                </div>
            </div>

            <!-- Descripción Corta de la receta -->
            <div id="descripcionEnviarReceta" class="descripcionEnviarReceta col-100 vertical">
                <label for="descripcionCorta" class="labelForm">Descripción Corta de la Receta</label>
                <textarea name="descripcionCorta" rows="4" id="descripcionCorta" class="descripcionCorta inputText"></textarea>
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
        <div id="utensiliosEnviarReceta" class="utensiliosEnviarReceta horizontal static col-40 top">
            <div id="agregarUtensiliosEnviarReceta" class="agregarUtensiliosEnviarReceta vertical col-50 static top">
                <div class="selectEnviarReceta col-100 medio vertical top bottom">
                    <label for="selectUtensiliosEnviarReceta" class="labelForm">Utensilios Necesarios</label>
                    <select name="selectUtensiliosEnviarReceta" id="selectUtensiliosEnviarReceta" class="selectUtensiliosEnviarReceta input" size="5">
                        <option value="0" class="optionUtensiliosEnviarReceta oculto" disabled>Añada utensilios a la lista</option>
                    
                    </select>
                </div>
                <div class="selectEnviarReceta col-100 horizontal top">

                    <!-- Botón para agregar un utensilio a la lista -->
                    <button id="btnSeleccionarUtensiliosEnviarReceta" class="btnSeleccionarUtensiliosEnviarReceta btn btnListas col-50" onclick="agregarElementoLista(event, 'selectUtensiliosEnviarReceta', 'listaUtensiliosEnviarReceta', 'arrayUtensilios');">Añadir a lista</button>

                    <!-- Botón para añadir un nuevo utensilio de cocina -->
                    <button id="btnAgregarUtensiliosEnviarReceta" class="btnAgregarUtensiliosEnviarReceta btn btnListas col-50" type="button" onclick="activarFormulario('subform_modulo_receta', 'formAgregarUtensilio', 'guardar', '');">Añadir Nuevo</button>

                </div>
            </div>
            <div id="containerListaUtensiliosEnviarReceta" class="containerListaUtensiliosEnviarReceta vertical col-50 static listasEnviarReceta">
                <p class="tituloListas">Lista de utensilios:</p>
                <!-- Lista de los utensilios que se van añadiendo a la receta -->
                <ul id="listaUtensiliosEnviarReceta">
                    
                </ul>
                <!-- ¡¡¡NOTA!!!: El array donde se guardan los id de los utensilios de la lista está junto al formulario de agregar nuevos utensiliosj para poder seleccionarlo de forma más fácil al añadir un nuevo utensilio -->

            </div>
        </div>

        <!-- Ingredientes -->

        <div id="ingredientesEnviarReceta" class="ingredientesEnviarReceta horizontal static col-40 top">
            <div id="agregarIngredientesEnviarReceta" class="agregarIngredientesEnviarReceta vertical col-50 static top">
                <div class="selectEnviarReceta col-100 medio vertical top bottom">
                    <label for="selectIngredientsEnviarReceta" class="labelForm">Ingredientes</label>
                    <select name="selectIngredientesEnviarReceta" id="selectIngredientesEnviarReceta" class="selectIngredientesEnviarReceta input" size="5">
                        <option value="0" class="optionIngredientesEnviarReceta oculto">Añadir a la lista</option>
                    </select>
                </div>
                <div class="selectEnviarReceta col-100 horizontal top">

                    <!-- Botón para agregar un ingrediente a la lista -->
                    <button id="btnSeleccionarIngredientesEnviarReceta" class="btnSeleccionarIngredientesEnviarReceta btn btnListas col-50" onclick="agregarElementoLista(event, 'selectIngredientesEnviarReceta', 'listaIngredientesEnviarReceta', 'arrayIngredientes');">Añadir a lista</button>

                    <!-- Botón para añadir un nuevo ingrediente -->
                    <button id="btnAgregarIngredientesEnviarReceta" class="btnAgregarIngredientesEnviarReceta btn btnListas col-50" type="button" onclick="activarFormulario('subform_modulo_receta', 'formAgregarIngrediente', 'guardar', '');">Añadir Nuevo</button>

                </div>
            </div>
            <div id="containerListaIngredientesEnviarReceta" class="containerListaIngredientesEnviarReceta vertical col-50 static listasEnviarReceta">
                <p class="tituloListas">Lista de Ingredientes:</p>
                <!-- Lista de los utensilios que se van añadiendo a la receta -->
                <ul id="listaIngredientesEnviarReceta">
                    
                </ul>
                <!-- ¡¡¡NOTA!!!: El array donde se guardan los id de los ingredientes de la lista está junto al formulario de agregar nuevos ingredientes para poder seleccionarlo de forma más fácil al añadir un nuevo ingrediente -->

            </div>
        </div>

    </section>

    <!-- Elaboración y emplatado -->
    <section name="elaboracion y emplatado" id="elaboracionEmplatadoEnviarReceta" class="elaboracionEmplatadoEnviarReceta total horizontal top">
        <div class="elaboracionEnviarReceta col-50 medio izquierda vertical">
            <label for="elaboracionEnviarReceta" class="labelForm">Elaboración:</label>
            <textarea name="elaboracionEnviarReceta" id="elaboracionEnviarReceta" rows="12" class="elaboracionEnviarReceta inputText"></textarea>
        </div>
        <div class="emplatadoEnviarReceta col-50 medio derecha vertical">
            <label for="emplatadoEnviarReceta" class="labelForm">Emplatado Recomendado:</label>
            <textarea name="emplatadoEnviarReceta" id="emplatadoEnviarReceta" rows="12" class="emplatadoEnviarReceta inputText"></textarea>
        </div>
    </section>

    <!-- Enviar receta -->
    <section name='Enviar receta' id="enviarReceta" class="enviarReceta total horizontal">
        <button type="submit" class="btn col-100">Guardar Receta</button>
    </section>
</form>