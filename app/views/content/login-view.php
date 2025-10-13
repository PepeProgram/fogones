<section name="contenido">
    <header class="tituloPagina">
        <h1>Identificarse</h1>
    </header>
    <form class="formLogin" action="" method="POST" autocomplete="off">
        <input type="hidden" name="modulo_usuario" value="entrar">
        <div class="column">
            <label for="login_usuario" class="labelForm">Nombre de Usuario</label>
            <input id="login_usuario" class="input"  type="text" name="login_usuario" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" title="Entre 3 y 40 caracteres. Solo admite letras y números">
        </div>
        <div class="column">
            <label for="login_clave" class="labelForm">Contraseña</label>
            <input id="login_clave" class="input inputPas" type="password" name="login_clave" required pattern="(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="8 caracteres, al menos una mayúscula, una minúscula, un número y un símbolo.">
            <button type="button" title="Ver contraseña" class="fa-regular fa-eye verPass" onclick="verPass(this);">
        </div>
        <div class="botones">
            <button class="btn" type="submit">Entrar</button>
        </div>
    </form>
</section>
<?php
    if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
        $insLogin->iniciarSesionControlador();
    }
?>