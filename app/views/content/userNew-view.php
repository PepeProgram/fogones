<?php
    /* Comprueba si la url viene de registrarse o añadir usuario para poner el título de la página */
    if (!isset($url[1])) {
        $titulo = "Registrarse";
    } else {
        $titulo = "Añadir usuario";
    }
    
?>

<header class="tituloPagina">
    <h1><?php echo $titulo; ?></h1>
    <?php include "./app/views/inc/btn_back.php"; ?>
</header>
<div class="ancho borderBottom tituloPeque">
    Todos los campos marcados con * son obligatorios
</div>
<section id="datosUsuario">
    <form action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" class="FormularioAjax" method="POST" autocomplete="off" enctype="multipart/form-data" name="¿Quiere guardar sus datos?">

        <input type="hidden" name="modulo_usuario" value="registrar">

        <div class="columns">
            <div class="column">
                <label class="labelForm" for="nombre_usuario">Nombre:*</label>
                <input id="nombre_usuario" class="input" type="text" name="nombre_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" required title="Entre 3 y 40 caracteres. Solo admite letras y números">
            </div>
            <div class="column">
                <label class="labelForm" for="ap1_usuario">Primer apellido:*</label>
                <input id="ap1_usuario" class="input" type="text" name="ap1_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" required title="Entre 3 y 40 caracteres. Solo admite letras y números">
            </div>
            <div class="column">
                <label class="labelForm" for="ap2_usuario">Segundo apellido:</label>
                <input id="ap2_usuario" class="input" type="text" name="ap2_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" title="Entre 3 y 40 caracteres. Solo admite letras y números">
            </div>
            <div class="column">
                <label class="labelForm" for="login_usuario">Nombre de Usuario:*</label>
                <input id="login_usuario" class="input" type="text" name="login_usuario" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}" required title="Entre 3 y 40 caracteres sin espacios. Solo admite letras y números">
            </div>
            <div class="column">
                <label class="labelForm" for="clave_1_usuario">Contraseña:*</label>
                <input id="clave_1_usuario" class="input  inputPas" type="password" name="clave_1_usuario" pattern="(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required title="8 caracteres, al menos una mayúscula, una minúscula, un número y un símbolo.">
                <button type="button" title="Ver contraseña" class="fa-regular fa-eye verPass" onclick="verPass(this);"></button>
            </div>
            <div class="column">
                <label class="labelForm" for="clave_2_usuario">Repetir Contraseña:*</label>
                <input id="clave_2_usuario" class="input inputPas" type="password" name="clave_2_usuario" pattern="(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required title="8 caracteres, al menos una mayúscula, una minúscula, un número y un símbolo.">
                <button type="button" title="Ver contraseña" class="fa-regular fa-eye verPass" onclick="verPass(this);"></button>
            </div>
            <div class="column">
                <label class="labelForm" for="email_usuario">Correo electrónico:*</label>
                <input id="email_usuario" class="input" type="email" name="email_usuario" required title="Introduzca una dirección de correo electrónico válida">
            </div>
            <div class="column">
                <label for="foto_usuario" class="labelFile">Seleccione su foto:
                    <span class="notas">jpg, jpeg, png. (max. 5Mb)</span>
                </label>
                <button type="button" id="btnFile" class="btnFile" onclick="document.querySelector('#foto_usuario').click()">Seleccionar Foto</button>
                <button type="button" class="fa-solid fa-xmark verPass" onclick="quitarFoto();" title="Quitar archivo">
                <input id="foto_usuario" class="file-input" type="file" name="foto_usuario" accept=".jpg, .png, .jpeg" onchange="ponerNombreArchivo();">
            </div>
        </div>
        <div class="descripcion">
            <label class="labelForm" for="sobre_usuario">Sobre mí:</label>
            <textarea id="sobre_usuario" class="inputText" name="sobre_usuario" maxlength="250" rows="5" title="Breve descripción del usuario. Máximo 250 caracteres"></textarea>
        </div>
        <div class="botones">
            <button class="btn" type="reset" onclick="limpiarFormulario();">Limpiar</button>
            <button class="btn" type="submit">Guardar</button>
        </div>
    </form>
</section>