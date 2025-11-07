<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Crea la clase hija de la clase principal */
    class recetaController extends mainModel{

        /* GUARDAR RECETA */
        public function guardarRecetaControlador(){

            /* Función que devuelve el texto de las alertas modificado en función de quién las envía */
            function errorGuardar($campo){
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado ".$campo,
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Recupera los post aplicándoles la función limpiarCadena para evitar SQL Injection */

            /* Comprueba haya NOMBRE DE LA RECETA */
            if (isset($_POST['nombreReceta']) && $_POST['nombreReceta'] != "") {
                $nombre_receta = $this->limpiarCadena($_POST['nombreReceta']);
            }
            else{
                $campo = "nombre de la receta";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }

            /* Comprueba haya NÚMERO DE PERSONAS */
            if (isset($_POST['numeroPersonasEnviarReceta']) && $_POST['numeroPersonasEnviarReceta'] != "" && $_POST['numeroPersonasEnviarReceta'] > 0) {
                $numero_personas = $this->limpiarCadena($_POST['numeroPersonasEnviarReceta']);
            }
            else{
                $campo = "número de personas (Pax.)";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }

            /* Comprueba haya TIEMPO DE ELABORACIÓN */
            if (isset($_POST['tiempoElaboracionEnviarReceta']) && $_POST['tiempoElaboracionEnviarReceta'] != "") {
                $tiempo_elaboracion = $this->limpiarCadena($_POST['tiempoElaboracionEnviarReceta']);
            }
            else{
                $campo = "tiempo de elaboración";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();

            }

            /* Comprueba haya DIFICULTAD y que sea una de las aceptadas */
            if (isset($_POST['dificultadEnviarReceta']) && $_POST['dificultadEnviarReceta'] != "" && in_array($_POST['dificultadEnviarReceta'], [1, 2, 3, 4, 5])) {
                $dificultad_receta = $this->limpiarCadena($_POST['dificultadEnviarReceta']);
            }
            else{
                $campo = "dificultad";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();

            }

            /* Comprueba haya ESTILO DE COCINA seleccionado */
            if (isset($_POST['estiloCocinaEnviarReceta'])) {

                $estilo_cocina = [];
                foreach ($_POST['estiloCocinaEnviarReceta'] as $estilo) {
                    $estilo = $this->limpiarCadena($estilo);
                    array_push($estilo_cocina, $estilo);
                }
            }
            else{
                $estilo_cocina = [""];
            }

            /* Comprueba si hay array con TIPOS DE PLATO */
            if (isset($_POST['tipoPlatoEnviarReceta'])) {

                $tipo_plato = [];
                foreach ($_POST['tipoPlatoEnviarReceta'] as $tipo) {
                    $tipo = $this->limpiarCadena($tipo);
                    array_push($tipo_plato, $tipo);
                }
            }
            else{
                $campo = "tipo de plato";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }

            /* Comprueba que haya array con MÉTODOS DE COCCIÓN */
            if (isset($_POST['metodoEnviarReceta'])) {

                $metodo_receta = [];
                foreach ($_POST['metodoEnviarReceta'] as $metodo) {
                    $metodo = $this->limpiarCadena($metodo);
                    array_push($metodo_receta, $metodo);
                }
            }
            else{
                $campo = "métodos de cocción";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();

            }
            
            /* Comprueba que haya GRUPOS DE PLATO */
            if (isset($_POST['grupoPlatosEnviarReceta'])) {
                $grupo_plato = $this->limpiarCadena($_POST['grupoPlatosEnviarReceta']);
            }
            else{
                $campo = "grupo de platos";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();

            }

            /* Comprueba que haya descripción corta de la receta */
            if (isset($_POST['descripcionCorta']) && $_POST['descripcionCorta'] != "") {
                $descripcion_receta = $this->limpiarCadena($_POST['descripcionCorta']);
            }
            else{
                $campo = "Descripción corta de la receta";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }

            /* Comprueba el continente */
            if (isset($_POST['zonaEnviarReceta'])) {
                $zona_receta = $this->limpiarCadena($_POST['zonaEnviarReceta']);
            }
            else{
                $campo = "área geográfica";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }
            
            /* Comprueba el país */
            if (isset($_POST['paisEnviarReceta'])) {
                $pais_receta = $this->limpiarCadena($_POST['paisEnviarReceta']);
            }
            else{
                $campo = "país";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }
            
            /* Comprueba la región */
            if (isset($_POST['regionEnviarReceta'])) {
                $region_receta = $this->limpiarCadena($_POST['regionEnviarReceta']);
            }
            else{
                $campo = "región";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }
            
            /* Comprueba el array de los utensilios */
            if (isset($_POST['arrayUtensilios'])) {
                $utensilios_receta = explode(",", $this->limpiarCadena($_POST['arrayUtensilios']));
            }
            else{
                $campo = "utensilios";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }
            
            /* Comprueba el array de los ingredientes */
            if (isset($_POST['arrayIngredientes']) && $_POST['arrayIngredientes'] != "") {
                $ingredientes_receta = explode(",", $this->limpiarCadena($_POST['arrayIngredientes']));
            }
            else{
                $campo = "ingredientes";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }

            
            /* Recupera el array asociativo de cantidades de ingredientes */
            if (isset($_POST['cant'])) {
                $cantidad_ingredientes = $_POST['cant'];
                foreach ($cantidad_ingredientes as $ingrediente => $cantidad) {
                    if ($cantidad == "" || $cantidad == null || $cantidad <= 0) {
                        $campo = "cantidad en los ingredientes";
                        echo errorGuardar($campo);
                        exit();
                    }
                }
                /* RECORDAR HACER OTRO FOREACH PARA LIMPIAR LAS CADENAS DE LAS CANTIDADES */
            } else {
                $campo = "cantidad en los ingredientes";
                echo errorGuardar($campo);
                exit();
            }
            
            /* Recupera el array asociativo de unidades de ingredientes */
            if (isset($_POST['unid'])) {
                $unidad_ingredientes = $_POST['unid'];
                foreach ($unidad_ingredientes as $ingrediente => $unidad) {
                    if ($unidad == "" || $unidad == null || $unidad == 0) {
                        $campo = "unidad de medida en los ingredientes";
                        echo errorGuardar($campo);
                        exit();
                    }
                }
                /* RECORDAR HACER OTRO FOREACH PARA LIMPIAR LAS CADENAS DE LAS UNIDADES */
                echo json_encode($cantidad_ingredientes);
            } else {
                $campo = "unidad de medida en los ingredientes";
                echo errorGuardar($campo);
                exit();
            }
            

            /* Comprueba la elaboración de la receta */
            if (isset($_POST["elaboracionEnviarReceta"]) && $_POST["elaboracionEnviarReceta"] != "") {
                $elaboracion_receta = $this->limpiarCadena($_POST["elaboracionEnviarReceta"]);
            }
            else{
                $campo = "elaboración";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }
            
            /* Comprueba el emplatado de la receta */
            if (isset($_POST["emplatadoEnviarReceta"])) {
                $emplatado_receta = $this->limpiarCadena($_POST["emplatadoEnviarReceta"]);
            }
            else{
                $campo = "emplatado";
                errorGuardar($campo);
                echo errorGuardar($campo);
                exit();
            }

            echo 'Nombre: '.$nombre_receta;
            echo 'Personas: '.$numero_personas;
            echo 'Tiempo '.$tiempo_elaboracion;
            echo 'Dificultad '.$dificultad_receta;
            echo 'Estilo '.json_encode($estilo_cocina);
            echo 'Tipo Plato '.json_encode($tipo_plato);
            echo 'Método '.json_encode($metodo_receta);
            echo 'Grupo Plato '.$grupo_plato;
            echo 'Descripción '.$descripcion_receta;
            echo 'Zona '.$zona_receta;
            echo 'País '.$pais_receta;
            echo 'Region '.$region_receta;
            echo 'Utensilios '.json_encode($utensilios_receta);
            echo 'Ingredientes '.json_encode($ingredientes_receta);
            echo 'Cantidades '.json_encode($cantidad_ingredientes);
            echo 'Unidades '.json_encode($unidad_ingredientes);
            echo 'Elaboración '.$elaboracion_receta;
            echo 'Emplatado '.$emplatado_receta;




        /* Fin guardarRecetaControlador */
        }
    }
