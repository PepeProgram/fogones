<?php
    namespace app\models;
    /* Importa la clase PDO de php. Es necesario importarla para realizar la conexion con la base de datos al estar usando namespaces */
    use \PDO;

    /* Verifica si existe el archivo de configuración de la base de datos y si existe, lo incluye */
    if (file_exists(__DIR__."/../../config/server.php")) {
        require_once __DIR__."/../../config/server.php";
    }

/* Modelo principal de la aplicación
Contiene funciones que vamos a utilizar más de una vez
*/

    /* Definición de la clase mainModel */
    class mainModel{

        /* Recoge las constantes definidas en el archivo server.php */
        private $server = DB_SERVER;
        private $db = DB_NAME;
        private $user = DB_USER;
        private $pass = DB_PASS;

        /* Conexión a la base de datos.
        Protected para que la puedan usar las clases que heredan */
        protected function conectar(){
            /* la clase PDO  */
            $conexion = new PDO("mysql:host=".$this->server.";dbname=".$this->db,$this->user,$this->pass);
            /* Ejecuta la conexión a la base de datos utilizando caracteres utf8 */
            $conexion->exec("SET CHARACTER SET utf8");
            /* Devuelve la conexión */
            return $conexion;
        }

        /* Realiza consultas a la base de datos 
        recibe como parámetro la consulta a efectuar */
        protected function ejecutarConsulta($consulta){
            /* Prepara la consulta utilizando el método prepare de PDO */
            $sql = $this->conectar()->prepare($consulta);

            /* Ejecuta la consulta */
            $sql->execute();

            /* Devuelve el resultado de la consulta */
            return $sql;
        }

        /* Evita SQL Injection */
        public function limpiarCadena($cadena){
            /* Crea array con los textos o palabras a limpiar de la cadena recibida */
            $palabras=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--", "^","<",">","==","=",";","::"];
            
            /* Elimina espacios en blanco al inicio y al final de la cadena */
            $cadena = trim($cadena);

            /* Elimina las barras de escape ("\") de la cadena recibida */
            $cadena = stripslashes($cadena);

            /* Recorre el array de palabras para eliminarlas de la cadena */
            foreach($palabras as $palabra){
                /* str_ireplace() busca y reemplaza strings dentro de un string.
                No importa mayúsculas-minúsculas. Es como str_replace() pero Case-insensitive */
                $cadena = str_ireplace($palabra, "", $cadena);
            }

            /* Repite la eliminación de espacios en blanco y barras por si acaso */
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);

            /* Devuelve la cadena limpia */
            return $cadena;
        }

        /* Verifica que lo recibido del formulario coincide con el patrón de expresiones permitidas (expresiones regulares) que definimos en los formularios */
        protected function verificarDatos($filtro, $cadena){
            /* preg_match realiza una comparación con una expresión regular */
            if (preg_match("/^".$filtro."$/", $cadena)) {
                return false; 
            } else {
                return true; 
            }
            
        }

    /* MODELOS QUE PERMITEN EL CRUD */
        
        /* Modelo para guardar datos en cualquier tabla.
            Recibe el nombre de la tabla y un array de datos para guardar
            Utiliza consultas preparadas para ello.
        */
        /* La variable $datos es un array de arrays de la siguiente forma:
            $datos = [
                [
                    "campo_nombre"=>"usuario_nombre",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                [
                    "campo_nombre"=>"usuario_apellido",
                    "campo_marcador"=>":Apellido",
                    "campo_valor"=>$apellido
                ],
                [
                    "campo_nombre"=>"usuario_email",
                    "campo_marcador"=>":Email",
                    "campo_valor"=>$email
                ],
                etc.
            ];

            Se mantienen las claves y se les asigna un marcador y un valor a cada una.
            */
        protected function guardarDatos($tabla, $datos){
            $query = "INSERT INTO $tabla (";

            $C = 0;
            /* Va rellenando la query con los nombres, marcadores y valores del array $datos */
            foreach ($datos as $clave) {
                /* Antepone una coma antes del nombre del campo si no es el primero */
                if ($C>=1) {
                    $query .= ",";
                }
                /* Añade el nombre el campo */
                $query .= $clave["campo_nombre"];
                $C ++;
            }

            /* Ahora concatena el nexo de la consulta */
            $query .= ") VALUES (";

            /* Concatena los marcadores de cada campo igual que en los nombres */
            $C = 0;
            foreach ($datos as $clave) {
                /* Antepone una coma al valor del campo si no es el primero */
                if ($C>=1) {
                    $query .= ",";
                }
                /* Añade el nombre el campo */
                $query .= $clave["campo_marcador"];
                $C ++;
            }

            /* Concatena el final de la línea de la consulta */
            $query .= ")";

            /* Prepara la consulta */
            $sql = $this->conectar()->prepare($query);

            /* Sustituye los marcadores por sus valores */
            foreach ($datos as $clave) {
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }

            /* Ejecuta la consulta */
            $sql->execute();

            /* Devuelve el resultado de la inserción */
            return $sql;
        }

        /* Modelo para realizar SELECTS */
        public function seleccionarDatos($tipo, $tabla, $campo, $id){
            /* Limpiar los parámetros para evitar SQL Injection */
            $tipo = $this->limpiarCadena($tipo);
            $tabla = $this->limpiarCadena($tabla);
            $campo = $this->limpiarCadena($campo);
            $id = $this->limpiarCadena($id);

            /* Si el tipo es "Unico preparamos la consulta con un solo campo" */
            if ($tipo == "Unico") {
                /* Establece la consulta con su marcador */
                $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
                /* Sustituye el marcador por lo que viene en $id */
                $sql->bindParam(":ID", $id);
            /* Si el tipo es "Normal" realizamos la consulta con varios campos */
            } elseif($tipo == "Normal") {
                $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
            }
            
            /* Ejecuta la consulta */
            $sql->execute();
            return $sql;
        }

        /* Modelo para ACTUALIZAR datos */
        /* La variable $datos es un array de arrays de la siguiente forma:
            $datos = [
                [
                    "campo_nombre"=>"usuario_nombre",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                [
                    "campo_nombre"=>"usuario_apellido",
                    "campo_marcador"=>":Apellido",
                    "campo_valor"=>$apellido
                ],
                [
                    "campo_nombre"=>"usuario_email",
                    "campo_marcador"=>":Email",
                    "campo_valor"=>$email
                ],
                etc.
            ]; 
        */
        /* La variable $condicion es un array de la siguiente forma:
            $condicion = [
                "condicion_campo"=>"nombre_campo",
                "condicion_marcador"=>":Campo",
                "condicion_valor"=>$valor
            ]    
        */
        protected function actualizarDatos($tabla, $datos, $condicion){
            $query = "UPDATE $tabla SET ";

            $C = 0;
            foreach ($datos as $clave) {

                /* Añade una coma al valor del campo si no es el primero */
                if ($C>=1) {
                    $query .=",";
                }
                /* Añade el nombre el campo y el marcador que sustituiremos después con el valor */
                $query .= $clave["campo_nombre"]."=".$clave["campo_marcador"];
                $C ++;
            }

            /* Añade la condición */
            $query .= " WHERE ". $condicion["condicion_campo"]."=".$condicion["condicion_marcador"];

            $sql = $this->conectar()->prepare($query);

            /* Sustituye los marcadores por sus valores */
            foreach ($datos as $clave) {
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }

            /* Sustituye el marcador del valor por el marcador */
            $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

            /* Ejecuta la consulta */
            $sql->execute();

            /* Devuelve el resultado de la inserción */
            return $sql;

        }

        /* Modelo para ELIMINAR datos */
        protected function eliminarRegistro($tabla, $campo, $id){
            $sql = $this->conectar()->prepare("DELETE FROM $tabla WHERE $campo = :ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();

            return $sql;
        }

        /* Modelo para buscar las recetas que contengan un texto */
        public function buscarRecetasGlobal($texto, $idTipo = null){

            $texto = $this->limpiarCadena($texto);
            $pdo = $this->conectar();
            $resultados = [];

            // Subconsulta EXISTS para filtrar por tipo si $idTipo existe
            $existsClause = "";
            if ($idTipo !== null) {
                $existsClause = " AND EXISTS (
                    SELECT 1 FROM recetas_tiposplato rt
                    WHERE rt.id_receta = r.id_receta
                    AND rt.id_tipo = :idTipo
                )";
            }

            // Array con las consultas por tabla, ahora con r.activo = 1
            $queries = [

                // 1. Tabla recetas (texto directo en receta) → FULLTEXT
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND (r.nombre_receta LIKE CONCAT('%', :texto, '%') OR r.descripcion_receta LIKE CONCAT('%', :texto, '%') OR r.elaboracion LIKE CONCAT('%', :texto, '%')OR r.emplatado LIKE CONCAT('%', :texto, '%'))"
                . $existsClause,  

                // 2. Tipos de plato → LIKE
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND EXISTS (
                    SELECT 1
                    FROM recetas_tiposplato rt
                    JOIN tipos_plato tp ON tp.id_tipo = rt.id_tipo
                    WHERE rt.id_receta = r.id_receta
                        AND tp.nombre_tipo LIKE CONCAT('%', :texto, '%')
                )"
                . $existsClause,

                // 3. Grupos de plato → LIKE
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND EXISTS (
                    SELECT 1
                    FROM grupos_plato gp
                    WHERE gp.id_grupo = r.id_grupo
                        AND gp.nombre_grupo LIKE CONCAT('%', :texto, '%')
                )"
                . $existsClause,

                // 4. Estilos → LIKE
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND EXISTS (
                    SELECT 1
                    FROM recetas_estilos re
                    JOIN estilos_cocina e ON e.id_estilo = re.id_estilo
                    WHERE re.id_receta = r.id_receta
                        AND e.nombre_estilo LIKE CONCAT('%', :texto, '%')
                )"
                . $existsClause,

                // 5. Ingredientes → LIKE
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND EXISTS (
                    SELECT 1
                    FROM recetas_ingredientes ri
                    JOIN ingredientes i ON i.id_ingrediente = ri.id_ingrediente
                    WHERE ri.id_receta = r.id_receta
                        AND i.nombre_ingrediente LIKE CONCAT('%', :texto, '%')
                )"
                . $existsClause,

                // 6. Zonas → LIKE
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND EXISTS (
                    SELECT 1
                    FROM zonas z
                    WHERE z.id_zona = r.id_zona
                        AND z.nombre_zona LIKE CONCAT('%', :texto, '%')
                )"
                . $existsClause,

                // 7. Regiones → LIKE
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND EXISTS (
                    SELECT 1
                    FROM regiones rg
                    WHERE rg.id_region = r.id_region
                        AND rg.nombre_region LIKE CONCAT('%', :texto, '%')
                )"
                . $existsClause,

                // 8. Países → LIKE
                "SELECT r.id_receta
                FROM recetas r
                WHERE r.activo = 1
                AND EXISTS (
                    SELECT 1
                    FROM paises p
                    WHERE p.id_pais = r.id_pais
                        AND p.esp_pais LIKE CONCAT('%', :texto, '%')
                )"
                . $existsClause
            ];



            // Ejecutar cada consulta y combinar resultados sin duplicados
            foreach ($queries as $query) {
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':texto', $texto);

                if ($idTipo !== null) {
                    $stmt->bindValue(':idTipo', (int)$idTipo, PDO::PARAM_INT);
                }

                $stmt->execute();
                $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($ids as $id) {
                    $resultados[(int)$id] = true; // usar claves para evitar duplicados
                }
            }

            return array_keys($resultados); // IDs únicos de recetas
        }


    }