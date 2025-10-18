<?php
    
    /* Carga la clase usuario para poder crear objetos usuario */
    use app\models\userModel;

    /* Comprueba si hay sesión iniciada */
    if (!(isset($_SESSION['id']) && isset($_SESSION['nombre']) && isset($_SESSION['login']))) {
        echo "
                <script>
                    textoAlerta = {
                        tipo: 'simple',
                        icono: 'error',
                        titulo: 'Usuario sin identificar',
                        texto: 'No tiene privilegios para realizar esta acción',
                        confirmButtonText: 'Aceptar',
                        colorIcono: 'red',
                        url: '".APP_URL."'};
                    ventanaModal(textoAlerta);
                </script>
            ";
    } 
    
    /* Comprueba si la url trae algún id */
    if (!isset($url[1]) || $url[1] == "") {
        echo "
                <script>
                    textoAlerta = {
                        tipo: 'redirigir',
                        icono: 'error',
                        titulo: 'Usuario sin identificar',
                        texto: 'Debe seleccionar algún usuario para ver sus datos',
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
    
    /* Comprobar si viene de la cuenta de usuario o del listado de usuarios */
    if ($id == $_SESSION['id']) {
        $tituloPagina = "Mi cuenta";
    } else if($_SESSION['administrador']) {
        /* Si no viene de la cuenta de usuario, comprueba si es administrador */
        $tituloPagina = "Datos de";
    } else {
        /* Si no viene de la cuenta de usuario ni es administrador, a la puta calle y volver a la página principal */
        echo "
                <script>
                    textoAlerta = {
                        tipo: 'redirigir',
                        icono: 'error',
                        titulo: 'No es usted administrador',
                        texto: 'No tiene privilegios para ver los datos de otros usuarios',
                        confirmButtonText: 'Aceptar',
                        colorIcono: 'red',
                        url: '".APP_URL."'};
                    ventanaModal(textoAlerta);
                </script>
            ";
            exit();
    }

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
    <h1><?php echo $tituloPagina ?></h1>
    <h2 class="cursiva"><?php echo $usuario->getNombre_usuario()." ".$usuario->getAp1_usuario()." ".$usuario->getAp2_usuario(); ?></h2>
    <p><?php echo "Creado el ".strftime('%a. %d de %b. de %Y', strtotime($usuario->getCreado_usuario()))." - Última actualización el ".strftime('%a. %d de %b. de %Y', strtotime($usuario->getActualizado_usuario())) ?></p>
</header>
<section id="fotoUsuario" class="seccionFoto">
    <figure class="fotoUsuario">
        <?php 
        if (is_file("./app/views/photos/user_photos/".$usuario->getFoto_usuario())) {
            echo '
            <img id="imagen_usuario" alt="Foto del Usuario" class="fotoForm" src="'.APP_URL.'app/views/photos/user_photos/'.$usuario->getFoto_usuario().'">
            ';
        } else {
            echo '
            <img id="imagen_usuario" alt="Usuario sin foto" class="fotoForm" src="'.APP_URL.'app/views/photos/user_photos/default.png">
            ';
        }
        ?>
    </figure>
    <form action="<?php echo APP_URL."app/ajax/usuarioAjax.php"; ?>" method="POST" class="FormularioAjax quitar" name="¿Eliminar la foto de Usuario?">

        <input type="hidden" name="modulo_usuario" value="eliminarFoto">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario->getId_usuario(); ?>">

        <div class="botones">
            <?php
                if ($usuario->getFoto_usuario() != "") {
                    echo '<button class="btn btnAlerta">Quitar Foto</button>';
                }
            ?>
        </div>
    </form>
    <form action="<?php echo APP_URL."app/ajax/usuarioAjax.php"; ?>" method="POST" class="FormularioAjax cambiar" enctype="multipart/form-data" name="¿Cambiar la foto de usuario?">

        <input type="hidden" name="modulo_usuario" value="actualizarFoto">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario->getId_usuario(); ?>">

        <div class="btnFoto">
            <label for="foto_usuario" class="labelFile">Seleccione su foto:
                <span class="notas">jpg, jpeg, png. (max. 5Mb)</span>
            </label>
            <button type="button" id="btnFile" class="btnFile" onclick="document.querySelector('#foto_usuario').click()">Seleccionar Archivo</button>
            <button type="button" title="Quitar archivo" class="fa-solid fa-xmark verPass" onclick="quitarFoto();"></button>
            <input id="foto_usuario" class="file-input" type="file" name="foto_usuario" accept=".jpg, .png, .jpeg" onchange="ponerNombreArchivo(); previewImage(this, 'imagen_usuario', '<?php echo APP_URL ?>/app/views/user_photos/default.png');">
        </div>
        <div class="botones">
            <button class="btn">Actualizar Foto</button>
        </div>
    </form>
</section>
<section id="datosUsuario">
    <div class="ancho borderBottom tituloPeque">
        Todos los campos marcados con * son obligatorios
    </div>
    <form action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" class="FormularioAjax" method="POST" autocomplete="off" enctype="multipart/form-data" name="¿Quiere actualizar los datos?">

        <input type="hidden" name="modulo_usuario" value="actualizar">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario->getId_usuario(); ?>">

        <div class="columns">
            <div class="column">
                <label class="labelForm" for="nombre_usuario">Nombre:*</label>
                <input id="nombre_usuario" class="input" type="text" name="nombre_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" required title="Entre 3 y 40 caracteres. Solo admite letras y números" value="<?php echo $usuario->getNombre_usuario(); ?>">
            </div>
            <div class="column">
                <label class="labelForm" for="ap1_usuario">Primer apellido:*</label>
                <input id="ap1_usuario" class="input" type="text" name="ap1_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" required title="Entre 3 y 40 caracteres. Solo admite letras y números" value="<?php echo $usuario->getAp1_usuario(); ?>">
            </div>
            <div class="column">
                <label class="labelForm" for="ap2_usuario">Segundo apellido:</label>
                <input id="ap2_usuario" class="input" type="text" name="ap2_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" title="Entre 3 y 40 caracteres. Solo admite letras y números" value="<?php echo $usuario->getAp2_usuario(); ?>">
            </div>
            <div class="column">
                <label class="labelForm" for="email_usuario">Correo electrónico:*</label>
                <input id="email_usuario" class="input" type="email" name="email_usuario" required title="Introduzca una dirección de correo electrónico válida" value="<?php echo $usuario->getEmail_usuario(); ?>">
            </div>
        </div>
        <div class="descripcion">
            <label class="labelForm" for="sobre_usuario">Sobre mí:</label>
            <textarea id="sobre_usuario" class="inputText" name="sobre_usuario" maxlength="250" rows="5" title="Breve descripción del usuario. Máximo 250 caracteres" ><?php echo $usuario->getSobre_usuario(); ?></textarea>
        </div>
        <div class="ancho centrar borderBottom tituloPeque">Si desea actualizar la clave de este usuario por favor rellene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.</div>
        <div class="columns">    
            <div class="column">
                <label class="labelForm" for="clave_1_usuario">Nueva Contraseña:</label>
                <input id="clave_1_usuario" class="input  inputPas" type="password" name="clave_1_usuario" pattern="(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="8 caracteres, al menos una mayúscula, una minúscula, un número y un símbolo.">
                <button type="button" title="Ver contraseña" class="fa-regular fa-eye verPass" onclick="verPass(this);"></button>
            </div>
            <div class="column">
                <label class="labelForm" for="clave_2_usuario">Repetir Nueva Contraseña:</label>
                <input id="clave_2_usuario" class="input inputPas" type="password" name="clave_2_usuario" pattern="(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="8 caracteres, al menos una mayúscula, una minúscula, un número y un símbolo.">
                <button type="button" title="Ver contraseña" class="fa-regular fa-eye verPass" onclick="verPass(this);"></button>
            </div>
        </div>
        <div class="ancho centrar borderBottom tituloPeque">Para actualizar los datos, introduzca el USUARIO y CLAVE con los que ha iniciado sesión.</div>
        <div class="columns">
            <div class="column">
                <label class="labelForm" for="login_usuario">Nombre de Usuario:*</label>
                <input id="login_usuario" class="input" type="text" name="login_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}" required title="Entre 3 y 40 caracteres sin espacios. Solo admite letras y números">
            </div>
            <div class="column">
                <label class="labelForm" for="login_clave">Contraseña:*</label>
                <input id="login_clave" class="input  inputPas" type="password" name="login_clave" pattern="(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required title="8 caracteres, al menos una mayúscula, una minúscula, un número y un símbolo.">
                <button type="button" title="Ver contraseña" class="fa-regular fa-eye verPass" onclick="verPass(this);"></button>
            </div>
        </div>
        <div class="botones">
            <button class="btn" type="submit">Actualizar Datos</button>
        </div>
    </form>
</section>