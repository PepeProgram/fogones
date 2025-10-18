<?php
    namespace app\models;
    /* Define namespaces. El lugar donde se encuentra almacenado el modelo */

    class userModel extends mainModel{
        private $id_usuario, $nombre_usuario, $ap1_usuario, $ap2_usuario, $login_usuario, $clave_usuario, $email_usuario, $sobre_usuario, $foto_usuario, $creado_usuario, $actualizado_usuario, $redactor, $revisor, $administrador;

        function __construct($id_usuario, $nombre_usuario, $ap1_usuario, $ap2_usuario, $login_usuario, $clave_usuario, $email_usuario, $sobre_usuario, $foto_usuario, $creado_usuario, $actualizado_usuario){
            $this->id_usuario = $id_usuario;
            $this->nombre_usuario = $nombre_usuario;
            $this->ap1_usuario = $ap1_usuario;
            $this->ap2_usuario = $ap2_usuario;
            $this->login_usuario = $login_usuario;
            $this->clave_usuario = $clave_usuario;
            $this->email_usuario = $email_usuario;
            $this->sobre_usuario = $sobre_usuario;
            $this->foto_usuario = $foto_usuario;
            $this->creado_usuario = $creado_usuario;
            $this->actualizado_usuario = $actualizado_usuario;
            $this->redactor = $this->checkRedactor();
            $this->administrador = $this->checkAdmin();
            $this->revisor = $this->checkRevisor();
        }

        
        private function checkRedactor(){
                if ($this->ejecutarConsulta("SELECT * FROM redactores WHERE id_usuario = '$this->id_usuario'")->rowCount()>0) {
                        return true;
                } else {
                        return false;
                }
        }

        private function checkRevisor(){
                if ($this->ejecutarConsulta("SELECT * FROM revisores WHERE id_usuario = '$this->id_usuario'")->rowCount()>0) {
                        return true;
                } else {
                        return false;
                }
        }

        private function checkAdmin(){
                if ($this->ejecutarConsulta("SELECT * FROM administradores WHERE id_usuario = '$this->id_usuario'")->rowCount()>0) {
                        return true;
                } else {
                        return false;
                }
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
         * Get the value of nombre_usuario
         */ 
        public function getNombre_usuario()
        {
                return $this->nombre_usuario;
        }

        /**
         * Set the value of nombre_usuario
         *
         * @return  self
         */ 
        public function setNombre_usuario($nombre_usuario)
        {
                $this->nombre_usuario = $nombre_usuario;

                return $this;
        }

        /**
         * Get the value of ap1_usuario
         */ 
        public function getAp1_usuario()
        {
                return $this->ap1_usuario;
        }

        /**
         * Set the value of ap1_usuario
         *
         * @return  self
         */ 
        public function setAp1_usuario($ap1_usuario)
        {
                $this->ap1_usuario = $ap1_usuario;

                return $this;
        }

        /**
         * Get the value of ap2_usuario
         */ 
        public function getAp2_usuario()
        {
                return $this->ap2_usuario;
        }

        /**
         * Set the value of ap2_usuario
         *
         * @return  self
         */ 
        public function setAp2_usuario($ap2_usuario)
        {
                $this->ap2_usuario = $ap2_usuario;

                return $this;
        }

        /**
         * Get the value of login_usuario
         */ 
        public function getLogin_usuario()
        {
                return $this->login_usuario;
        }

        /**
         * Set the value of login_usuario
         *
         * @return  self
         */ 
        public function setLogin_usuario($login_usuario)
        {
                $this->login_usuario = $login_usuario;

                return $this;
        }

        /**
         * Get the value of clave_usuario
         */ 
        public function getClave_usuario()
        {
                return $this->clave_usuario;
        }

        /**
         * Set the value of clave_usuario
         *
         * @return  self
         */ 
        public function setClave_usuario($clave_usuario)
        {
                $this->clave_usuario = $clave_usuario;

                return $this;
        }

        /**
         * Get the value of email_usuario
         */ 
        public function getEmail_usuario()
        {
                return $this->email_usuario;
        }

        /**
         * Set the value of email_usuario
         *
         * @return  self
         */ 
        public function setEmail_usuario($email_usuario)
        {
                $this->email_usuario = $email_usuario;

                return $this;
        }

        /**
         * Get the value of foto_usuario
         */ 
        public function getFoto_usuario()
        {
                return $this->foto_usuario;
        }

        /**
         * Set the value of foto_usuario
         *
         * @return  self
         */ 
        public function setFoto_usuario($foto_usuario)
        {
                $this->foto_usuario = $foto_usuario;

                return $this;
        }

        /**
         * Get the value of creado_usuario
         */ 
        public function getCreado_usuario()
        {
                return $this->creado_usuario;
        }

        /**
         * Set the value of creado_usuario
         *
         * @return  self
         */ 
        public function setCreado_usuario($creado_usuario)
        {
                $this->creado_usuario = $creado_usuario;

                return $this;
        }

        /**
         * Get the value of actualizado_usuario
         */ 
        public function getActualizado_usuario()
        {
                return $this->actualizado_usuario;
        }

        /**
         * Set the value of actualizado_usuario
         *
         * @return  self
         */ 
        public function setActualizado_usuario($actualizado_usuario)
        {
                $this->actualizado_usuario = $actualizado_usuario;

                return $this;
        }

        /**
         * Get the value of redactor
         */ 
        public function getRedactor()
        {
                return $this->redactor;
        }

        /**
         * Set the value of redactor
         *
         * @return  self
         */ 
        public function setRedactor($redactor)
        {
                $this->redactor = $redactor;

                return $this;
        }

        /**
         * Get the value of revisor
         */ 
        public function getRevisor()
        {
                return $this->revisor;
        }

        /**
         * Set the value of redactor
         *
         * @return  self
         */ 
        public function setRevisor($revisor)
        {
                $this->revisor = $revisor;

                return $this;
        }

        /**
         * Get the value of administrador
         */ 
        public function getAdministrador()
        {
                return $this->administrador;
        }

        /**
         * Set the value of administrador
         *
         * @return  self
         */ 
        public function setAdministrador($administrador)
        {
                $this->administrador = $administrador;

                return $this;
        }

        /**
         * Get the value of sobre_usuario
         */ 
        public function getSobre_usuario()
        {
                return $this->sobre_usuario;
        }

        /**
         * Set the value of sobre_usuario
         *
         * @return  self
         */ 
        public function setSobre_usuario($sobre_usuario)
        {
                $this->sobre_usuario = $sobre_usuario;

                return $this;
        }
    }
