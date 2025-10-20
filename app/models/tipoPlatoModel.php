<?php
    namespace app\models;
    /* Define namespaces. El lugar donde está almacenado el modelo */

    class tipoPlatoModel extends mainModel {
        public $id_tipo, $nombre_tipo, $foto_tipo;

        function __construct($id_tipo){
            $this->id_tipo = $id_tipo;
            $this->nombre_tipo = $this->checkNombre();
            $this->foto_tipo = $this->checkFoto();
        }

        function checkNombre(){
            $nombre = $this->ejecutarConsulta("SELECT * FROM tipos_plato WHERE id_tipo='$this->id_tipo'");
            $nombre = $nombre->fetch();

            return $nombre['nombre_tipo'];
        }

        function checkFoto(){
            $foto = $this->ejecutarConsulta("SELECT * FROM tipos_plato WHERE id_tipo='$this->id_tipo'");
            $foto = $foto->fetch();

            if ($foto['foto_tipo'] == "") {
                return 'default.png';
            } else {
                return $foto['foto_tipo'];
            }
            
        }
        
        

        /**
         * Get the value of id_tipo
         */ 
        public function getId_tipo()
        {
                return $this->id_tipo;
        }

        /**
         * Set the value of id_tipo
         *
         * @return  self
         */ 
        public function setId_tipo($id_tipo)
        {
                $this->id_tipo = $id_tipo;

                return $this;
        }

        /**
         * Get the value of nombre_tipo
         */ 
        public function getNombre_tipo()
        {
                return $this->nombre_tipo;
        }

        /**
         * Set the value of nombre_tipo
         *
         * @return  self
         */ 
        public function setNombre_tipo($nombre_tipo)
        {
                $this->nombre_tipo = $nombre_tipo;

                return $this;
        }

        /**
         * Get the value of foto_tipo
         */ 
        public function getFoto_tipo()
        {
                return $this->foto_tipo;
        }

        /**
         * Set the value of foto_tipo
         *
         * @return  self
         */ 
        public function setFoto_tipo($foto_tipo)
        {
                $this->foto_tipo = $foto_tipo;

                return $this;
        }
    }
    