<?php
    namespace app\models;
    /* Define namespaces. El lugar donde está almacenado el modelo */

    class grupoPlatoModel extends mainModel{
        public $id_grupo, $nombre_grupo, $foto_grupo;

        function __construct($id_grupo){
            $this->id_grupo = $id_grupo;
            $this->nombre_grupo = $this->checkNombre();
            $this->foto_grupo = $this->checkFoto();
        }

        private function checkNombre(){
            $nombre = $this->ejecutarConsulta("SELECT * FROM grupos_plato WHERE id_grupo='$this->id_grupo'");
            $nombre = $nombre->fetch();

            return $nombre['nombre_grupo'];

        }

        private function checkFoto(){
            $foto = $this->ejecutarConsulta("SELECT * FROM grupos_plato WHERE id_grupo='$this->id_grupo'");
            $foto = $foto->fetch();

            if ($foto['foto_grupo'] == "") {
                return 'default.png';
            } else {
                return $foto['foto_grupo'];
            }
            
        }

        /**
         * Get the value of nombre_grupo
         */ 
        public function getNombre_grupo()
        {
                return $this->nombre_grupo;
        }

        /**
         * Set the value of nombre_grupo
         *
         * @return  self
         */ 
        public function setNombre_grupo($nombre_grupo)
        {
                $this->nombre_grupo = $nombre_grupo;

                return $this;
        }

        /**
         * Get the value of foto_grupo
         */ 
        public function getFoto_grupo()
        {
                return $this->foto_grupo;
        }

        /**
         * Set the value of foto_grupo
         *
         * @return  self
         */ 
        public function setFoto_grupo($foto_grupo)
        {
                $this->foto_grupo = $foto_grupo;

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
    }