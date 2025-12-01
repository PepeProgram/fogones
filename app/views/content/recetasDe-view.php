<?php
/* Carga la clase usuario para poder crear objetos usuario */
    use app\models\userModel;

    /* Comprueba si la url trae algún id */
    if (!isset($url[1]) || $url[1] == "") {
        echo "
                <script>
                    textoAlerta = {
                        tipo: 'redirigir',
                        icono: 'error',
                        titulo: 'Usuario sin identificar',
                        texto: 'Debe seleccionar algún usuario para ver sus recetas',
                        confirmButtonText: 'Aceptar',
                        colorIcono: 'red',
                        url: '".APP_URL."'};
                    ventanaModal(textoAlerta);
                </script>
            ";
            exit();
    }

    /* Obtiene el id de la cuenta que se va a mostrar de la url definida en el index */
    $id = $insLogin->limpiarCadena($url[1]);

    /* Comprueba si el usuario existe */
    $datos = $insLogin->seleccionarDatos('Unico', 'usuarios', 'id_usuario', $id);
    if ($datos->rowCount()<=0) {
        /* Si el usuario no existe, a la puta calle y vuelta a la página principal */
        echo "
                <script>
                    textoAlerta = {
                        tipo: 'redirigir',
                        icono: 'error',
                        titulo: 'Usuario no encontrado',
                        texto: 'El usuario solicitado no existe',
                        confirmButtonText: 'Aceptar',
                        colorIcono: 'red',
                        url: '".APP_URL."'};
                    ventanaModal(textoAlerta);
                </script>
            ";
            exit();
    } else {
        
        /* Convierte a array la respuesta de la consulta */
        $datos = $datos->fetch();

        /* Crea un usuario con todos los datos */
        $usuario = new userModel($datos['id_usuario'], $datos['nombre_usuario'], $datos['ap1_usuario'], $datos['ap2_usuario'], $datos['login_usuario'], $datos['clave_usuario'], $datos['email_usuario'], $datos['sobre_usuario'], $datos['foto_usuario'], $datos['creado_usuario'], $datos['actualizado_usuario']);
    }
?>

<header class="tituloPagina">
    <h1>Recetas de</h1>
    <div id="resumenUsuario" class="resumenUsuario horizontal centrar static">
            <div class='fotoAutorListaRecetas foto col-30'>
                <img src='<?php echo APP_URL; ?>app/views/photos/user_photos/<?php echo $usuario->getFoto_usuario(); ?>' alt='Foto de <?php $usuario->getNombre_usuario(); ?>'>
            </div>
            <div id="datosUsuario" class="datosUsuario vertical col-40 top">
                <h2><?php echo $usuario->getNombre_usuario()." ".$usuario->getAp1_usuario(); ?></h2>
                <p><?php echo $usuario->getSobre_usuario(); ?></p>
            </div>
    </div>
</header>
<!-- Carga el menú de fotos -->
<?php require_once "app/views/inc/menuFotos.php"; ?>

<!-- Carga la lista de recetas -->
<?php require_once "app/views/inc/listaRecetas.php"; ?>
