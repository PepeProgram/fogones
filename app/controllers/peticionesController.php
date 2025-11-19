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
                case 'zonas':
                    $id = 'id_zona';
                    $nombre = 'nombre_zona';
                    break;
                case 'paises':
                    $id = 'id_pais';
                    $nombre = 'esp_pais';
                    break;
                case 'regiones':
                    $id = 'id_region';
                    $nombre = 'nombre_region';
                    break;
                case 'unidades_medida';
                    $id = 'id_unidad';
                    $nombre = 'nombre_unidad';
                    break;
                case 'estilos_cocina':
                    $id = 'id_estilo';
                    $nombre = 'nombre_estilo';
                    break;
                case 'tipos_plato':
                    $id = 'id_tipo';
                    $nombre = 'nombre_tipo';
                    break;
                case 'grupos_plato':
                    $id = 'id_grupo';
                    $nombre = 'nombre_grupo';
                    break;
                case 'tecnicas':
                    $id = 'id_tecnica';
                    $nombre = 'nombre_tecnica';
                    break;
                case 'ingredientes':
                    $id = 'id_ingrediente';
                    $nombre = 'nombre_ingrediente';
                    break;
                case 'utensilios':
                    $id = 'id_utensilio';
                    $nombre = 'nombre_utensilio';
                    break;

                default:
                    $nombre = 'nombre_'.substr($tabla, 0, -1);
                    break;
            }

            /* Construye la búsqueda dependiendo si el id seleccionado está vacío o tiene un id */
            if ($idElemento == "") {
                $busqueda = "SELECT * FROM $tabla WHERE $id != 0 ORDER BY $nombre";
            } elseif ($idElemento == 'activable') {
                $busqueda = "SELECT * FROM $tabla WHERE activo != 0 AND $id != 0 ORDER BY $nombre";
            } else {
                $busqueda = "SELECT * FROM $tabla WHERE $campo=$idElemento AND $id != 0 ORDER BY $nombre";
            }

            /* Ejecuta a búsqueda de elementos */
            $elementos = $this->ejecutarConsulta($busqueda);
            $elementos = $elementos->fetchAll();

            echo json_encode($elementos);
        }

        /* OBTENER ELEMENTOS DE UN ARRAY */
        public function obtenerElementosControlador(){

            /* Obtiene la tabla en la que hay que buscar */
            $tabla = $this->limpiarCadena($_POST['tabla']);

            /* Establece el campo por el que hay que buscar */
            switch ($tabla) {
                case 'estilos_cocina':
                    $campo = 'id_estilo';
                    $nombre = 'nombre_estilo';
                    $foto = 'foto_estilo';
                    break;
                
                case 'grupos_plato':
                    $campo = 'id_grupo';
                    $nombre = 'nombre_grupo';
                    $foto = 'foto_grupo';
                    break;
                
                case 'tipos_plato':
                    $campo = 'id_tipo';
                    $nombre = 'nombre_tipo';
                    $foto = 'foto_tipo';
                    break;
                
                case 'tecnicas':
                    $campo = 'id_tecnica';
                    $nombre = 'nombre_tecnica';
                    $foto = 'foto_tecnica';
                    break;
                
                default:
                    # code...
                    break;
            }

            /* Obtiene el id de la etiqueta a buscar */
            $idEtiqueta = $_POST['id'];

            /* Construye la búsqueda */
            $busqueda = "SELECT $campo, $nombre, $foto FROM $tabla WHERE $campo = $idEtiqueta";

            /* Ejecuta la búsqueda */
            $etiqueta = $this->ejecutarConsulta($busqueda);
            $etiqueta = $etiqueta->fetch();

            /* Devuelve los datos de la etiqueta */
            return json_encode($etiqueta);
        }
    }