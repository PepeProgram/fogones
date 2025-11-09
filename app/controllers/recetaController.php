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
                $metodo_receta = [];

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
            if ($this->verificarDatos("(?!.*\\\\)[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\*\/\-_ ]{3,}", $_POST['elaboracionEnviarReceta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "La elaboración de la receta debe tener al menos 3 caracteres y sólo puede contener letras, números, *, .,/,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* Emplatado */
            if ($this->verificarDatos("(?!.*\\\\)[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\*\/\-_ ]*", $_POST['emplatadoEnviarReceta'])) {
                /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El emplatado sólo puede contener letras, números, *, .,/,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
            }

            /* GUARDAR LA RECETA */

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
                    /* Establece la variable para guardar cada estilo en la tabla recetas_estilos */
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
                    /* Establece la variable para guardar cada estilo en la tabla recetas_estilos */
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
                    "tipo" => "limpiarRegistro",
                    "titulo" => "Felicidades!!!",
                    "texto" => "La receta ".$nombre_receta." ha sido guardada correctamente por el usuario ".$_SESSION['id']." con el id ".$id_receta,
                    "icono" => "success"
                ];

            } else {

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







            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>json_encode($receta_datos_reg)
                /* "texto"=>"Nombre: ".$nombre_receta." Pax: ".$numero_personas." Tiempo: ".$tiempo_elaboracion." Dificultad: ".$dificultad_receta." Estilo:  ".json_encode($estilo_cocina)." Tipo Plato: ".json_encode($tipo_plato)." Método: ".json_encode($metodo_receta)." Grupo Plato: ".$grupo_plato." Descripción: ".$descripcion_receta." Zona: ".$zona_receta." País: ".$pais_receta." Región: ".$region_receta." Utensilios: ".json_encode($utensilios_receta)." Ingredientes: ".json_encode($ingredientes_receta)." Cantidades: ".json_encode($cantidad_ingredientes)." Unidades: ".json_encode($unidad_ingredientes)." Elaboración: ".$elaboracion_receta." Emplatado: ".$emplatado_receta,
                "icono"=>"success" */
            ];
            return json_encode($alerta);
            exit();


        /* Fin guardarRecetaControlador */
        }
    }
