<?php
    namespace app\models;
    /* Define namespaces. El lugar donde se encuentra almacenado el modelo */

    /* IMPORTANTE: El nombre de la clase debe ser el mismo nombre del archivo, para que el autoload pueda cargar la clase.
    Cuando queramos usar la clase utilizaremos use app\.... */

    class viewsModel{
        protected function obtenerVistasModelo($vista){
            /* Array que contiene todas las vistas que se van a permitir en la URL*/
            $listaBlanca = ["principal", "recetasFaciles", "aperitivos", "primerosPlatos", "segundosPlatos", "postres", "buscarRecetas", "login"];

            /* Comprueba si la vista está en la lista blanca */
            if (in_array($vista, $listaBlanca)) {
                /* Comprueba que efectivamente existe el archivo de la vista */
                if (!is_file("./app/views/content/".$vista."-view.php")) {
                    $vista = "404";
                }
            }
            else{
                $vista = "404";
            }
            return $vista;

        }
    }