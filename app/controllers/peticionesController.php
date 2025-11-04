<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Crea la clase hija del mainModel */
    class peticionesController extends mainModel{
        
        /* LISTAR LOS ELEMENTOS */
        public function listarElementosControlador(){

            /* Obtiene la tabla en la que hay que buscar */
            $tabla = $_POST['tabla'];

            /* Establece el campo por el que hay que buscar */
            $campo = $_POST['campo'];
            
            /* Obtiene el id del elemento a buscar */
            $idElemento = $_POST['id'];

            /* Construye la búsqueda dependiendo si el id seleccionado está vacío o tiene un id */
            if ($idElemento == "") {
                $busqueda = "SELECT * FROM $tabla";
            } else {
                $busqueda = "SELECT * FROM $tabla WHERE $campo=$idElemento";
            }
            

            /* Ejecuta a búsqueda de elementos */
            $elementos = $this->ejecutarConsulta($busqueda);
            $elementos = $elementos->fetchAll();

            echo json_encode($elementos);
        }
    }