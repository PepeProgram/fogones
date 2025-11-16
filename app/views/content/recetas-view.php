<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";

    /* Carga el controlador de recetas */
    use app\controllers\recetaController;

    /* Crea una instancia del controlador de recetas para listarlas */
    $buscaRecetas = new recetaController();

    /* Ejecuta la selección para listar las recetas */
    $recetas = $buscaRecetas->listarRecetasControlador();


?>
<section name="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Recetas</h2>
    </header>
    <form name="Buscar Usuarios" action="" class="filtrarTablas">
        <label for="busquedaUsuarios">Buscar Receta</label>
        <input name="busquedaUsuarios" id="busquedaUsuarios" type="text" class="input" onkeyup="/* filtrarTablas(this.id, 'userList'); */">
    </form>
    <div class="botonesLista total">
        <a href=<?php echo APP_URL."recetaData/" ?>>
            <button class="btn">Añadir Receta</button>
        </a>

        <!-- Comprueba si hay recetas pendientes de revisión -->
        <?php 
            $recetasPendientes = new recetaController();
            if ($recetasPendientes->revisarRecetasControlador()) {
                $ocultar = "";
            }
            else{
                $ocultar = "oculto";
            }
        ?>

            <!-- Botón para ver las recetas pendientes de revisión -->
        <a href=<?php echo APP_URL."recetas/paraRevisar/" ?> class="<?php echo $ocultar ?>">
            <button class="btn btnAlerta">Pendientes de Revisión!!!</button>
        </a>
    </div>
    <div id="listaRecetas" class="listaRecetasContainer col-50 total vertical">
        <div id="listaRecetasCabecera" class="listaRecetasCabecera col-100 total horizontal static">
            <div class="fotoListaRecetas col-20 static">Foto</div>
            <div class="col-60">Nombre Receta</div>
            <div class="col-20 static centrar">Opc.</div>
            <div class="col-10 static centrar">Act.</div>
        </div>
        <div class="listaRecetasFila col-100 medio horizontal static">
            <div class="fotoListaRecetas foto col-20 medio static">
                <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/Aguacates_202511130751164383.jpg' ?>" alt="">
            </div>
            <div class="col-60 medio ">
                Aguacates Con Gambas
            </div>
            <div class="opcionesRecetas col-20 medio static">
                <button class="fa-regular fa-pen-to-square btnOpcionesRecetas"></button>
                <button class="fa-solid fa-square-xmark userDel btnOpcionesRecetas"></button>
            </div>
            <div class="opcionesRecetas col-10 medio static">
                <button class="fa-regular fa-square-check btnOpcionesRecetas"></button>
            </div>

        </div>
        <div class="listaRecetasFila col-100 medio horizontal static">
            <div class="fotoListaRecetas foto col-20 medio static">
                <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/Aguacates_202511130751164383.jpg' ?>" alt="">
            </div>
            <div class="col-60 medio ">
                Aguacates Con Gambas
            </div>
            <div class="opcionesRecetas col-20 medio static">
                <button class="fa-regular fa-pen-to-square btnOpcionesRecetas"></button>
                <button class="fa-solid fa-square-xmark userDel btnOpcionesRecetas"></button>
            </div>
            <div class="opcionesRecetas col-10 medio static">
                <button class="fa-regular fa-square-check btnOpcionesRecetas"></button>
            </div>

        </div>
        <div class="listaRecetasFila col-100 medio horizontal static">
            <div class="fotoListaRecetas foto col-20 medio static">
                <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/Aguacates_202511130751164383.jpg' ?>" alt="">
            </div>
            <div class="col-60 medio ">
                Aguacates Con Gambas
            </div>
            <div class="opcionesRecetas col-20 medio static">
                <button class="fa-regular fa-pen-to-square btnOpcionesRecetas"></button>
                <button class="fa-solid fa-square-xmark userDel btnOpcionesRecetas"></button>
            </div>
            <div class="opcionesRecetas col-10 medio static">
                <button class="fa-regular fa-square-check btnOpcionesRecetas"></button>
            </div>

        </div>
        <div class="listaRecetasFila col-100 medio horizontal static">
            <div class="fotoListaRecetas foto col-20 medio static">
                <img src="<?php echo APP_URL.'app/views/photos/recetas_photos/Aguacates_202511130751164383.jpg' ?>" alt="">
            </div>
            <div class="col-60 medio ">
                Aguacates Con Gambas
            </div>
            <div class="opcionesRecetas col-20 medio static">
                <button class="fa-regular fa-pen-to-square btnOpcionesRecetas"></button>
                <button class="fa-solid fa-square-xmark userDel btnOpcionesRecetas"></button>
            </div>
            <div class="opcionesRecetas col-10 medio static">
                <button class="fa-regular fa-square-check btnOpcionesRecetas"></button>
            </div>

        </div>
    </div>
</section>