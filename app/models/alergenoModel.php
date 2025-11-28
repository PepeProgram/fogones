<?php

namespace app\models;

/* Carga el modelo de ingredientes para poder usarlo */

use JsonSerializable;

/* Define namespaces. El lugar donde se encuentra almacenado el modelo */

class alergenoModel extends mainModel implements JsonSerializable
{
        private $id_alergeno, $nombre_alergeno, $foto_alergeno;

        function __construct($id_alergeno, $nombre_alergeno, $foto_alergeno)
        {
                $this->id_alergeno = $id_alergeno;
                $this->nombre_alergeno = $nombre_alergeno;
                $this->foto_alergeno = $foto_alergeno;
        }

        public function jsonSerialize(): mixed
        {
                return [
                        'id_alergeno' => $this->id_alergeno,
                        'nombre_alergeno' => $this->nombre_alergeno,
                        'foto_alergeno' => $this->foto_alergeno

                ];
        }



        /**
         * Get the value of id_alergeno
         */
        public function getId_alergeno()
        {
                return $this->id_alergeno;
        }

        /**
         * Set the value of id_alergeno
         *
         * @return  self
         */
        public function setId_alergeno($id_alergeno)
        {
                $this->id_alergeno = $id_alergeno;

                return $this;
        }

        /**
         * Get the value of nombre_alergeno
         */
        public function getNombre_alergeno()
        {
                return $this->nombre_alergeno;
        }

        /**
         * Set the value of nombre_alergeno
         *
         * @return  self
         */
        public function setNombre_alergeno($nombre_alergeno)
        {
                $this->nombre_alergeno = $nombre_alergeno;

                return $this;
        }

        /**
         * Get the value of foto_alergeno
         */
        public function getFoto_alergeno()
        {
                return $this->foto_alergeno;
        }

        /**
         * Set the value of foto_alergeno
         *
         * @return  self
         */
        public function setFoto_alergeno($foto_alergeno)
        {
                $this->foto_alergeno = $foto_alergeno;

                return $this;
        }
}
