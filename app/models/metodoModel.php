<?php
    namespace app\models;
    /* Define namespaces. El lugar donde está almacenado el modelo */

    class metodoModel extends mainModel{
        public $id_metodo, $nombre_metodo, $foto_metodo;

        function __construct($id_metodo){
            $this->id_metodo = $id_metodo;
            $this->nombre_metodo = $this->checkNombre();
            $this->foto_metodo = $this->checkFoto();
        }

        private function checkNombre(){
            $nombre = $this->ejecutarConsulta("SELECT * FROM tecnicas WHERE id_tecnica='$this->id_metodo'");
            $nombre = $nombre->fetch();

            return $nombre['nombre_tecnica'];

        }

        private function checkFoto(){
            $foto = $this->ejecutarConsulta("SELECT * FROM tecnicas WHERE id_tecnica='$this->id_metodo'");
            $foto = $foto->fetch();

            if ($foto['foto_tecnica'] == "") {
                return 'default.png';
            } else {
                return $foto['foto_tecnica'];
            }
            
        }

        /**
         * Get the value of nombre_metodo
         */ 
        public function getNombre_metodo()
        {
                return $this->nombre_metodo;
        }

        /**
         * Set the value of nombre_metodo
         *
         * @return  self
         */ 
        public function setNombre_metodo($nombre_metodo)
        {
                $this->nombre_metodo = $nombre_metodo;

                return $this;
        }

        /**
         * Get the value of foto_metodo
         */ 
        public function getFoto_metodo()
        {
                return $this->foto_metodo;
        }

        /**
         * Set the value of foto_metodo
         *
         * @return  self
         */ 
        public function setFoto_metodo($foto_metodo)
        {
                $this->foto_metodo = $foto_metodo;

                return $this;
        }

        /**
         * Get the value of id_metodo
         */ 
        public function getId_metodo()
        {
                return $this->id_metodo;
        }

        /**
         * Set the value of id_metodo
         *
         * @return  self
         */ 
        public function setId_metodo($id_metodo)
        {
                $this->id_metodo = $id_metodo;

                return $this;
        }
    }