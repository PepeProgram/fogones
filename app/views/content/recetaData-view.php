<header class="tituloPagina">
    <h1>Enviar una nueva receta</h1>
    <?php include "./app/views/inc/btn_back.php"; ?>
</header>

<!-- Cabecera de la receta con la foto -->
<form action="#" id="formEnviarReceta" class="EnviarReceta">
    <section name="resumen" id="cabeceraEnviarReceta" class="cabeceraEnviarReceta col-100 horizontal total">
        <div id="fotoCabeceraEnviarReceta" class="fotoCabeceraEnviarReceta foto col-25 total izquierda">
            <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/tiramisu.jpg' ?>" alt="Receta Sin Foto">
        </div>

        <!-- Ficha corta de la receta -->
        <div id="containerDatosPrincipalesEnviarReceta" class="containerDatosPrincipalesEnviarReceta col-75 total derecha vertical">
            
            <!-- Nombre, nº de personas, dificultad -->
            <div class="nombrePrincipalesInput medio izquierda derecha top horizontal">
                <div class="vertical col-60 medio izquierda top">
                    <label for="nombreReceta" class="labelForm">Nombre del plato:</label>
                    <input type="text" name="nombreReceta" id="nombreReceta" class="input nombreReceta">
                </div>
                <div class="vertical col-20 medio top">
                    <label for="numeroPersonasEnviarReceta" class="labelForm">Nº Personas</label>
                    <input type="number" name="numeroPersonasEnviarReceta" id="numeroPersonasEnviarReceta" class="input numeroPersonasEnviarReceta">
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

                <div class="selectEnviarReceta col-25 medio vertical">
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
                <select name="zonaEnviarReceta" id="zonaEnviarReceta" class="zonaEnviarReceta input">
                    <option value="1" class="selectZonaEnviarReceta">Europa</option>
                    <option value="2" class="selectZonaEnviarReceta">Asia</option>
                    <option value="3" class="selectZonaEnviarReceta">África</option>
                    <option value="4" class="selectZonaEnviarReceta">América</option>
                    <option value="5" class="selectZonaEnviarReceta">Antártida</option>
                    <option value="6" class="selectZonaEnviarReceta">Australia y Oceanía</option>
                </select>
            </div>
            <div class="selectEnviarReceta col-100 medio izquierda vertical top">
                <label for="paisEnviarReceta" class="labelForm">País</label>
                <select name="paisEnviarReceta" id="paisEnviarReceta" class="paisEnviarReceta input">
                    <option value="1" class="selectPaisEnviarReceta">Afganistán</option>
                    <option value="24" class="selectPaisEnviarReceta">Benin</option>
                    <option value="31" class="selectPaisEnviarReceta">Brasil</option>
                    <option value="64" class="selectPaisEnviarReceta">España</option>
                    <option value="98" class="selectPaisEnviarReceta">Isla Bouvet</option>
                </select>
            </div>
            <div class="selectEnviarReceta col-100 medio izquierda vertical top">
                <label for="regionEnviarReceta" class="labelForm">Región</label>
                <select name="regionEnviarReceta" id="regionEnviarReceta" class="regionEnviarReceta input">
                    <option value="1" class="selectRegionEnviarReceta">Andalucía</option>
                    <option value="3" class="selectRegionEnviarReceta">Islas Baleares</option>
                    <option value="5" class="selectRegionEnviarReceta">Cantabria</option>
                    <option value="13" class="selectRegionEnviarReceta">Galicia</option>
                    <option value="15" class="selectRegionEnviarReceta">Principado de Asturias</option>
                    <option value="18" class="selectRegionEnviarReceta">Ceuta</option>
                </select>
            </div>
        </div>

        <!-- Utensilios -->
        <div id="utensiliosEnviarReceta" class="utensiliosEnviarReceta horizontal static col-40 top">
            <div id="agregarUtensiliosEnviarReceta" class="agregarUtensiliosEnviarReceta vertical col-50 static top">
                <div class="selectEnviarReceta col-100 medio vertical top bottom">
                    <label for="selectUtensiliosEnviarReceta" class="labelForm">Utensilios Necesarios</label>
                    <select name="selectUtensiliosEnviarReceta" id="selectUtensiliosEnviarReceta" class="selectUtensiliosEnviarReceta input" size="5">
                        <option value="1" class="optionUtensiliosEnviarReceta">Kitchen Aid</option>
                        <option value="2" class="optionUtensiliosEnviarReceta">Sous Vide</option>
                        <option value="4" class="optionUtensiliosEnviarReceta">Pasapurés</option>
                        <option value="5" class="optionUtensiliosEnviarReceta">Olla Express</option>
                        <option value="6" class="optionUtensiliosEnviarReceta">Thermomix</option>
                        <option value="1" class="optionUtensiliosEnviarReceta">Kitchen Aid</option>
                        <option value="2" class="optionUtensiliosEnviarReceta">Sous Vide</option>
                        <option value="4" class="optionUtensiliosEnviarReceta">Pasapurés</option>
                        <option value="5" class="optionUtensiliosEnviarReceta">Olla Express</option>
                        <option value="6" class="optionUtensiliosEnviarReceta">Thermomix</option>
                    </select>
                </div>
                <div class="selectEnviarReceta col-100 horizontal top">
                    <button id="btnSeleccionarUtensiliosEnviarReceta" class="btnSeleccionarUtensiliosEnviarReceta btn col-66" onclick="agregarElementoLista(event, 'selectUtensiliosEnviarReceta', 'listaUtensiliosEnviarReceta');">Seleccionar</button>
                    <button id="btnAgregarUtensiliosEnviarReceta" class="btnAgregarUtensiliosEnviarReceta btn col-33">Añadir</button>
                </div>
            </div>
            <div id="containerListaUtensiliosEnviarReceta" class="containerListaUtensiliosEnviarReceta vertical col-50 static listasEnviarReceta">
                <ul id="listaUtensiliosEnviarReceta">
                    
                </ul>
            </div>
        </div>

        <!-- Ingredientes -->
         <div id="ingredientesEnviarReceta" class="ingredientesEnviarReceta col-40 derecha vertical top">
            <div class="selectEnviarReceta col-100 medio derecha vertical top">
                <label for="ingredientesEnviarReceta" class="labelForm">Ingredientes</label>
                <select name="ingredientesEnviarReceta" id="ingredientesEnviarReceta" class="ingredientesEnviarReceta input" size="5">
                    <option value="2" class="selectIngredientesEnviarReceta">Harina de trigo</option>
                    <option value="3" class="selectIngredientesEnviarReceta">Vino</option>
                    <option value="4" class="selectIngredientesEnviarReceta">Sardinas</option>
                    <option value="6" class="selectIngredientesEnviarReceta">Mantequilla de cacahuete</option>
                    <option value="7" class="selectIngredientesEnviarReceta">Leche de vaca</option>
                    <option value="8" class="selectIngredientesEnviarReceta">Mantequilla de vaca</option>
                    <option value="8" class="selectIngredientesEnviarReceta">Azúcar blanco refinado</option>
                </select>

            </div>
         </div>

    </section>
    <!-- <section name="utensilios e ingredientes" id="utensiliosIngredientesEnviarReceta" class="utensiliosIngredientesEnviarReceta total horizontal top">
        <div id="ContainerUtensiliosEnviarReceta" class="ContainerUtensiliosEnviarReceta col-50 horizontal">
            <div class="selectEnviarReceta col-50 medio vertical">
                <ul>
                    <li>Utensilio 1</li>
                    <li>Utensilio 2</li>
                    <li>Utensilio 3</li>
                    <li>Utensilio 4</li>
                    <li>Utensilio 5</li>
                    <li>Utensilio 6</li>
                    <li>Utensilio 7</li>
                    <li>Utensilio 8</li>
                </ul>
            </div>
            
        </div>
        <div id="ContainerIngredientesEnviarReceta" class="ContainerIngredientesEnviarReceta col-50 horizontal">
            <div class="selectEnviarReceta col-66 medio vertical">
                <ul>
                    <li>Ingrediente 1</li>
                    <li>Ingrediente 2</li>
                    <li>Ingrediente 3</li>
                    <li>Ingrediente 4</li>
                    <li>Ingrediente 5</li>
                    <li>Ingrediente 6</li>
                    <li>Ingrediente 7</li>
                    <li>Ingrediente 8</li>
                </ul>
            </div>
            
        </div>
    </section> -->
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
</form>
