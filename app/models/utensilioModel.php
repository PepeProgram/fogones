<?php
    namespace app\models;
    /* Define namespaces. El lugar donde está almacenado el modelo */

    class utensilioModel extends mainModel{
        public $id_utensilio, $nombre_utensilio, $foto_utensilio, $activo_utensilio;

        function __construct($id_utensilio){
            $this->id_utensilio = $id_utensilio;
            $this->nombre_utensilio = $this->checkNombre();
            $this->foto_utensilio = $this->checkFoto();
            $this->activo_utensilio = $this->checkActivo();
        }

        /* Recupera el nombre del utensilio */
        private function checkNombre(){
            $nombre = $this->ejecutarConsulta("SELECT * FROM utensilios WHERE id_utensilio='$this->id_utensilio'");
            $nombre = $nombre->fetch();

            return $nombre['nombre_utensilio'];

        }

        /* Recupera la foto del utensilio */
        private function checkFoto(){
            $foto = $this->ejecutarConsulta("SELECT * FROM utensilios WHERE id_utensilio='$this->id_utensilio'");
            $foto = $foto->fetch();

            if ($foto['foto_utensilio'] == "") {
                return 'default.png';
            } else {
                return $foto['foto_utensilio'];
            }
            
        }

        /* Comprueba si el utensilio está activo o no */
        private function checkActivo(){
            $activo = $this->ejecutarConsulta("SELECT * FROM utensilios WHERE id_utensilio='$this->id_utensilio'");
            $activo = $activo->fetch();
            return $activo['activo'];
            
            
        }

        /**
         * Get the value of nombre_utensilio
         */ 
        public function getNombre_utensilio()
        {
                return $this->nombre_utensilio;
        }

        /**
         * Set the value of nombre_utensilio
         *
         * @return  self
         */ 
        public function setNombre_utensilio($nombre_utensilio)
        {
                $this->nombre_utensilio = $nombre_utensilio;

                return $this;
        }

        /**
         * Get the value of foto_utensilio
         */ 
        public function getFoto_utensilio()
        {
                return $this->foto_utensilio;
        }

        /**
         * Set the value of foto_estilo
         *
         * @return  self
         */ 
        public function setFoto_utensilio($foto_utensilio)
        {
                $this->foto_utensilio = $foto_utensilio;

                return $this;
        }

        /**
         * Get the value of id_utensilio
         */ 
        public function getId_utensilio()
        {
                return $this->id_utensilio;
        }

        /**
         * Set the value of id_utensilio
         *
         * @return  self
         */ 
        public function setId_utensilio($id_utensilio)
        {
                $this->id_utensilio = $id_utensilio;

                return $this;
        }

        /**
         * Get the value of activo_utensilio
         */ 
        public function getActivo_utensilio()
        {
                return $this->activo_utensilio;
        }

        /**
         * Set the value of activo_utensilio
         *
         * @return  self
         */ 
        public function setActivo_utensilio($activo_utensilio)
        {
                $this->activo_utensilio = $activo_utensilio;

                return $this;
        }
    }