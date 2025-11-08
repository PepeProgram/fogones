<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Crea la clase hija de la clase principal */
    class recetaController extends mainModel{

        /* GUARDAR RECETA */
        public function guardarRecetaControlador(){

            /* Verifica que el usuario ha iniciado sesión, existe y es redactor */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder enviar una receta",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {

                /* Comprobar que el usuario es quien dice ser */
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder enviar una receta",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    /* Comprobar que el usuario es administrador o redactor */
                    if (!$_SESSION['administrador']) {
                        if (!$_SESSION['redactor']) {
                            $alerta=[
                                "tipo"=>"simple",
                                "titulo"=>"ERROR GRAVE",
                                "texto"=>"No puedes enviar recetas. No eres administrador ni redactor",
                                "icono"=>"error"
                            ];
                        }
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

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

            /* Comprueba si hay ESTILOS DE COCINA seleccionados */
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
                $metodo_receta = [""];

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
                $correcto = true;
                foreach ($cantidad_ingredientes as $ingrediente => $cantidad) {
                    if ($cantidad == "" || $cantidad == null || $cantidad <= 0) {
                        $correcto = false;
                    }
                    $cantidad = $this->limpiarCadena($cantidad);
                }
                if (!$correcto) {
                    $campo = "cantidad en los ingredientes";
                    echo errorGuardar($campo);
                    exit();
                }

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

            /* Verificar que cada una de las variables coincide con los patrones de los datos */

            /* Nombre de la receta */
            if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\/\-_ ]{3,255}", $nombre_receta)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre de la receta sólo puede contener letras, números, .,/,-,_ y espacios. Al menos 3 caracteres y máximo 255",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Número de personas */
            if ($this->verificarDatos("[0-9]+", $numero_personas)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El número de personas debe ser un número entero positivo",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Tiempo de elaboración */
            if ($this->verificarDatos("[01]\d|[02][0-3]:[0-5]\d", $tiempo_elaboracion)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El tiempo de elaboración debe ser de la forma hh:mm",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Dificultad de la receta */
            if ($this->verificarDatos("[1-5]", $dificultad_receta)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre de la receta sólo puede contener letras, números, .,/,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Estilo de cocina */
            foreach ($estilo_cocina as $estilo) {
                if ($this->verificarDatos('[0-9]*', $estilo)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe el apartado estilo de cocina",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* tipo de plato */
            foreach ($tipo_plato as $tipo) {
                if ($this->verificarDatos('[0-9]+', $tipo)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe el apartado tipo de plato",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }
            
            /* Método de cocción */
            foreach ($metodo_receta as $metodo) {
                if ($this->verificarDatos('[0-9]*', $metodo)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe el apartado métodos de cocción",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Grupo de platos */
            if ($this->verificarDatos("[0-9]+", $grupo_plato)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe el apartado grupo de platos",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Descripción corta */
            if ($this->verificarDatos("(?!.*\\\\)[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\/\-_ ]{3,255}", $_POST['descripcionCorta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "La descripción corta la receta sólo puede contener letras, números, .,/,-,_ y espacios. Máximo 255 caracteres",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Zona geográfica */
            if ($this->verificarDatos("[0-9]*", $zona_receta)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe la zona geográfica",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }
            
            /* País */
            if ($this->verificarDatos("[0-9]*", $pais_receta)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe el país",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }
            
            /* Región */
            if ($this->verificarDatos("[0-9]*", $region_receta)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe la región",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }





            /* echo 'Nombre: '.$nombre_receta;
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
            echo 'Emplatado '.$emplatado_receta; */







            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"Nombre: ".$nombre_receta." Pax: ".$numero_personas." Tiempo: ".$tiempo_elaboracion." Dificultad: ".$dificultad_receta." Estilo:  ".json_encode($estilo_cocina)." Tipo Plato: ".json_encode($tipo_plato)." Método: ".json_encode($metodo_receta)." Grupo Plato: ".$grupo_plato." Descripción: ".$descripcion_receta." Zona: ".$zona_receta." País: ".$pais_receta." Región: ".$region_receta." Utensilios: ".json_encode($utensilios_receta)." Ingredientes: ".json_encode($ingredientes_receta)." Cantidades: ".json_encode($cantidad_ingredientes)." Unidades: ".json_encode($unidad_ingredientes)." Elaboración: ".$elaboracion_receta." Emplatado: ".$emplatado_receta,
                "icono"=>"success"
            ];
            return json_encode($alerta);
            exit();


        /* Fin guardarRecetaControlador */
        }
    }
