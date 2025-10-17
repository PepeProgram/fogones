<nav class="topnav" id="topnav">
    <a href="<?php echo APP_URL; ?>principal" class="active">
        <i class="fa-solid fa-house" aria-label="Página de Inicio"></i>
        Inicio
    </a>
    <a href="<?php echo APP_URL; ?>aperitivos">Aperitivos</a>
    <a href="<?php echo APP_URL; ?>primerosPlatos">Primeros Platos</a>
    <a href="<?php echo APP_URL; ?>segundosPlatos">Segundos Platos</a>
    <a href="<?php echo APP_URL; ?>postres">Postres</a>
    <a href="<?php echo APP_URL; ?>salsas">Salsas</a>
    <a href="<?php echo APP_URL; ?>complementos">Complementos</a>
    <a href="<?php echo APP_URL; ?>buscarRecetas">Buscar Recetas</a>

    <?php 
        /* Comprueba si hay sesión iniciada */
        if (isset($_SESSION['id'])) {        
        
    ?>
        <div class="dropdown">
            <button class="dropbtn">
                <div class="divFotoNav">
                    <figure>
                        <?php 
                            if (is_file("./app/views/photos/user_photos/".$_SESSION["foto"])) {
                                echo '
                                    <img alt="Foto Usuario" class="fotoNav" src="'.APP_URL.'app/views/photos/user_photos/'.$_SESSION['foto'].'">
                                ';
                            } else {
                                echo '
                                    <img alt="Usuario sin foto" class="fotoNav" src="'.APP_URL.'app/views/photos/user_photos/default.png">
                                ';
                            }
                            
                        ?>
                    </figure>
                </div>
                <?php echo $_SESSION['login']; ?>
                <i class="fa-solid fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="<?php echo APP_URL."userData/".$_SESSION['id'] ?>">Mis datos</a>
                <a href="<?php echo APP_URL; ?>recetasFavoritas">Mis recetas favoritas</a>
                <?php
                    /* Comprueba si es redactor */
                    if ($_SESSION['redactor']) {
                ?>
                    <a href="<?php echo APP_URL; ?>misRecetas">Mis recetas</a>
                    <a href="<?php echo APP_URL; ?>enviarReceta">Enviar receta</a>
                <?php
                    }
                ?>
                <?php
                    /* Comprueba si es administrador */
                    if ($_SESSION['administrador']) {
                ?>
                    <a href="<?php echo APP_URL; ?>panelControl">Panel de Control</a>
                <?php
                    }
                ?>
                <a id="btn_exit" href="<?php echo APP_URL; ?>logout">Salir</a>
            </div>
        </div>
        

    <?php } else{ ?>
        <div class="dropdown">
            <a href="<?php echo APP_URL; ?>login">Entrar</a>
        </div>
        <div class="dropdown">
            <a href="<?php echo APP_URL; ?>userNew">Registrarse</a>
        </div>
    <?php } ?>
    <a class="icon" onclick="menuHamburguesa('topnav');">
        <i class="fa-solid fa-bars" aria-label="Desplegar Menú"></i>
    </a>
</nav>