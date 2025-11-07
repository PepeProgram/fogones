<?php
    namespace app\controllers;

    /* Trae el modelo principal para utilizar sus funciones */
    use app\models\mainModel;

    /* Crea la clase hija del mainModel */
    class peticionesController extends mainModel{
        
        /* LISTAR LOS ELEMENTOS */
        public function listarElementosControlador(){

            /* Obtiene la tabla en la que hay que buscar */
            $tabla = $this->limpiarCadena($_POST['tabla']);

            /* Establece el campo por el que hay que buscar */
            $campo = $this->limpiarCadena($_POST['campo']);
            
            /* Obtiene el id del elemento a buscar */
            $idElemento = $this->limpiarCadena($_POST['id']);

            /* Construye el nombre del campo nombre según el nombre de la tabla */
            switch ($tabla) {
                case 'paises':
                    $nombre = 'esp_pais';
                    break;
                case 'regiones':
                    $nombre = 'nombre_region';
                    break;
                case 'unidades_medida';
                    $nombre = 'nombre_unidad';
                    break;
                case 'estilos_cocina':
                    $nombre = 'nombre_estilo';
                    break;
                case 'tipos_plato':
                    $nombre = 'nombre_tipo';
                    break;
                case 'grupos_plato':
                    $nombre = 'nombre_grupo';
                    break;
                case 'tecnicas':
                    $nombre = 'nombre_tecnica';
                    break;

                default:
                    $nombre = 'nombre_'.substr($tabla, 0, -1);
                    break;
            }

            /* Construye la búsqueda dependiendo si el id seleccionado está vacío o tiene un id */
            if ($idElemento == "") {
                $busqueda = "SELECT * FROM $tabla ORDER BY $nombre";
            } elseif ($idElemento == 'activable') {
                $busqueda = "SELECT * FROM $tabla WHERE activo != 0 ORDER BY $nombre";
            } else {
                $busqueda = "SELECT * FROM $tabla WHERE $campo=$idElemento ORDER BY $nombre";
            }

            /* Ejecuta a búsqueda de elementos */
            $elementos = $this->ejecutarConsulta($busqueda);
            $elementos = $elementos->fetchAll();

            echo json_encode($elementos);
        }
    }