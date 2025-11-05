<?php
    namespace app\models;
    /* Define namespaces. El lugar donde está almacenado el modelo */

    class ingredienteModel extends mainModel{
        public $id_ingrediente, $nombre_ingrediente, $alergenos_ingrediente, $activo_ingrediente;

        function __construct($id_ingrediente){
            $this->id_ingrediente = $id_ingrediente;
            $this->nombre_ingrediente = $this->checkNombre();
            $this->activo_ingrediente = $this->checkActivo();

            $this->alergenos_ingrediente = array();
            $this->alergenos_ingrediente = $this->checkAlergenos();
        }

        /* Recupera el nombre del ingrediente */
        private function checkNombre(){
            $nombre = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$this->id_ingrediente'");
            $nombre = $nombre->fetch();

            return $nombre['nombre_ingrediente'];

        }

        /* Recupera los alérgenos */
        private function checkAlergenos(){
                $alergenos_consultar = $this->ejecutarConsulta("SELECT * FROM ingredientes_alergenos WHERE id_ingrediente='$this->id_ingrediente'" );
                $alergenos_consultar = $alergenos_consultar->fetchAll();
                $alergenos = array();
                foreach ($alergenos_consultar as $alergeno) {
                        array_push($alergenos, $alergeno['id_alergeno']);
                }
                return $alergenos;
        }

        /* Comprueba si el ingrediente está activo o no */
        private function checkActivo(){
            $activo = $this->ejecutarConsulta("SELECT * FROM ingredientes WHERE id_ingrediente='$this->id_ingrediente'");
            $activo = $activo->fetch();
            return $activo['activo'];
            
        }

        /**
         * Get the value of nombre_ingrediente
         */ 
        public function getNombre_ingrediente()
        {
                return $this->nombre_ingrediente;
        }

        /**
         * Set the value of nombre_ingrediente
         *
         * @return  self
         */ 
        public function setNombre_ingrediente($nombre_ingrediente)
        {
                $this->nombre_ingrediente = $nombre_ingrediente;

                return $this;
        }

        /**
         * Get the value of id_ingrediente
         */ 
        public function getId_ingrediente()
        {
                return $this->id_ingrediente;
        }

        /**
         * Set the value of id_ingrediente
         *
         * @return  self
         */ 
        public function setId_ingrediente($id_ingrediente)
        {
                $this->id_ingrediente = $id_ingrediente;

                return $this;
        }

        /**
         * Get the value of activo_ingrediente
         */ 
        public function getActivo_ingrediente()
        {
                return $this->activo_ingrediente;
        }

        /**
         * Set the value of activo_ingrediente
         *
         * @return  self
         */ 
        public function setActivo_ingrediente($activo_ingrediente)
        {
                $this->activo_ingrediente = $activo_ingrediente;

                return $this;
        }

        /**
         * Get the value of alergeno_ingrediente
         */ 
        public function getAlergenos_ingrediente()
        {
                return $this->alergenos_ingrediente;
        }

        /**
         * Set the value of alergeno_ingrediente
         *
         * @return  self
         */ 
        public function setAlergenos_ingrediente($alergeno_ingrediente)
        {
                array_push($this->alergenos_ingrediente, $alergeno_ingrediente);

                return $this;
        }
    }