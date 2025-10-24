<?php
    namespace app\models;
    /* Define namespaces. El lugar donde está almacenado el modelo */

    class estiloCocinaModel extends mainModel{
        public $id_estilo, $nombre_estilo, $foto_estilo;

        function __construct($id_estilo){
            $this->id_estilo = $id_estilo;
            $this->nombre_estilo = $this->checkNombre();
            $this->foto_estilo = $this->checkFoto();
        }

        private function checkNombre(){
            $nombre = $this->ejecutarConsulta("SELECT * FROM estilos_cocina WHERE id_estilo='$this->id_estilo'");
            $nombre = $nombre->fetch();

            return $nombre['nombre_estilo'];

        }

        private function checkFoto(){
            $foto = $this->ejecutarConsulta("SELECT * FROM estilos_cocina WHERE id_estilo='$this->id_estilo'");
            $foto = $foto->fetch();

            if ($foto['foto_estilo'] == "") {
                return 'default.png';
            } else {
                return $foto['foto_estilo'];
            }
            
        }

        /**
         * Get the value of nombre_estilo
         */ 
        public function getNombre_estilo()
        {
                return $this->nombre_estilo;
        }

        /**
         * Set the value of nombre_estilo
         *
         * @return  self
         */ 
        public function setNombre_estilo($nombre_estilo)
        {
                $this->nombre_estilo = $nombre_estilo;

                return $this;
        }

        /**
         * Get the value of foto_estilo
         */ 
        public function getFoto_estilo()
        {
                return $this->foto_estilo;
        }

        /**
         * Set the value of foto_estilo
         *
         * @return  self
         */ 
        public function setFoto_estilo($foto_estilo)
        {
                $this->foto_estilo = $foto_estilo;

                return $this;
        }

        /**
         * Get the value of id_estilo
         */ 
        public function getId_estilo()
        {
                return $this->id_estilo;
        }

        /**
         * Set the value of id_estilo
         *
         * @return  self
         */ 
        public function setId_estilo($id_estilo)
        {
                $this->id_estilo = $id_estilo;

                return $this;
        }
    }