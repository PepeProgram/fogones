<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Trae el modelo de ingrediente para crear los objetos ingrediente */
    use app\models\ingredienteModel;

    /* Crea la clase hija de la clase principal */
    class ingredienteController extends mainModel{

        /* CHEQUEAR SI HAY INGREDIENTES PENDIENTES DE REVISIÓN */
        public function revisarIngredientesControlador(){
            /* Ejecuta la búsqueda para comprobar si hay pendientes de revisión */
            $ingredientesRevisar = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE activo = 0");

            /* Devuelve true o false */
            if ($ingredientesRevisar->rowCount()>0) {
                return true;
            }
            else{
                return false;
            }

        }

        /* LISTAR LOS INGREDIENTES */
        public function listarIngredientesControlador(){

            $vista_actual = explode("/", $_SERVER['REQUEST_URI']);

            if (isset($vista_actual[3]) && $vista_actual[3] == "paraRevisar"){

                /* Ejecuta la búsqueda de los ingredientes pendientes de revisión */
                $ingredientes = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE activo = 0 ORDER BY nombre_ingrediente");
            }
            else{

                /* Ejecuta la búsqueda de todos los ingredientes */
                $ingredientes = $this->ejecutarConsulta("SELECT * FROM ingredientes ORDER BY nombre_ingrediente");
            }


            /* Convierte el resultado a array */
            if ($ingredientes->rowCount()>0) {
                $ingredientes = $ingredientes->fetchAll();
            }

            /* Crea un array para ir guardando los ingredientes */
            $lista_ingredientes = array();

            /* Recorre el array de datos para ir creando objetos e insertándolos en la lista de ingredientes */
            foreach ($ingredientes as $fila) {
                /* Crea una nueva instancia de ingrediente */
                $ingrediente = new ingredienteModel($fila['id_ingrediente']);

                /* Añade el ingrediente a la lista */
                array_push($lista_ingredientes, $ingrediente);
            }
            /* Devuelve la lista de ingredientes */
            return $lista_ingredientes;

        }

        /* GUARDAR UN INGREDIENTE */
        public function guardarIngredienteControlador(){
            /* Verifica que el usuario ha iniciado sesión, existe y es redactor o administrador */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un utensilio de cocina",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                /* Verificar que el usuario es quien dice ser */
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder añadir un utensilio de cocina",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    /* Comprobar que el usuario es administrador, revisor o redactor */
                        if (!$_SESSION['administrador']) {
                            if (!$_SESSION['revisor']) {
                                if (!$_SESSION['redactor']) {
                                    # code...
                                    $alerta=[
                                        "tipo"=>"simple",
                                        "titulo"=>"ERROR GRAVE",
                                        "texto"=>"No puedes añadir ingredientes. No eres administrador, revisor ni redactor",
                                        "icono"=>"error"
                                    ];
                                }
                            }
                            return json_encode($alerta);
                            exit();
                        }
                }
                
            }

            /* Recupera el nombre del ingrediente */
            if ($_POST['nombre_ingrediente']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[,;:()%a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}", $_POST['nombre_ingrediente'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del ingrediente sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_ingrediente = $this->limpiarCadena($_POST['nombre_ingrediente']);

                /* Comprueba si el nombre del ingrediente ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM ingredientes WHERE nombre_ingrediente = '$nombre_ingrediente' ")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El Ingrediente $nombre_ingrediente ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del ingrediente no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* Actualiza la base de datos */
            $ingrediente_datos_reg = [
                [
                    "campo_nombre"=>"nombre_ingrediente",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_ingrediente
                ]
            ];

            $registrar_ingrediente = $this->guardarDatos("ingredientes", $ingrediente_datos_reg);
            
            /* Recupera el id y el nombre del último ingrediente añadido */
            $ultimoInsert = $this->ejecutarConsulta("SELECT * FROM ingredientes ORDER BY id_ingrediente DESC LIMIT 1");
            $ultimoInsert = $ultimoInsert->fetch();
            $ultimoId = $ultimoInsert['id_ingrediente'];
            $ultimoNombre = $ultimoInsert['nombre_ingrediente'];


            if ($registrar_ingrediente->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Ingrediente guardado!!!",
                    "texto" => "El Ingrediente ".$nombre_ingrediente." ha sido registrado correctamente.",
                    "icono" => "success",
                    "id" => $ultimoId,
                    "nombre" => $ultimoNombre
                ];
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido guardar el ingrediente en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }

        /* ACTUALIZAR UN INGREDIENTE */
        public function actualizarIngredienteControlador(){

            /* Recupera el id del ingrediente */
            $id = $this->limpiarCadena($_POST['id_Form']);

            /* Verifica que el ingrediente existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id'");
            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El ingrediente no existe",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }
            
            /* Verifica que el usuario ha iniciado sesión, es administrador, revisor o redactor y existe */
            /* Comprueba que ha iniciado sesión */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {

                /* Comprueba que es quien dice ser */
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        if (!$_SESSION['revisor']) {
                            if (!$_SESSION['redactor']) {
                                $alerta=[
                                    "tipo"=>"simple",
                                    "titulo"=>"ERROR",
                                    "texto"=>"No puede realizar cambios si no es administrador, revisor o redactor",
                                    "icono"=>"error"
                                ];
                            }
                        }
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Recupera el nombre del ingrediente */
            if ($_POST['nombre_ingrediente']) {

                /* VERIFICA LOS PATRONES DE LOS DATOS */
            
                /* Nombre */
                if ($this->verificarDatos("[()%,;:a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.\-_ ]{3,50}", $_POST['nombre_ingrediente'])) {
                    /* Establece los valores de la ventana de alerta y los retorna al ajax.js */
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error en el formulario",
                        "texto" => "El nombre del ingrediente sólo puede contener letras, números, (, ), , ,, ;, :, %, .,-,_ y espacios",
                        "icono" => "error"
                    ];

                    /* Codifica la variable como datos JSON */
                    return json_encode($alerta);

                    /* Detiene la ejecución del script */
                    exit();
                }

                /* Limpia los datos para evitar SQL Injection */
                $nombre_ingrediente = $this->limpiarCadena($_POST['nombre_ingrediente']);

                /* Comprueba si el nombre del ingrediente ya existe */
                if ($this->ejecutarConsulta("SELECT * FROM ingredientes WHERE nombre_ingrediente='$nombre_ingrediente' AND id_ingrediente !='$id'")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El ingrediente $nombre_ingrediente ya existe",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del ingrediente no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }
            
            /* Actualiza la base de datos */
            $ingrediente_datos_up = [
                [
                    "campo_nombre"=>"nombre_ingrediente",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre_ingrediente
                ]
            ];

            $condicion = [
                "condicion_campo"=>"id_ingrediente",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            /* Comprueba si se han insertado los datos */
            if ($this->actualizarDatos("ingredientes", $ingrediente_datos_up, $condicion)) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Actualizado!!!",
                    "texto" => "El ingrediente ".$nombre_ingrediente." ha sido atualizado correctamente.",
                    "icono" => "success"
                ];
            } else {

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);
            
        }

        /* AGREGAR ALERGENO A UN INGREDIENTE */
        public function agregarAlergenoIngredienteControlador(){

            /* Verifica que el usuario ha iniciado sesión, es administrador, revisor o redactor y existe */
            /* Comprueba que ha iniciado sesión */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {

                /* Comprueba que es quien dice ser */
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        if (!$_SESSION['revisor']) {
                            if (!$_SESSION['redactor']) {
                                $alerta=[
                                    "tipo"=>"simple",
                                    "titulo"=>"ERROR",
                                    "texto"=>"No puede realizar cambios si no es administrador, revisor o redactor",
                                    "icono"=>"error"
                                ];
                            }
                        }
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

             /* Recupera el id del ingrediente */
            $id = $this->limpiarCadena($_POST['id_Form']);

            /* Verifica que el ingrediente existe */
            $datos = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id'");
            if ($datos->rowCount()<=0) {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"Error al intentar actualizar",
                    "texto"=>"El ingrediente no existe",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Recupera el id del alérgeno */
            if ($_POST['agregarAlergeno']) {

                /* Limpia los datos para evitar SQL Injection */
                $idAlergeno = $this->limpiarCadena($_POST['agregarAlergeno']);

                /* Comprueba si el alérgeno existe */
                if ($this->ejecutarConsulta("SELECT * FROM alergenos WHERE id_alergeno = '$idAlergeno' ")->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El Alérgeno seleccionado no se encuentra en la lista",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();

                }

                /* Comprueba que el ingrediente no tiene ese alérgeno */
                if ($this->ejecutarConsulta("SELECT * FROM ingredientes_alergenos WHERE id_alergeno = '$idAlergeno' AND id_ingrediente = $id ")->rowCount()>0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error!!!",
                        "texto"=>"El Ingrediente ya tiene este alérgeno",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error!!!",
                    "texto"=>"El nombre del ingrediente no puede estar vacío",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }

            /* Actualiza la base de datos */
            $alergeno_ingrediente_datos_reg = [
                [
                    "campo_nombre"=>"id_ingrediente",
                    "campo_marcador"=>":Ingrediente",
                    "campo_valor"=>$id
                ],
                [
                    "campo_nombre"=>"id_alergeno",
                    "campo_marcador"=>":Alergeno",
                    "campo_valor"=>$idAlergeno
                ]
            ];

            $registrar_alergeno_ingrediente = $this->guardarDatos("ingredientes_alergenos", $alergeno_ingrediente_datos_reg);

            if ($registrar_alergeno_ingrediente->rowCount() == 1) {
                $alerta = [
                    "tipo" => "recargar",
                    "titulo" => "Alérgeno añadido!!!",
                    "texto" => "El Alérgeno ha sido añadido correctamente.",
                    "icono" => "success"
                ];
            } else {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No se ha podido añadir el alérgeno en este momento. Inténtelo de nuevo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);




                  
        }

        /* QUITAR ALERGENO A UN INGREDIENTE */
        public function quitarAlergenoIngredienteControlador(){

            /* Verifica que el usuario ha iniciado sesión, es administrador, revisor o redactor y existe */
            /* Comprueba que ha iniciado sesión */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {

                /* Comprueba que es quien dice ser */
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder realizar cambios",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    if (!$_SESSION['administrador']) {
                        if (!$_SESSION['revisor']) {
                            if (!$_SESSION['redactor']) {
                                $alerta=[
                                    "tipo"=>"simple",
                                    "titulo"=>"ERROR",
                                    "texto"=>"No puede realizar cambios si no es administrador, revisor o redactor",
                                    "icono"=>"error"
                                ];
                            }
                        }
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Obtener los id que vienen en los campos ocultos del botón */
            $id_ingrediente = $this->limpiarCadena($_POST['id_ingrediente']);
            $id_alergeno = $this->limpiarCadena($_POST['id_alergeno']);

            /* Verificar que el ingrediente existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id_ingrediente'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el ingrediente en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                /* Verificar que el ingrediente contiene ese alérgeno */
                $datos = $this->ejecutarConsulta("SELECT * FROM ingredientes_alergenos WHERE id_ingrediente='$id_ingrediente' AND id_alergeno='$id_alergeno'");

                if ($datos->rowCount()<=0) {
                    $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"El alérgeno no contiene ese ingrediente",
                    "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {
                    $datos = $datos->fetch();
                }
                
            }

            /* Elimina el ingrediente del sistema */
            $quitarAlergeno = $this->eliminarRegistro("ingredientes_alergenos", "id_ing_ale", $datos['id_ing_ale']);

            if ($quitarAlergeno->rowCount()==1) {
                
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Alérgeno eliminado",
                    "texto"=>"El alérgeno ha sido eliminado del ingrediente",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El alérgeno no ha podido ser eliminado del ingrediente. Inténtelo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);



            /* Comprobar que el controlador va funcionando */
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Funciona",
                "texto"=>"Vas eliminando el alérgeno ".$datos['id_alergeno']." al ingrediente ".$datos['id_ingrediente']." con el id ".$datos['id_ing_ale'],
                "icono"=>"success"
            ];
            return json_encode($alerta);
            exit(); 
        }
        
        /* ELIMINAR UN INGREDIENTE */
        public function eliminarIngredienteControlador(){

            /* Verifica que el usuario ha iniciado sesión, es administrador y existe */
            if (!isset($_SESSION['id'])) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder eliminar ingredientes",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {

                /* Comprueba que es quien dice ser */
                $check_user = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE login_usuario='".$_SESSION['login']."' AND id_usuario='".$_SESSION['id']."'");

                if ($check_user->rowCount()<=0) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR",
                        "texto"=>"Debe iniciar sesión en su cuenta con su NOMBRE DE USUARIO y CONTRASEÑA para poder eliminar utensilios",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                } else {

                    /* Comprueba que es administrador */
                    if (!$_SESSION['administrador']) {
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"ERROR",
                            "texto"=>"No puede eliminar ingredientes si no es administrador del sistema",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }
                
            }

            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_ingrediente']);

            /* Verificar que el ingrediente existe */
            $datos=$this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el ingrediente en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }

            /* Elimina el ingrediente del sistema */
            $eliminarIngrediente = $this->eliminarRegistro("ingredientes", "id_ingrediente", $id);

            if ($eliminarIngrediente->rowCount()==1) {
                
                $alerta = [
                    "tipo"=>"recargar",
                    "titulo"=>"Ingrediente eliminado",
                    "texto"=>"El ingrediente ".$datos['nombre_ingrediente']." ha sido eliminado",
                    "icono"=>"success"
                ];
            } else {
                $alerta = [
                    "tipo"=>"simple",
                    "titulo"=>"ERROR",
                    "texto"=>"El ingrediente ".$datos['nombre_ingrediente']." no ha podido ser eliminado. Inténtelo más tarde",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }

        /* ACTIVAR O DESACTIVAR UN INGREDIENTE */
        public function cambiarActivoIngredienteControlador(){
            
            /* Comprobar que el usuario es administrador o revisor */
            if (!$_SESSION['administrador']) {
                if (!$_SESSION['revisor']) {
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"ERROR GRAVE",
                        "texto"=>"No puedes cambiar el estado de los utensilios. No eres administrador ni revisor",
                        "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
                exit();
            }
            
            /* Obtener el id que viene en el campo oculto del botón */
            $id = $this->limpiarCadena($_POST['id_ingrediente']);
            
            /* Verificar el ingrediente */
            $datos=$this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id'");

            if ($datos->rowCount()<=0) {
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"ERROR GRAVE",
                    "texto"=>"No existe el ingrediente en el sistema",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            } else {
                $datos = $datos->fetch();
            }
            
            /* Recupera los datos del ingrediente */
            $activo_ingrediente = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$id'");
            $activo_ingrediente = $activo_ingrediente->fetch();
            
            /* Verificar si el ingrediente está activo o no */
            if ($activo_ingrediente['activo'] == 0) {

                /* Activa el ingrediente */
                /* Crea el array para guardar los datos */
                $ingrediente_datos_up = [
                    [
                        "campo_nombre"=>"activo",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>1
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_ingrediente",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("ingredientes", $ingrediente_datos_up, $condicion)) {
                    $alerta = [
                        "tipo" => "recargar",
                        "titulo" => "Activado!!!",
                        "texto" => "El ingrediente ".$activo_ingrediente['nombre_ingrediente']." ha sido activado.",
                        "icono" => "success"
                    ];
                } else {

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error",
                        "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                }
            }
            else{
                /* Desactiva el ingrediente */
                /* Crea el array para guardar los datos */
                $ingrediente_datos_up = [
                    [
                        "campo_nombre"=>"activo",
                        "campo_marcador"=>":Activo",
                        "campo_valor"=>0
                    ]
                ];

                $condicion = [
                    "condicion_campo"=>"id_ingrediente",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$id
                ];

                /* Comprueba si se han insertado los datos */
                if ($this->actualizarDatos("ingredientes", $ingrediente_datos_up, $condicion)) {
                    $alerta = [
                        "tipo" => "recargar",
                        "titulo" => "Desactivado!!!",
                        "texto" => "El ingrediente ".$activo_ingrediente['nombre_ingrediente']." ha sido desactivado.",
                        "icono" => "success"
                    ];
                } else {

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Error",
                        "texto"=>"No se han podido actualizar los datos en este momento. Inténtelo de nuevo más tarde",
                        "icono"=>"error"
                    ];
                }
                
            }
            return json_encode($alerta);
        }
    }