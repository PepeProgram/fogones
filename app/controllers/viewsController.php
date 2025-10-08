<?php
    namespace app\controllers;

    /* Incluye el modelo de vistas porque hereda de él */
    use app\models\viewsModel;

    /* Crea la clase */
    class viewsController extends viewsModel{
        /* Función pública que controla las vistas del modelo viewsController */
        public function obtenerVistasControlador($vista){
            /* Comprueba que la variable no venga vacía */
            if ($vista != "") {
                /* Envía el valor al modelo y obtiene la dirección URL */
                $respuesta = $this->obtenerVistasModelo($vista);
            } else {
                $respuesta = "principal";
            }
            return $respuesta;
        }
    }