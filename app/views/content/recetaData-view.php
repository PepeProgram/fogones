<header class="tituloPagina">
    <h1>Enviar una nueva receta</h1>
    <?php include "./app/views/inc/btn_back.php"; ?>
</header>

<!-- Cabecera de la receta con la foto -->
<form action="#" id="formEnviarReceta" class="EnviarReceta">
    <section id="cabeceraEnviarReceta" class="cabeceraEnviarReceta col-100 horizontal total">
        <div id="fotoCabeceraEnviarReceta" class="fotoCabeceraEnviarReceta foto col-25 total izquierda">
            <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/tiramisu.jpg' ?>" alt="Receta Sin Foto">
        </div>
        <div id="containerDatosPrincipalesEnviarReceta" class="containerDatosPrincipalesEnviarReceta col-75 total derecha vertical">
            <div class="nombrePrincipalesInput medio izquierda derecha top horizontal">
                <div class="vertical col-75 medio izquierda top">
                    <label for="nombreReceta" class="labelForm">Nombre del plato:</label>
                    <input type="text" name="nombreReceta" id="nombreReceta" class="input nombreReceta">
                </div>
                <div class="vertical col-25 medio derecha top">
                    <label for="numeroPersonasEnviarReceta" class="labelForm">Nº Personas</label>
                    <input type="number" name="numeroPersonasEnviarReceta" id="numeroPersonasEnviarReceta" class="input numeroPersonasEnviarReceta">
                </div>
            </div>
            <div class="datosPrincipalesEnviarReceta col-100 horizontal bottom">
                <div class="selectEnviarReceta col-25 medio izquierda vertical">
                    <label for="estiloCocinaEnviarReceta" class="labelForm">Estilo de Cocina</label>
                    <select name="estiloCocinaEnviarReceta" id="estiloCocinaEnviarReceta" class="input estiloCocinaEnviarReceta" multiple>
                        <option value="8" class="selectEstiloCocinaEnviarReceta">De Autor</option>
                        <option value="3" class="selectEstiloCocinaEnviarReceta">Internacional</option>
                        <option value="1" class="selectEstiloCocinaEnviarReceta">Mediterránea</option>
                        <option value="4" class="selectEstiloCocinaEnviarReceta">Molecular</option>
                        <option value="9" class="selectEstiloCocinaEnviarReceta">Vegana</option>
                    </select>
                </div>
                <div class="selectEnviarReceta col-25 medio vertical">
                    <label for="grupoPlatosEnviarReceta" class="labelForm">Grupo de Platos</label>
                    <select name="grupoPlatosEnviarReceta" id="grupoPlatosEnviarReceta" class="input grupoPlatosEnviarReceta">
                        <option value="6" class="selectGrupoPlatosEnviarReceta">Bollería y pastelería</option>
                        <option value="1" class="selectGrupoPlatosEnviarReceta">Carnes</option>
                        <option value="4" class="selectGrupoPlatosEnviarReceta">Dulces</option>
                        <option value="5" class="selectGrupoPlatosEnviarReceta">Frutas</option>
                        <option value="13" class="selectGrupoPlatosEnviarReceta">Masas</option>
                    </select>
                </div>
                
                <div class="selectEnviarReceta col-25 medio vertical">
                    <label for="tipoPlatoEnviarReceta" class="labelForm">Tipo de plato</label>
                    <select name="tipoPlatoEnviarReceta" id="tipoPlatoEnviarReceta" class="input tipoPlatoEnviarReceta" multiple>
                        <option value="1" class="selectTipoPlatoEnviarReceta">Aperitivos</option>
                        <option value="9" class="selectTipoPlatoEnviarReceta">Para Picar</option>
                        <option value="4" class="selectTipoPlatoEnviarReceta">Postres</option>
                        <option value="3" class="selectTipoPlatoEnviarReceta">Primeros Platos</option>
                        <option value="7" class="selectTipoPlatoEnviarReceta">Segundos Platos</option>
                    </select>
                </div>
                
                <div class="selectEnviarReceta col-25 medio vertical derecha">
                    <label for="metodoEnviarReceta" class="labelForm">Métodos de Cocción</label>
                    <select name="metodoEnviarReceta" id="metodoEnviarReceta" class="input metodoEnviarReceta" multiple>
                        <option value="12" class="selectMetodoEnviarReceta">Fritos</option>
                        <option value="13" class="selectMetodoEnviarReceta">Hervir</option>
                        <option value="11" class="selectMetodoEnviarReceta">Papillote</option>
                    </select>
                </div>
            </div>
            <div id="descripcionEnviarReceta" class="descripcionEnviarReceta col-100 vertical">
                <label for="descripcionCorta" class="labelForm">Descripción Corta de la Receta</label>
                <textarea name="descripcionCorta" rows="4" id="descripcionCorta" class="descripcionCorta inputText"></textarea>
            </div>
        </div>
    </section>
    <section id="recetaCompletaEnviarReceta" class="recetaCompletaEnviarReceta total horizontal top">
        <div class="selectEnviarReceta col-33 medio izquierda vertical top bottom">
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
        <div class="selectEnviarReceta col-33 medio vertical top bottom">
            <label for="paisEnviarReceta" class="labelForm">País</label>
            <select name="paisEnviarReceta" id="paisEnviarReceta" class="paisEnviarReceta input">
                <option value="1" class="selectPaisEnviarReceta">Afganistán</option>
                <option value="24" class="selectPaisEnviarReceta">Benin</option>
                <option value="31" class="selectPaisEnviarReceta">Brasil</option>
                <option value="64" class="selectPaisEnviarReceta">España</option>
                <option value="98" class="selectPaisEnviarReceta">Isla Bouvet</option>
            </select>
        </div>
        <div class="selectEnviarReceta col-33 medio vertical top bottom">
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
    </section>
</form>
