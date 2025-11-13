<?php
    namespace app\models;
    /* Define namespaces. El lugar donde se encuentra almacenado el modelo */

    /* IMPORTANTE: El nombre de la clase debe ser el mismo nombre del archivo, para que el autoload pueda cargar la clase.
    Cuando queramos usar la clase utilizaremos use app\.... */

    class viewsModel{
        protected function obtenerVistasModelo($vista){
            /* Array que contiene todas las vistas que se van a permitir en la URL*/
            $listaBlanca = ["principal", "aperitivos", "primerosPlatos", "segundosPlatos", "postres", "guarniciones", "desayunos", "complementos", "buscarRecetas", "userNew", "login", "logout"];

            /* Comprueba si hay sesión iniciada para permitir las vistas del menú de usuario */
            if (isset($_SESSION['id']) && isset($_SESSION['nombre']) && isset($_SESSION['apellido1']) && isset($_SESSION['apellido2']) && isset($_SESSION['login']) && isset($_SESSION['foto'])) {
                array_push($listaBlanca, "userData", "recetasFavoritas");

                /* Comprueba si el usuario es redactor para permitir las vistas de redactor */
                if ($_SESSION['redactor']) {
                    array_push($listaBlanca, "misRecetas", "recetaData", "recetaUpdate");
                }
                
                /* Comprueba si el usuario es revisor para permitir las vistas de revisor */
                if ($_SESSION['revisor']) {
                    array_push($listaBlanca, "paraRevisar");
                }

                /* Comprueba si el usuario es administrador para permitir el acceso al panel de control */
                if ($_SESSION['administrador']) {
                    array_push($listaBlanca, "panelControl", "usuarios", "recetas", "estilosCocina", "gruposPlatos", "tiposPlatos", "metodos", "utensilios", "ingredientes", "alergenos");
                }
            }

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