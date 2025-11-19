<?php
    namespace app\models;
    /* Define namespaces. El lugar donde se encuentra almacenado el modelo */

    /* Carga el modelo de alérgenos para poder usarlo */
    use app\models\alergenoModel;

    /* Carga el modelo de ingredientes para poder usarlo */
use JsonSerializable;

    class recetaModel extends mainModel implements JsonSerializable{
        private $id, $nombre, $descripcion, $id_usuario, $id_grupo, $personas, $tiempo, $id_autor, $id_region, $id_pais, $id_zona, $dificultad, $elaboracion, $emplatado, $foto, $visualizaciones, $creado, $actualizado, $activo, $estilos, $tipos_plato, $metodos, $utensilios, $ingredientes, $alergenos;

        function __construct($id, $nombre, $descripcion, $id_usuario, $id_grupo, $personas, $tiempo, $id_autor, $id_region, $id_pais, $id_zona, $dificultad, $elaboracion, $emplatado, $foto, $visualizaciones, $creado, $actualizado, $activo) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->id_usuario = $id_usuario;
            $this->id_grupo = $id_grupo;
            $this->personas = $personas;
            $this->tiempo = $tiempo;
            $this->id_autor = $id_autor;
            $this->id_region = $id_region;
            $this->id_pais = $id_pais;
            $this->id_zona = $id_zona;
            $this->dificultad = $dificultad;
            $this->elaboracion = $elaboracion;
            $this->emplatado = $emplatado;
            $this->foto = $foto;
            $this->visualizaciones = $visualizaciones;
            $this->creado = $creado;
            $this->actualizado = $actualizado;
            $this->activo = $activo;
            $this->estilos = $this->checkEstilos();
            $this->tipos_plato = $this->checkTiposPlato();
            $this->metodos = $this->checkMetodos();
            $this->utensilios = $this->checkUtensilios();
            $this->ingredientes = $this->checkIngredientes();
            $this->alergenos = $this->checkAlergenos();
            
        }

        public function jsonSerialize(): mixed {
                return [
                        'id'                      => $this->id,
                        'nombre'                  => $this->nombre,
                        'descripcion'             => $this->descripcion,
                        'id_usuario'              => $this->id_usuario,
                        'id_grupo'                => $this->id_grupo,
                        'personas'                => $this->personas,
                        'tiempo'                  => $this->tiempo,
                        'id_autor'                => $this->id_autor,
                        'id_region'               => $this->id_region,
                        'id_pais'                 => $this->id_pais,
                        'id_zona'                 => $this->id_zona,
                        'dificultad'              => $this->dificultad,
                        'elaboracion'             => $this->elaboracion,
                        'emplatado'               => $this->emplatado,
                        'foto'                    => $this->foto,
                        'visualizaciones'         => $this->visualizaciones,
                        'creado'                  => $this->creado,
                        'actualizado'             => $this->actualizado,
                        'activo'                  => $this->activo,
                        'estilos'                 => $this->estilos,
                        'tipos_plato'             => $this->tipos_plato,
                        'metodos'                 => $this->metodos,
                        'utensilios'              => $this->utensilios,
                        'ingredientes'            => $this->ingredientes,
                        'alergenos'               => $this->alergenos

                ];
        }

        function checkEstilos(){
            $estilos = $this->ejecutarConsulta("SELECT id_estilo FROM recetas_estilos WHERE id_receta = '$this->id'");
            $estilos = $estilos->fetchAll();
            return $estilos;
        }

        function checkTiposPlato(){
            $tipos = $this->ejecutarConsulta("SELECT id_tipo FROM recetas_tiposplato WHERE id_receta = '$this->id'");
            $tipos = $tipos->fetchAll();
            return $tipos;
        }

        function checkMetodos(){
            $metodos = $this->ejecutarConsulta("SELECT id_tecnica FROM recetas_tecnicas WHERE id_receta = '$this->id'");
            $metodos = $metodos->fetchAll();
            return $metodos;
        }

        function checkUtensilios(){
            $utensilios = $this->ejecutarConsulta("SELECT id_utensilio FROM recetas_utensilios WHERE id_receta = '$this->id'");
            $utensilios = $utensilios->fetchAll();
            return $utensilios;
        }

        function checkIngredientes(){
            $ingredientes = $this->ejecutarConsulta("SELECT recetas_ingredientes.id_recetas_ingredientes, recetas_ingredientes.id_receta, recetas_ingredientes.id_ingrediente, ingredientes.nombre_ingrediente, recetas_ingredientes.cantidad, recetas_ingredientes.id_unidad, unidades_medida.nombre_unidad FROM recetas_ingredientes INNER JOIN ingredientes ON recetas_ingredientes.id_ingrediente = ingredientes.id_ingrediente INNER JOIN unidades_medida ON recetas_ingredientes.id_unidad = unidades_medida.id_unidad WHERE id_receta = '$this->id' ORDER BY id_recetas_ingredientes");
            $ingredientes = $ingredientes->fetchAll();
            return $ingredientes;
        }

        function checkAlergenos(){
            $total_alergenos = $this->ejecutarConsulta("SELECT DISTINCT alerg.* FROM recetas_ingredientes rec_ing INNER JOIN ingredientes_alergenos ing_al ON rec_ing.id_ingrediente = ing_al.id_ingrediente INNER JOIN alergenos alerg ON ing_al.id_alergeno = alerg.id_alergeno WHERE rec_ing.id_receta = '$this->id'");
            $total_alergenos = $total_alergenos->fetchAll();
            
            $alergenos = array();

            foreach ($total_alergenos as $alergeno) {
                $alergeno_array = new alergenoModel($alergeno['id_alergeno'], $alergeno['nombre_alergeno'], $alergeno['foto_alergeno']);
                array_push($alergenos, $alergeno_array);
                
            }

            return $alergenos;
        }






        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of descripcion
         */ 
        public function getDescripcion()
        {
                return $this->descripcion;
        }

        /**
         * Set the value of descripcion
         *
         * @return  self
         */ 
        public function setDescripcion($descripcion)
        {
                $this->descripcion = $descripcion;

                return $this;
        }

        /**
         * Get the value of id_usuario
         */ 
        public function getId_usuario()
        {
                return $this->id_usuario;
        }

        /**
         * Set the value of id_usuario
         *
         * @return  self
         */ 
        public function setId_usuario($id_usuario)
        {
                $this->id_usuario = $id_usuario;

                return $this;
        }

        /**
         * Get the value of id_grupo
         */ 
        public function getId_grupo()
        {
                return $this->id_grupo;
        }

        /**
         * Set the value of id_grupo
         *
         * @return  self
         */ 
        public function setId_grupo($id_grupo)
        {
                $this->id_grupo = $id_grupo;

                return $this;
        }

        /**
         * Get the value of personas
         */ 
        public function getPersonas()
        {
                return $this->personas;
        }

        /**
         * Set the value of personas
         *
         * @return  self
         */ 
        public function setPersonas($personas)
        {
                $this->personas = $personas;

                return $this;
        }

        /**
         * Get the value of tiempo
         */ 
        public function getTiempo()
        {
                return $this->tiempo;
        }

        /**
         * Set the value of tiempo
         *
         * @return  self
         */ 
        public function setTiempo($tiempo)
        {
                $this->tiempo = $tiempo;

                return $this;
        }

        /**
         * Get the value of id_autor
         */ 
        public function getId_autor()
        {
                return $this->id_autor;
        }

        /**
         * Set the value of id_autor
         *
         * @return  self
         */ 
        public function setId_autor($id_autor)
        {
                $this->id_autor = $id_autor;

                return $this;
        }

        /**
         * Get the value of id_region
         */ 
        public function getId_region()
        {
                return $this->id_region;
        }

        /**
         * Set the value of id_region
         *
         * @return  self
         */ 
        public function setId_region($id_region)
        {
                $this->id_region = $id_region;

                return $this;
        }

        /**
         * Get the value of id_pais
         */ 
        public function getId_pais()
        {
                return $this->id_pais;
        }

        /**
         * Set the value of id_pais
         *
         * @return  self
         */ 
        public function setId_pais($id_pais)
        {
                $this->id_pais = $id_pais;

                return $this;
        }

        /**
         * Get the value of id_zona
         */ 
        public function getId_zona()
        {
                return $this->id_zona;
        }

        /**
         * Set the value of id_zona
         *
         * @return  self
         */ 
        public function setId_zona($id_zona)
        {
                $this->id_zona = $id_zona;

                return $this;
        }

        /**
         * Get the value of dificultad
         */ 
        public function getDificultad()
        {
                return $this->dificultad;
        }

        /**
         * Set the value of dificultad
         *
         * @return  self
         */ 
        public function setDificultad($dificultad)
        {
                $this->dificultad = $dificultad;

                return $this;
        }

        /**
         * Get the value of elaboracion
         */ 
        public function getElaboracion()
        {
                return $this->elaboracion;
        }

        /**
         * Set the value of elaboracion
         *
         * @return  self
         */ 
        public function setElaboracion($elaboracion)
        {
                $this->elaboracion = $elaboracion;

                return $this;
        }

        /**
         * Get the value of emplatado
         */ 
        public function getEmplatado()
        {
                return $this->emplatado;
        }

        /**
         * Set the value of emplatado
         *
         * @return  self
         */ 
        public function setEmplatado($emplatado)
        {
                $this->emplatado = $emplatado;

                return $this;
        }

        /**
         * Get the value of foto
         */ 
        public function getFoto()
        {
                return $this->foto;
        }

        /**
         * Set the value of foto
         *
         * @return  self
         */ 
        public function setFoto($foto)
        {
                $this->foto = $foto;

                return $this;
        }

        /**
         * Get the value of visualizaciones
         */ 
        public function getVisualizaciones()
        {
                return $this->visualizaciones;
        }

        /**
         * Set the value of visualizaciones
         *
         * @return  self
         */ 
        public function setVisualizaciones($visualizaciones)
        {
                $this->visualizaciones = $visualizaciones;

                return $this;
        }

        /**
         * Get the value of creado
         */ 
        public function getCreado()
        {
                return $this->creado;
        }

        /**
         * Set the value of creado
         *
         * @return  self
         */ 
        public function setCreado($creado)
        {
                $this->creado = $creado;

                return $this;
        }

        /**
         * Get the value of actualizado
         */ 
        public function getActualizado()
        {
                return $this->actualizado;
        }

        /**
         * Set the value of actualizado
         *
         * @return  self
         */ 
        public function setActualizado($actualizado)
        {
                $this->actualizado = $actualizado;

                return $this;
        }

        /**
         * Get the value of activo
         */ 
        public function getActivo()
        {
                return $this->activo;
        }

        /**
         * Set the value of activo
         *
         * @return  self
         */ 
        public function setActivo($activo)
        {
                $this->activo = $activo;

                return $this;
        }

        /**
         * Get the value of estilos
         */ 
        public function getEstilos()
        {
                return $this->estilos;
        }

        /**
         * Set the value of estilos
         *
         * @return  self
         */ 
        public function setEstilos($estilos)
        {
                $this->estilos = $estilos;

                return $this;
        }

        /**
         * Get the value of tipos_plato
         */ 
        public function getTipos_plato()
        {
                return $this->tipos_plato;
        }

        /**
         * Set the value of tipos_plato
         *
         * @return  self
         */ 
        public function setTipos_plato($tipos_plato)
        {
                $this->tipos_plato = $tipos_plato;

                return $this;
        }

        /**
         * Get the value of metodos
         */ 
        public function getMetodos()
        {
                return $this->metodos;
        }

        /**
         * Set the value of metodos
         *
         * @return  self
         */ 
        public function setMetodos($metodos)
        {
                $this->metodos = $metodos;

                return $this;
        }

        /**
         * Get the value of utensilios
         */ 
        public function getUtensilios()
        {
                return $this->utensilios;
        }

        /**
         * Set the value of utensilios
         *
         * @return  self
         */ 
        public function setUtensilios($utensilios)
        {
                $this->utensilios = $utensilios;

                return $this;
        }

        /**
         * Get the value of ingredientes
         */ 
        public function getIngredientes()
        {
                return $this->ingredientes;
        }

        /**
         * Set the value of ingredientes
         *
         * @return  self
         */ 
        public function setIngredientes($ingredientes)
        {
                $this->ingredientes = $ingredientes;

                return $this;
        }

        /**
         * Get the value of alergenos
         */ 
        public function getAlergenos()
        {
                return $this->alergenos;
        }

        /**
         * Set the value of alergenos
         *
         * @return  self
         */ 
        public function setAlergenos($alergenos)
        {
                $this->alergenos = $alergenos;

                return $this;
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }
    }