<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Carga el modelo de receta para crear y devolver objetos receta */
    use app\models\recetaModel;

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
                            return json_encode($alerta);
                            exit();
                        }
                    }
                }
                
            }

            /* Recupera los post aplicándoles la función limpiarCadena para evitar SQL Injection */

            /* Comprueba haya NOMBRE DE LA RECETA */
            if (isset($_POST['nombreReceta']) && $_POST['nombreReceta'] != "") {
                
                $nombre_receta = $this->limpiarCadena($_POST['nombreReceta']);

                /* Verifica que el nombre no existe */
                $check_nombre = $this->ejecutarConsulta("SELECT nombre_receta FROM recetas WHERE nombre_receta='$nombre_receta'");

                if ($check_nombre->rowCount()>0) {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"Error en el formulario",
                        "texto"=>"Ya hay una receta con ese nombre.\n Por favor, elija otro.",
                        "icono"=>"error"
                    ];
                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);
                    /* Detiene la ejecución del script */
                    exit();
                }

            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado nombre",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Comprueba haya NÚMERO DE PERSONAS */
            if (isset($_POST['numeroPersonasEnviarReceta']) && $_POST['numeroPersonasEnviarReceta'] != "" && $_POST['numeroPersonasEnviarReceta'] > 0) {
                $numero_personas = $this->limpiarCadena($_POST['numeroPersonasEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado número de personas (pax.)",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Comprueba haya TIEMPO DE ELABORACIÓN */
            if (isset($_POST['tiempoElaboracionEnviarReceta']) && $_POST['tiempoElaboracionEnviarReceta'] != "") {
                $tiempo_elaboracion = $this->limpiarCadena($_POST['tiempoElaboracionEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado tiempo de elaboración",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();

            }

            /* Comprueba haya DIFICULTAD y que sea una de las aceptadas */
            if (isset($_POST['dificultadEnviarReceta']) && $_POST['dificultadEnviarReceta'] != "" && in_array($_POST['dificultadEnviarReceta'], [1, 2, 3, 4, 5])) {
                $dificultad_receta = $this->limpiarCadena($_POST['dificultadEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado dificultad de la receta",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
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
                $estilo_cocina = [];
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
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
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

            /* Comprueba que haya array con MÉTODOS DE COCCIÓN */
            if (isset($_POST['metodoEnviarReceta'])) {

                $metodo_receta = [];
                foreach ($_POST['metodoEnviarReceta'] as $metodo) {
                    $metodo = $this->limpiarCadena($metodo);
                    array_push($metodo_receta, $metodo);
                }
            }
            else{
                $metodo_receta = [];

            }
            
            /* Comprueba que haya GRUPOS DE PLATO */
            if (isset($_POST['grupoPlatosEnviarReceta'])) {
                $grupo_plato = $this->limpiarCadena($_POST['grupoPlatosEnviarReceta']);
            }
            else{
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

            /* Comprueba que haya descripción corta de la receta */
            if (isset($_POST['descripcionCorta']) && $_POST['descripcionCorta'] != "") {
                $descripcion_receta = $this->limpiarCadena($_POST['descripcionCorta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado descripción corta de la receta",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Comprueba el continente */
            if (isset($_POST['zonaEnviarReceta'])) {
                $zona_receta = $this->limpiarCadena($_POST['zonaEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado zona geográfica",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba el país */
            if (isset($_POST['paisEnviarReceta'])) {
                $pais_receta = $this->limpiarCadena($_POST['paisEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado país",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba la región */
            if (isset($_POST['regionEnviarReceta'])) {
                $region_receta = $this->limpiarCadena($_POST['regionEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado región",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba el array de los utensilios */
            if (isset($_POST['arrayUtensilios'])) {
                if ($_POST['arrayUtensilios'] != "") {
                    $utensilios_receta = explode(",", $this->limpiarCadena($_POST['arrayUtensilios']));
                } else {
                    $utensilios_receta = [];
                }
                
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado utensilios",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba el array de los ingredientes */
            if (isset($_POST['arrayIngredientes']) && $_POST['arrayIngredientes'] != "") {
                $ingredientes_receta = explode(",", $this->limpiarCadena($_POST['arrayIngredientes']));
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado ingredientes",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
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
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado cantidad en los ingredientes",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
                }

            } else {
                $campo = "cantidad en los ingredientes";
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
            
            /* Recupera el array asociativo de unidades de ingredientes */
            if (isset($_POST['unid'])) {
                $unidad_ingredientes = $_POST['unid'];
                foreach ($unidad_ingredientes as $ingrediente => $unidad) {
                    if ($unidad == "" || $unidad == null || $unidad == 0) {
                        $campo = "unidad de medida en los ingredientes";
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
                }
            } else {
                $campo = "unidad de medida en los ingredientes";
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
            

            /* Comprueba la elaboración de la receta */
            if (isset($_POST["elaboracionEnviarReceta"]) && $_POST["elaboracionEnviarReceta"] != "") {
                $elaboracion_receta = $this->limpiarCadena($_POST["elaboracionEnviarReceta"]);
            }
            else{
                $campo = "elaboración";
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
            
            /* Comprueba el emplatado de la receta */
            if (isset($_POST["emplatadoEnviarReceta"])) {
                $emplatado_receta = $this->limpiarCadena($_POST["emplatadoEnviarReceta"]);
            }
            else{
                $campo = "emplatado";
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

            /* Verificar que cada una de las variables coincide con los patrones de los datos */

            /* Nombre de la receta */
            if ($this->verificarDatos("[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.:,;\/\-_ ]{3,255}", $nombre_receta)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre de la receta sólo puede contener letras, números, %, (, ), ,, ;, .,/,-,_ y espacios. Al menos 3 caracteres y máximo 255",
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
            if ($this->verificarDatos("(?!.*\\\\)[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.:,;\r\n\/\-_ ]{3,255}", $_POST['descripcionCorta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "La descripción corta la receta sólo puede letras, números, *, :, ,, ;, ., /, (, ), %, -, _, retornos de línea y espacios. Máximo 255 caracteres",
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

            /* Utensilios */
            foreach ($utensilios_receta as $utensilio) {
                if ($this->verificarDatos('[0-9]*', $utensilio)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe la lista de utensilios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Lista de ingredientes */
            foreach ($ingredientes_receta as $ingrediente) {
                if ($this->verificarDatos('[0-9]+', $ingrediente)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe el apartado de ingredientes",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Cantidades de ingredientes */
            foreach ($cantidad_ingredientes as $ingrediente => $cantidad) {
                if ($this->verificarDatos('(\d+(\.\d*)?|\.\d+)', $cantidad)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe las cantidades en la lista de ingredientes",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Unidades en los ingredientes */
            foreach ($unidad_ingredientes as $unidad) {
                if ($this->verificarDatos('[0-9]+', $unidad)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe las unidades en la lista de ingredientes",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Elaboración */
            if ($this->verificarDatos("(?!.*\\\\)[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,;:\(\)\r\n\*\/\-_ ]*", $_POST['emplatadoEnviarReceta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "La elaboración de la receta debe tener al menos 3 caracteres y sólo puede contener letras, números, *, :, ,, ;, ., /, (, ), %, -, _, retornos de línea y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Emplatado */
            if ($this->verificarDatos("(?!.*\\\\)[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,;:\(\)\r\n\*\/\-_ ]*", $_POST['emplatadoEnviarReceta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El emplatado sólo puede contener lletras, números, *, :, ,, ;, ., /, (, ), %, -, _, retornos de línea y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* FOTO DE LA RECETA */

            /* Establece el directorio de las imagenes */
            $img_dir = "../views/photos/recetas_photos/";

            /* Comprueba si hay imágenes en el input */
            if ($_FILES['foto_receta']['tmp_name'] != "" && $_FILES['foto_receta']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_receta']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_receta']['tmp_name']) != "image/png") {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error al guardar la imagen.",
                        "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica el tamño de la imagen */
                if ($_FILES['foto_receta']['size']/1024 > 5120) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error al guardar la imagen.",
                        "texto"=>"El tamaño del archivo debe ser inferior a 5 Mb.",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Establece el nombre de la nueva imagen */
                $foto_receta = iconv('UTF-8', 'ASCII//IGNORE', strtok($nombre_receta, " "));
                $foto_receta .= "_".date('Ymdhis').rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_receta']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_receta .= '.jpg';
                        break;
                    
                    case 'image/png':
                        $foto_receta .= '.png';
                        break;
                    
                }

                /* Crea el directorio si no está creado */
                if (!file_exists($img_dir)) {
                    if (!mkdir($img_dir, 0777)) {
                        $alerta = [
                            "tipo" => "simple",
                            "titulo" => "Error inesperado.",
                            "texto" => "No se ha podido crear la carpeta de imágenes",
                            "icono" => "error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }

                /* Permisos en el directorio de imágenes por si acaso */
                chmod($img_dir, 0777);

                /* Sube la imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_receta']['tmp_name'], $img_dir.$foto_receta)) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al actualizar la foto",
                        "texto"=>"No se ha podido guardar la imagen. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

            } else {
                $foto_receta = null;
            }

            /* GUARDAR LA RECETA EN LA BASE DE DATOS */

            /* Establece los campos para guardar la receta */
            $receta_datos_reg = [
                /* Id usuario */
                [
                    "campo_nombre"=>"id_usuario",
                    "campo_marcador"=>":Usuario",
                    "campo_valor"=>$_SESSION['id']
                ],
                /* Nombre de la receta */
                [
                    "campo_nombre"=>"nombre_receta",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_receta
                ],
                /* Número de personas */
                [
                    "campo_nombre"=>"n_personas",
                    "campo_marcador"=>":Personas",
                    "campo_valor"=>$numero_personas
                ],
                /* Tiempo de elaboración */
                [
                    "campo_nombre"=>"tiempo_receta",
                    "campo_marcador"=>":Tiempo",
                    "campo_valor"=>$tiempo_elaboracion
                ],
                /* Dificultad */
                [
                    "campo_nombre"=>"dificultad",
                    "campo_marcador"=>":Dificultad",
                    "campo_valor"=>$dificultad_receta
                ],
                /* Grupo de platos */
                [
                    "campo_nombre"=>"id_grupo",
                    "campo_marcador"=>":Grupo",
                    "campo_valor"=>$grupo_plato
                ],
                /* Descripción corta */
                [
                    "campo_nombre"=>"descripcion_receta",
                    "campo_marcador"=>":Descripcion",
                    "campo_valor"=>$descripcion_receta
                ],
                /* Zona geográfica */
                [
                    "campo_nombre"=>"id_zona",
                    "campo_marcador"=>":Zona",
                    "campo_valor"=>$zona_receta
                ],
                /* País */
                [
                    "campo_nombre"=>"id_pais",
                    "campo_marcador"=>":Pais",
                    "campo_valor"=>$pais_receta
                ],
                /* Región */
                [
                    "campo_nombre"=>"id_region",
                    "campo_marcador"=>":Region",
                    "campo_valor"=>$region_receta
                ],
                /* Elaboracion */
                [
                    "campo_nombre"=>"elaboracion",
                    "campo_marcador"=>":Elaboracion",
                    "campo_valor"=>$elaboracion_receta
                ],
                /* Emplatado */
                [
                    "campo_nombre"=>"emplatado",
                    "campo_marcador"=>":Emplatado",
                    "campo_valor"=>$emplatado_receta
                ],
                /* Fecha de creación */
                [
                    "campo_nombre"=>"creado_receta",
                    "campo_marcador"=>":Creado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ],
                /* Fecha de actualización */
                [
                    "campo_nombre"=>"actualizado_receta",
                    "campo_marcador"=>":Actualizado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ],
                /* Foto de la receta */
                [
                    "campo_nombre"=>"foto_receta",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_receta
                ]
            ];

            /* Guarda la receta llamando al método del mainModel */
            $registrar_receta = $this->guardarDatos("recetas", $receta_datos_reg);

            /* Comprueba si se han insertado los datos */
            if ($registrar_receta->rowCount() == 1) {

                /* Recupera el id de la receta guardada */
                $ultimaGuardada = $this->ejecutarConsulta("SELECT * FROM recetas ORDER BY id_receta DESC LIMIT 1");
                $ultimaGuardada = $ultimaGuardada->fetch();
                $id_receta = $ultimaGuardada['id_receta'];

                /* Recorre el array de los estilos de cocina */
                foreach ($estilo_cocina as $estilo) {
                    /* Establece la variable para guardar cada estilo en la tabla recetas_estilos */
                    $guardar_estilo = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id_receta
                        ],
                        /* Id estilo */
                        [
                            "campo_nombre"=>"id_estilo",
                            "campo_marcador"=>":Estilo",
                            "campo_valor"=>$estilo
                        ]
                    ];

                    /* Guarda los estilos llamando al método del mainModel */
                    $registrar_estilo = $this->guardarDatos("recetas_estilos", $guardar_estilo);
                    if (!$registrar_estilo->rowCount() == 1 ) {

                        /* Borra lo que haya grabado hasta ahora (al estar el delete establecido en cascada, ya borra también los datos de las tablas intermedias) */
                        $this->eliminarRegistro('recetas', 'id_receta', $id_receta);

                        /* Borra la foto si se ha subido */
                        if (is_file($img_dir.$foto_receta)) {
                            chmod($img_dir.$foto_receta, 777);
                            unlink($img_dir.$foto_receta);
                        }

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                    }

                }

                /* Recorre el array de los tipos de plato */
                foreach ($tipo_plato as $tipo) {
                    /* Establece la variable para guardar cada estilo en la tabla recetas_tiposplato */
                    $guardar_tipo = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id_receta
                        ],
                        /* Id tipo */
                        [
                            "campo_nombre"=>"id_tipo",
                            "campo_marcador"=>":Tipo",
                            "campo_valor"=>$tipo
                        ]
                    ];

                    /* Guarda los tipos de plato llamando al método del mainModel */
                    $registrar_tipo = $this->guardarDatos("recetas_tiposplato", $guardar_tipo);
                    if (!$registrar_tipo->rowCount() == 1 ) {

                        /* Borra lo que haya grabado hasta ahora (al estar el delete establecido en cascada, ya borra también los datos de las tablas intermedias) */
                        $this->eliminarRegistro('recetas', 'id_receta', $id_receta);

                        /* Borra la foto si se ha subido */
                        if (is_file($img_dir.$foto_receta)) {
                            chmod($img_dir.$foto_receta, 777);
                            unlink($img_dir.$foto_receta);
                        }

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                    }

                }

                /* Recorre el array de los métodos */
                foreach ($metodo_receta as $metodo) {
                    /* Establece la variable para guardar cada estilo en la tabla recetas_metodos */
                    $guardar_metodo = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id_receta
                        ],
                        /* Id tipo */
                        [
                            "campo_nombre"=>"id_tecnica",
                            "campo_marcador"=>":Tecnica",
                            "campo_valor"=>$metodo
                        ]
                    ];

                    /* Guarda los métodos llamando al método del mainModel */
                    $registrar_metodo = $this->guardarDatos("recetas_tecnicas", $guardar_metodo);
                    if (!$registrar_metodo->rowCount() == 1 ) {

                        /* Borra lo que haya grabado hasta ahora (al estar el delete establecido en cascada, ya borra también los datos de las tablas intermedias) */
                        $this->eliminarRegistro('recetas', 'id_receta', $id_receta);

                        /* Borra la foto si se ha subido */
                        if (is_file($img_dir.$foto_receta)) {
                            chmod($img_dir.$foto_receta, 777);
                            unlink($img_dir.$foto_receta);
                        }

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                    }

                }

                /* Recorre el array de utensilios */
                foreach ($utensilios_receta as $utensilio) {
                    /* Establece la variable para guardar cada utensilio en la tabla recetas_utensilios */
                    $guardar_utensilio = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id_receta
                        ],
                        /* Id utensilio */
                        [
                            "campo_nombre"=>"id_utensilio",
                            "campo_marcador"=>":Utensilio",
                            "campo_valor"=>$utensilio
                        ]
                    ];

                    /* Guarda los utensilios llamando al método del mainModel */
                    $registrar_utensilio = $this->guardarDatos("recetas_utensilios", $guardar_utensilio);
                    if (!$registrar_utensilio->rowCount() == 1 ) {

                        /* Borra lo que haya grabado hasta ahora (al estar el delete establecido en cascada, ya borra también los datos de las tablas intermedias) */
                        $this->eliminarRegistro('recetas', 'id_receta', $id_receta);

                        /* Borra la foto si se ha subido */
                        if (is_file($img_dir.$foto_receta)) {
                            chmod($img_dir.$foto_receta, 777);
                            unlink($img_dir.$foto_receta);
                        }

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                    }

                }

                /* Recorre el array de ingredientes */
                foreach ($ingredientes_receta as $ingrediente) {
                    /* Busca la cantidad en el array de cantidades */
                    if (array_key_exists($ingrediente, $cantidad_ingredientes)) {
                        $cant = $cantidad_ingredientes[$ingrediente];
                    }

                    /* Busca la unidad de medida en el array de unidades */
                    if (array_key_exists($ingrediente, $unidad_ingredientes)) {
                        $unid = $unidad_ingredientes[$ingrediente];
                    }


                    /* Establece la variable para guardar cada utensilio en la tabla recetas_ingredientes */
                    $guardar_ingrediente = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id_receta
                        ],

                        /* Id ingrediente */
                        [
                            "campo_nombre"=>"id_ingrediente",
                            "campo_marcador"=>":Ingrediente",
                            "campo_valor"=>$ingrediente
                        ],

                        /* Cantidad */
                        [
                            "campo_nombre"=>"cantidad",
                            "campo_marcador"=>":Cantidad",
                            "campo_valor"=>$cant
                        ],

                        /* Unidad de medida */
                        [
                            "campo_nombre"=>"id_unidad",
                            "campo_marcador"=>":Unidad",
                            "campo_valor"=>$unid
                        ]
                    ];
                    
                    /* Guarda los ingredientes llamando al método del mainModel */
                    $registrar_ingrediente = $this->guardarDatos("recetas_ingredientes", $guardar_ingrediente);
                    if (!$registrar_ingrediente->rowCount() == 1 ) {

                        /* Borra lo que haya grabado hasta ahora (al estar el delete establecido en cascada, ya borra también los datos de las tablas intermedias) */
                        $this->eliminarRegistro('recetas', 'id_receta', $id_receta);

                        /* Borra la foto si se ha subido */
                        if (is_file($img_dir.$foto_receta)) {
                            chmod($img_dir.$foto_receta, 777);
                            unlink($img_dir.$foto_receta);
                        }

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                    }

                }

                

                /* Ventana de Éxito y limpia el formulario */
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "La receta ".$nombre_receta." ha sido guardada correctamente",
                    "icono" => "success"
                ];

            } else {

                /* Borra la foto si se ha subido */
                if (is_file($img_dir.$foto_receta)) {
                    chmod($img_dir.$foto_receta, 777);
                    unlink($img_dir.$foto_receta);
                }

                /* Muestra la ventana de error */
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error inesperado",
                    "texto"=>"No hemos podido guardar la receta. Por favor, inténtelo de nuevo más tarde.",
                    "icono"=>"error"
                ];
            }
            
            /* Devuelve la ventana de información */
            return json_encode($alerta);




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

        /* Fin guardarRecetaControlador */
        }

        /* CHEQUEAR SI HAY RECETAS PENDIENTES DE REVISIÓN */
        public function revisarRecetasControlador(){
            /* Ejecuta la búsqueda para comprobar si hay pendientes de revisión */
            $recetasRevisar = $this->ejecutarConsulta("SELECT * FROM recetas WHERE activo = 0 ORDER BY nombre_receta");

            /* Devuelve true o false */
            if ($recetasRevisar->rowCount()>0) {
                return true;
            }
            else{
                return false;
            }
        }

        /* LISTAR TODAS LAS RECETAS */
        public function listarRecetasControlador($modoBusqueda = false){

            /* Obtiene la vista actual */
            $vista_actual = explode("/", $_SERVER['REQUEST_URI']);

            /* Comprueba si viene en modo normal o búsqueda */
            if ($modoBusqueda) {
                
                $texto = $this->limpiarCadena($_POST['busquedaRecetas']);
                $idTipo = $this->limpiarCadena($_POST['id_tipo']) ?? null;

                if ($idTipo === "" || $idTipo === "null") {
                    $idTipo = null;
                }

                $idsRecetas = $this->buscarRecetasGlobal($texto, $idTipo);

                if (!empty($idsRecetas)) {
                    $idsString = implode(',', $idsRecetas);
                    $consulta = "SELECT * FROM recetas WHERE id_receta IN ($idsString)";
                    $todasLasRecetas = $this->ejecutarConsulta($consulta)->fetchAll();
                } else {
                    $todasLasRecetas = []; // Si no hay resultados
                }

            } else {
                
                /* Comprueba cuál es la vista actual para construir la búsqueda de recetas */
                if (isset($vista_actual[2]) && $vista_actual[2] != "") {

                    $pagina_actual = $this->limpiarCadena($vista_actual[2]);
                    switch ($pagina_actual) {
                        case 'principal':
                            $consulta = "SELECT * FROM recetas WHERE activo=1 ORDER BY id_receta DESC";
                            break;
                        case 'aperitivos':
                            $consulta = "SELECT * FROM recetas_tiposplato INNER JOIN recetas ON recetas_tiposplato.id_receta = recetas.id_receta WHERE id_tipo=1 AND activo = 1";
                            break;
                        case 'primerosPlatos':
                            $consulta = "SELECT * FROM recetas_tiposplato INNER JOIN recetas ON recetas_tiposplato.id_receta = recetas.id_receta WHERE id_tipo=3 AND activo = 1";
                            break;
                        case 'segundosPlatos':
                            $consulta = "SELECT * FROM recetas_tiposplato INNER JOIN recetas ON recetas_tiposplato.id_receta = recetas.id_receta WHERE id_tipo=7 AND activo = 1";
                            break;
                        case 'postres':
                            $consulta = "SELECT * FROM recetas_tiposplato INNER JOIN recetas ON recetas_tiposplato.id_receta = recetas.id_receta WHERE id_tipo=4 AND activo = 1";
                            break;
                        case 'guarniciones':
                            $consulta = "SELECT * FROM recetas_tiposplato INNER JOIN recetas ON recetas_tiposplato.id_receta = recetas.id_receta WHERE id_tipo=11 AND activo = 1";
                            break;
                        case 'desayunos':
                            $consulta = "SELECT * FROM recetas_tiposplato INNER JOIN recetas ON recetas_tiposplato.id_receta = recetas.id_receta WHERE id_tipo=10 AND activo = 1";
                            break;
                        case 'complementos':
                            $consulta = "SELECT * FROM recetas_tiposplato INNER JOIN recetas ON recetas_tiposplato.id_receta = recetas.id_receta WHERE id_tipo=12 AND activo = 1";
                            break;
                        case 'misRecetas':
                            $id = $_SESSION['id'];
                            $consulta = "SELECT * FROM recetas WHERE id_usuario=$id";
                            break;
                        case 'paraRevisar':
                            /* consulta las recetas sin activar */
                            $consulta = "SELECT * FROM recetas WHERE activo = 0 ORDER BY nombre_receta";
                            break;
                        case 'recetasDe':
                            /* Comprueba si hay algún id de usuario */
                            if (isset($vista_actual[3]) && $vista_actual[3] != "") {
                                $consulta = "SELECT * FROM recetas WHERE activo = 1 AND id_usuario = $vista_actual[3]";
                            } else {
                                $consulta = "SELECT * FROM recetas WHERE activo = 33";
                            }
                            break;# code...
                        
                        default:
                            $consulta = "SELECT * FROM recetas ORDER BY nombre_receta";
                            break;
                    }
                    
                }
                else {
                    $consulta = "SELECT * FROM recetas WHERE activo = 1 ORDER BY id_receta DESC";
                }
    
                /* Ejecuta la consulta */
                $todasLasRecetas = $this->ejecutarConsulta($consulta);
                $todasLasRecetas = $todasLasRecetas->fetchAll();
            }
            


            /* Crea un array para ir guardando los objetos receta */
            $recetas = array();

            /* Recorre el resultado de la consulta para ir añadiendo objetos receta al array */
            foreach ($todasLasRecetas as $receta) {
                $nuevaReceta = new recetaModel($receta['id_receta'], $receta['nombre_receta'], $receta['descripcion_receta'], $receta['id_usuario'], $receta['id_grupo'], $receta['n_personas'], $receta['tiempo_receta'], $receta['id_autor'], $receta['id_region'], $receta['id_pais'], $receta['id_zona'], $receta['dificultad'], $receta['elaboracion'], $receta['emplatado'], $receta['foto_receta'], $receta['visualizaciones'], $receta['creado_receta'], $receta['actualizado_receta'], $receta['activo']);

                /* Añade la receta al array */
                array_push($recetas, $nuevaReceta);
            }

            /* Devuelve el array de recetas */
            return $recetas;
        /* Fin listarRecetasControlador */
        }

        /* ACTUALIZAR RECETA */
        public function actualizarRecetaControlador(){


            /* Recupera el id de la receta */
            $id = $this->limpiarCadena($_POST['id_receta']);

            /* Verifica que la receta existe y recupera lo que hay guardado */
            $receta_old = $this->ejecutarConsulta("SELECT * FROM recetas WHERE id_receta = '$id'");
            if ($receta_old->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El utensilio de cocina no existe",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $receta_old = $receta_old->fetch();
            }
            
            /* Verifica que el usuario ha iniciado sesión, existe y es administrador, revisor, o es el propietario de la receta */
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
                    /* Comprobar que el usuario es administrador o revisor, o es el propietario de la receta */
                    if (!$_SESSION['administrador']) {
                        if (!$_SESSION['revisor']) {
                            if ($_SESSION['id'] != $receta_old['id_usuario']) {
                                $alerta=[
                                    "tipo"=>"simple",
                                    "titulo"=>"ERROR GRAVE",
                                    "texto"=>"No puedes enviar recetas. No eres administrador ni revisor, ni la receta es tuya",
                                    "icono"=>"error"
                                ];
                                return json_encode($alerta);
                                exit();
                            }
                        }
                    }
                }
            }

            /* Comprueba haya NOMBRE DE LA RECETA */
            if (isset($_POST['nombreReceta']) && $_POST['nombreReceta'] != "") {
                
                $nombre_receta = $this->limpiarCadena($_POST['nombreReceta']);

                /* Verifica que el nombre no existe */
                $check_nombre = $this->ejecutarConsulta("SELECT nombre_receta FROM recetas WHERE nombre_receta='$nombre_receta' AND id_receta != '$id'");

                if ($check_nombre->rowCount()>0) {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"Error en el formulario",
                        "texto"=>"Ya hay una receta con ese nombre.\n Por favor, elija otro.",
                        "icono"=>"error"
                    ];
                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);
                    /* Detiene la ejecución del script */
                    exit();
                }

            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado nombre",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba haya NÚMERO DE PERSONAS */
            if (isset($_POST['numeroPersonasEnviarReceta']) && $_POST['numeroPersonasEnviarReceta'] != "" && $_POST['numeroPersonasEnviarReceta'] > 0) {
                $numero_personas = $this->limpiarCadena($_POST['numeroPersonasEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado número de personas (pax.)",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Comprueba haya TIEMPO DE ELABORACIÓN */
            if (isset($_POST['tiempoElaboracionEnviarReceta']) && $_POST['tiempoElaboracionEnviarReceta'] != "") {
                $tiempo_elaboracion = $this->limpiarCadena($_POST['tiempoElaboracionEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado tiempo de elaboración",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();

            }

            /* Comprueba haya DIFICULTAD y que sea una de las aceptadas */
            if (isset($_POST['dificultadEnviarReceta']) && $_POST['dificultadEnviarReceta'] != "" && in_array($_POST['dificultadEnviarReceta'], [1, 2, 3, 4, 5])) {
                $dificultad_receta = $this->limpiarCadena($_POST['dificultadEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado dificultad de la receta",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
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
                $estilo_cocina = [];
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
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
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

            /* Comprueba que haya array con MÉTODOS DE COCCIÓN */
            if (isset($_POST['metodoEnviarReceta'])) {

                $metodo_receta = [];
                foreach ($_POST['metodoEnviarReceta'] as $metodo) {
                    $metodo = $this->limpiarCadena($metodo);
                    array_push($metodo_receta, $metodo);
                }
            }
            else{
                $metodo_receta = [];

            }
            
            /* Comprueba que haya GRUPOS DE PLATO */
            if (isset($_POST['grupoPlatosEnviarReceta'])) {
                $grupo_plato = $this->limpiarCadena($_POST['grupoPlatosEnviarReceta']);
            }
            else{
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

            /* Comprueba que haya descripción corta de la receta */
            if (isset($_POST['descripcionCorta']) && $_POST['descripcionCorta'] != "") {
                $descripcion_receta = $this->limpiarCadena($_POST['descripcionCorta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado descripción corta de la receta",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }

            /* Comprueba el continente */
            if (isset($_POST['zonaEnviarReceta'])) {
                $zona_receta = $this->limpiarCadena($_POST['zonaEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado zona geográfica",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba el país */
            if (isset($_POST['paisEnviarReceta'])) {
                $pais_receta = $this->limpiarCadena($_POST['paisEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado país",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba la región */
            if (isset($_POST['regionEnviarReceta'])) {
                $region_receta = $this->limpiarCadena($_POST['regionEnviarReceta']);
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado región",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba el array de los utensilios */
            if (isset($_POST['arrayUtensilios'])) {
                if ($_POST['arrayUtensilios'] != "") {
                    $utensilios_receta = explode(",", $this->limpiarCadena($_POST['arrayUtensilios']));
                } else {
                    $utensilios_receta = [];
                }
                
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado utensilios",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
            }
            
            /* Comprueba el array de los ingredientes */
            if (isset($_POST['arrayIngredientes']) && $_POST['arrayIngredientes'] != "") {
                $ingredientes_receta = explode(",", $this->limpiarCadena($_POST['arrayIngredientes']));
            }
            else{
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado ingredientes",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
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
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error en el formulario",
                    "texto" => "Compruebe el apartado cantidad en los ingredientes",
                    "icono" => "error"
                ];

                /* Codifica la variable como datos JSON */
                return json_encode($alerta);

                /* Detiene la ejecución del script */
                exit();
                }

            } else {
                $campo = "cantidad en los ingredientes";
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
            
            /* Recupera el array asociativo de unidades de ingredientes */
            if (isset($_POST['unid'])) {
                $unidad_ingredientes = $_POST['unid'];
                foreach ($unidad_ingredientes as $ingrediente => $unidad) {
                    if ($unidad == "" || $unidad == null || $unidad == 0) {
                        $campo = "unidad de medida en los ingredientes";
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
                }
            } else {
                $campo = "unidad de medida en los ingredientes";
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
            

            /* Comprueba la elaboración de la receta */
            if (isset($_POST["elaboracionEnviarReceta"]) && $_POST["elaboracionEnviarReceta"] != "") {
                $elaboracion_receta = $this->limpiarCadena($_POST["elaboracionEnviarReceta"]);
            }
            else{
                $campo = "elaboración";
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
            
            /* Comprueba el emplatado de la receta */
            if (isset($_POST["emplatadoEnviarReceta"])) {
                $emplatado_receta = $this->limpiarCadena($_POST["emplatadoEnviarReceta"]);
            }
            else{
                $campo = "emplatado";
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

            /* Verificar que cada una de las variables coincide con los patrones de los datos */

            /* Nombre de la receta */
            if ($this->verificarDatos("[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.:,;\/\-_ ]{3,255}", $nombre_receta)) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre de la receta sólo puede contener letras, números, %, (, ), ,, ;, .,/,-,_ y espacios. Al menos 3 caracteres y máximo 255",
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
            if ($this->verificarDatos("(?!.*\\\\)[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.:,;\r\n\/\-_ ]{3,255}", $_POST['descripcionCorta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "La descripción corta la receta sólo puede letras, números, *, :, ,, ;, ., /, (, ), %, -, _, retornos de línea y espacios. Máximo 255 caracteres",
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

            /* Utensilios */
            foreach ($utensilios_receta as $utensilio) {
                if ($this->verificarDatos('[0-9]*', $utensilio)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe la lista de utensilios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Lista de ingredientes */
            foreach ($ingredientes_receta as $ingrediente) {
                if ($this->verificarDatos('[0-9]+', $ingrediente)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe el apartado de ingredientes",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Cantidades de ingredientes */
            foreach ($cantidad_ingredientes as $ingrediente => $cantidad) {
                if ($this->verificarDatos('(\d+(\.\d*)?|\.\d+)', $cantidad)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe las cantidades en la lista de ingredientes",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Unidades en los ingredientes */
            foreach ($unidad_ingredientes as $unidad) {
                if ($this->verificarDatos('[0-9]+', $unidad)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "Compruebe las unidades en la lista de ingredientes",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }
            }

            /* Elaboración */
            if ($this->verificarDatos("(?!.*\\\\)[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,;:\(\)\r\n\*\/\-_ ]*", $_POST['emplatadoEnviarReceta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "La elaboración de la receta debe tener al menos 3 caracteres y sólo puede contener letras, números, *, :, ,, ;, ., /, (, ), %, -, _, retornos de línea y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Emplatado */
            if ($this->verificarDatos("(?!.*\\\\)[()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,;:\(\)\r\n\*\/\-_ ]*", $_POST['emplatadoEnviarReceta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El emplatado sólo puede contener lletras, números, *, :, ,, ;, ., /, (, ), %, -, _, retornos de línea y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* FOTO DE LA RECETA */

            /* Establece el directorio de las imagenes */
            $img_dir = "../views/photos/recetas_photos/";

            /* Comprueba si hay imágenes en el input */
            if ($_FILES['foto_receta']['tmp_name'] != "" && $_FILES['foto_receta']['size']>0) {
                
                /* Verifica el formato de imagen */
                if (mime_content_type($_FILES['foto_receta']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_receta']['tmp_name']) != "image/png") {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error al guardar la imagen.",
                        "texto"=>"El formato de archivo no está permitido. Debe seleccionar una imagen en formato jpg o png",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Verifica el tamño de la imagen */
                if ($_FILES['foto_receta']['size']/1024 > 5120) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error al guardar la imagen.",
                        "texto"=>"El tamaño del archivo debe ser inferior a 5 Mb.",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Establece el nombre de la nueva imagen */
                $foto_receta = iconv('UTF-8', 'ASCII//IGNORE', strtok($nombre_receta, " "));
                $foto_receta .= "_".date('Ymdhis').rand(0, 10000);

                /* Establece la extensión de la nueva imagen */
                switch (mime_content_type($_FILES['foto_receta']['tmp_name'])) {
                    case 'image/jpeg':
                        $foto_receta .= '.jpg';
                        break;
                    
                    case 'image/png':
                        $foto_receta .= '.png';
                        break;
                    
                }

                /* Crea el directorio si no está creado */
                if (!file_exists($img_dir)) {
                    if (!mkdir($img_dir, 0777)) {
                        $alerta = [
                            "tipo" => "simple",
                            "titulo" => "Error inesperado.",
                            "texto" => "No se ha podido crear la carpeta de imágenes",
                            "icono" => "error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }

                /* Permisos en el directorio de imágenes por si acaso */
                chmod($img_dir, 0777);

                /* Borra la foto anterior si existe */
                if (is_file($img_dir.$receta_old['foto_receta'])) {
                    chmod($img_dir.$receta_old['foto_receta'], 0777);
                    unlink($img_dir.$receta_old['foto_receta']);
                }

                /* Sube la imagen al directorio de imágenes */
                if (!move_uploaded_file($_FILES['foto_receta']['tmp_name'], $img_dir.$foto_receta)) {
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Error al actualizar la foto",
                        "texto"=>"No se ha podido guardar la imagen. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

            } else {
                $foto_receta = $receta_old['foto_receta'];
            }

            /* GUARDAR LA RECETA EN LA BASE DE DATOS */

            /* Establece los campos para guardar la receta */
            $receta_datos_up = [
                /* Nombre de la receta */
                [
                    "campo_nombre"=>"nombre_receta",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_receta
                ],
                /* Número de personas */
                [
                    "campo_nombre"=>"n_personas",
                    "campo_marcador"=>":Personas",
                    "campo_valor"=>$numero_personas
                ],
                /* Tiempo de elaboración */
                [
                    "campo_nombre"=>"tiempo_receta",
                    "campo_marcador"=>":Tiempo",
                    "campo_valor"=>$tiempo_elaboracion
                ],
                /* Dificultad */
                [
                    "campo_nombre"=>"dificultad",
                    "campo_marcador"=>":Dificultad",
                    "campo_valor"=>$dificultad_receta
                ],
                /* Grupo de platos */
                [
                    "campo_nombre"=>"id_grupo",
                    "campo_marcador"=>":Grupo",
                    "campo_valor"=>$grupo_plato
                ],
                /* Descripción corta */
                [
                    "campo_nombre"=>"descripcion_receta",
                    "campo_marcador"=>":Descripcion",
                    "campo_valor"=>$descripcion_receta
                ],
                /* Zona geográfica */
                [
                    "campo_nombre"=>"id_zona",
                    "campo_marcador"=>":Zona",
                    "campo_valor"=>$zona_receta
                ],
                /* País */
                [
                    "campo_nombre"=>"id_pais",
                    "campo_marcador"=>":Pais",
                    "campo_valor"=>$pais_receta
                ],
                /* Región */
                [
                    "campo_nombre"=>"id_region",
                    "campo_marcador"=>":Region",
                    "campo_valor"=>$region_receta
                ],
                /* Elaboracion */
                [
                    "campo_nombre"=>"elaboracion",
                    "campo_marcador"=>":Elaboracion",
                    "campo_valor"=>$elaboracion_receta
                ],
                /* Emplatado */
                [
                    "campo_nombre"=>"emplatado",
                    "campo_marcador"=>":Emplatado",
                    "campo_valor"=>$emplatado_receta
                ],
                /* Fecha de actualización */
                [
                    "campo_nombre"=>"actualizado_receta",
                    "campo_marcador"=>":Actualizado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ],
                /* Foto de la receta */
                [
                    "campo_nombre"=>"foto_receta",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto_receta
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_receta",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];


            /* Guarda la receta llamando al método del mainModel */
            $registrar_receta = $this->actualizarDatos("recetas", $receta_datos_up, $condicion);

            /* Comprueba si se han insertado los datos */
            if ($registrar_receta->rowCount() == 1) {

                /* Comprueba si hay estilos de cocina guardados */
                if ($this->seleccionarDatos('Unico', 'recetas_estilos', 'id_receta', $id)->rowCount() > 0) {
                    
                    /* Borra los estilos de cocina que hay guardados */
                    $borrar_estilos = $this->eliminarRegistro('recetas_estilos', 'id_receta', $id);
    
                    /* Comprueba que se hayan borrado los estilos */
                    if (!$borrar_estilos->rowCount() == 1) {
                        /* Muestra la ventana de error */
                            $alerta = [
                                "tipo"=>"simple",
                                "titulo"=>"Error inesperado",
                                "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                                "icono"=>"error"
                            ];
                            return json_encode($alerta);
                            exit();
                    }
                }


                /* Recorre el array de los estilos de cocina */
                foreach ($estilo_cocina as $estilo) {
                    /* Establece la variable para guardar cada estilo en la tabla recetas_estilos */
                    $guardar_estilo = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id
                        ],
                        /* Id estilo */
                        [
                            "campo_nombre"=>"id_estilo",
                            "campo_marcador"=>":Estilo",
                            "campo_valor"=>$estilo
                        ]
                    ];

                    /* Guarda los estilos llamando al método del mainModel */
                    $registrar_estilo = $this->guardarDatos("recetas_estilos", $guardar_estilo);
                    if (!$registrar_estilo->rowCount() == 1 ) {

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }

                }

                /* Borra los tipos de plato que hay guardados */
                $borrar_tiposplato = $this->eliminarRegistro('recetas_tiposplato', 'id_receta', $id);

                /* Comprueba que se hayan borrado los tipos de plato */
                if (!$borrar_tiposplato->rowCount() == 1) {
                    /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                }

                /* Recorre el array de los tipos de plato */
                foreach ($tipo_plato as $tipo) {
                    /* Establece la variable para guardar cada tipo de plato en la tabla recetas_tiposplato */
                    $guardar_tipo = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id
                        ],
                        /* Id tipo */
                        [
                            "campo_nombre"=>"id_tipo",
                            "campo_marcador"=>":Tipo",
                            "campo_valor"=>$tipo
                        ]
                    ];

                    /* Guarda los tipos de plato llamando al método del mainModel */
                    $registrar_tipo = $this->guardarDatos("recetas_tiposplato", $guardar_tipo);
                    if (!$registrar_tipo->rowCount() == 1 ) {

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }

                }

                if ($this->seleccionarDatos('Unico', 'recetas_tecnicas', 'id_receta', $id)->rowCount() > 0) {
                    
                    /* Borra los métodos que hay guardados */
                    $borrar_metodos = $this->eliminarRegistro('recetas_tecnicas', 'id_receta', $id);
    
                    /* Comprueba que se hayan borrado los métodos */
                    if (!$borrar_metodos->rowCount() == 1) {
                        /* Muestra la ventana de error */
                            $alerta = [
                                "tipo"=>"simple",
                                "titulo"=>"Error inesperado",
                                "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                                "icono"=>"error"
                            ];
                            return json_encode($alerta);
                            exit();
                    }
                }


                /* Recorre el array de los métodos */
                foreach ($metodo_receta as $metodo) {
                    /* Establece la variable para guardar cada método en la tabla recetas_tecnicas */
                    $guardar_metodo = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id
                        ],
                        /* Id tipo */
                        [
                            "campo_nombre"=>"id_tecnica",
                            "campo_marcador"=>":Tecnica",
                            "campo_valor"=>$metodo
                        ]
                    ];

                    /* Guarda los métodos llamando al método del mainModel */
                    $registrar_metodo = $this->guardarDatos("recetas_tecnicas", $guardar_metodo);
                    if (!$registrar_metodo->rowCount() == 1 ) {

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }

                }

                /* Borra los utensilios que hay guardados */
                $borrar_utensilios = $this->eliminarRegistro('recetas_utensilios', 'id_receta', $id);

                /* Comprueba que se hayan borrado los estilos */
                if (!$borrar_utensilios->rowCount() == 1) {
                    /* Muestra la ventana de error */
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"Error inesperado",
                        "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                /* Recorre el array de utensilios */
                foreach ($utensilios_receta as $utensilio) {
                    /* Establece la variable para guardar cada utensilio en la tabla recetas_utensilios */
                    $guardar_utensilio = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id
                        ],
                        /* Id utensilio */
                        [
                            "campo_nombre"=>"id_utensilio",
                            "campo_marcador"=>":Utensilio",
                            "campo_valor"=>$utensilio
                        ]
                    ];

                    /* Guarda los utensilios llamando al método del mainModel */
                    $registrar_utensilio = $this->guardarDatos("recetas_utensilios", $guardar_utensilio);
                    if (!$registrar_utensilio->rowCount() == 1 ) {

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit;
                    }

                }

                /* Borra los ingredientes que hay guardados */
                $borrar_ingredientes = $this->eliminarRegistro('recetas_ingredientes', 'id_receta', $id);

                /* Comprueba que se hayan borrado los ingredientes */
                if (!$borrar_ingredientes->rowCount() == 1) {
                    /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                }

                /* Recorre el array de ingredientes */
                foreach ($ingredientes_receta as $ingrediente) {
                    /* Busca la cantidad en el array de cantidades */
                    if (array_key_exists($ingrediente, $cantidad_ingredientes)) {
                        $cant = $cantidad_ingredientes[$ingrediente];
                    }

                    /* Busca la unidad de medida en el array de unidades */
                    if (array_key_exists($ingrediente, $unidad_ingredientes)) {
                        $unid = $unidad_ingredientes[$ingrediente];
                    }


                    /* Establece la variable para guardar cada ingrediente en la tabla recetas_ingredientes */
                    $guardar_ingrediente = [
                        /* Id receta */
                        [
                            "campo_nombre"=>"id_receta",
                            "campo_marcador"=>":Receta",
                            "campo_valor"=>$id
                        ],

                        /* Id ingrediente */
                        [
                            "campo_nombre"=>"id_ingrediente",
                            "campo_marcador"=>":Ingrediente",
                            "campo_valor"=>$ingrediente
                        ],

                        /* Cantidad */
                        [
                            "campo_nombre"=>"cantidad",
                            "campo_marcador"=>":Cantidad",
                            "campo_valor"=>$cant
                        ],

                        /* Unidad de medida */
                        [
                            "campo_nombre"=>"id_unidad",
                            "campo_marcador"=>":Unidad",
                            "campo_valor"=>$unid
                        ]
                    ];
                    
                    /* Guarda los ingredientes llamando al método del mainModel */
                    $registrar_ingrediente = $this->guardarDatos("recetas_ingredientes", $guardar_ingrediente);
                    if (!$registrar_ingrediente->rowCount() == 1 ) {

                        /* Muestra la ventana de error */
                        $alerta = [
                            "tipo"=>"simple",
                            "titulo"=>"Error inesperado",
                            "texto"=>"No hemos podido guardar algún dato de la receta. Por favor, póngase en contacto con un administrador.",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }

                }

                /* Ventana de Éxito y limpia el formulario */
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Felicidades!!!",
                    "texto" => "La receta ".$nombre_receta." ha sido guardada correctamente",
                    "icono" => "success"
                ];

            } else {

                /* Borra la foto si se ha subido */
                if (is_file($img_dir.$foto_receta)) {
                    chmod($img_dir.$foto_receta, 777);
                    unlink($img_dir.$foto_receta);
                }

                /* Muestra la ventana de error */
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error inesperado",
                    "texto"=>"No hemos podido guardar la receta. Por favor, inténtelo de nuevo más tarde.",
                    "icono"=>"error"
                ];
            }
            
            /* Devuelve la ventana de información */
            return json_encode($alerta);







            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"Vas a actualizar la receta"
            ];
            return json_encode($alerta);
            exit();
        }

        /* APROBAR UNA RECETA */
        public function aprobarRecetaControlador(){
            /* Comprobar que el usuario es administrador o revisor */
            if (!$_SESSION['administrador']) {
                if (!$_SESSION['revisor']) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR GRAVE",
                        "texto"=>"No puedes cambiar el estado de los utensilios. No eres administrador del sistema",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_receta']);


                /* Activa la receta */
                /* Crea el array para guardar los datos */
                $receta_datos_up = [
                    [
                        "campo_nombre"=>"activo",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>1
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_receta",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("recetas", $receta_datos_up, $condicion)) {
                    $alerta = [
                        "tipo"=>"simple",
                        "titulo"=>"Activada",
                        "texto"=>"La receta ha sido activada satisfactoriamente",
                        "icono"=>"success"
                    ];
                } else {

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error",
                        "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    exit();
                }

            return json_encode($alerta);

        /* Fin aprobarRecetaControlador */
        }

        /* DESACTIVAR UNA RECETA */
        public function desactivarRecetaControlador(){
            /* Comprobar que el usuario es administrador o revisor */
            if (!$_SESSION['administrador']) {
                if (!$_SESSION['revisor']) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR GRAVE",
                        "texto"=>"No puedes cambiar el estado de los utensilios. No eres administrador del sistema",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_receta']);


                /* Desactiva la receta */
                /* Crea el array para guardar los datos */
                $receta_datos_up = [
                    [
                        "campo_nombre"=>"activo",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>0
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_receta",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("recetas", $receta_datos_up, $condicion)) {
                    $alerta = [
                        "tipo"=>"recargar",
                        "titulo"=>"Desactivada",
                        "texto"=>"La receta ha sido desactivada satisfactoriamente",
                        "icono"=>"success"
                    ];
                } else {

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error",
                        "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                    exit();
                }

            return json_encode($alerta);

        /* Fin desactivarRecetaControlador */
        }
    }
