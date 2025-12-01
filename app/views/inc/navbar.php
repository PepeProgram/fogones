<div class="supnavWrapper">

    <nav class="supnav" id="supnav">
        <div class="logoMenu">
            <a href="<?php echo APP_URL; ?>principal" class="">
                <img class="bannerPequeClaro" src="<?php echo APP_URL ?>app/views/img/BannerPequeClaro.png" alt="Página principal">
            </a>
        </div>
        <?php 
        /* Comprueba si hay sesión iniciada */
        if (isset($_SESSION['id'])) {        
        
            ?>
        <div class="opcionMenu" onclick="toggleMenu();">
            <button id="btnMenu" class="btnMenu">
                <div class="divFotoNav">
                    <figure class="foto">
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
        </div>
        
        <?php } else{ ?>
            <div class="opcionMenu">
                <a href="<?php echo APP_URL; ?>login">Entrar</a>
            </div>
            <div class="opcionMenu">
                <a href="<?php echo APP_URL; ?>userNew">Registrarse</a>
            </div>
            <?php } ?>
            
            
            
    </nav>
    
    <!-- Menú de usuario según el rol -->
    <?php if (isset($_SESSION['id'])) { ?>
        <div id="subMenuSupNav" class="subMenuSupNav oculto">


            <a href="<?php echo APP_URL."userData/".$_SESSION['id'] ?>">Mis datos</a>
            <a href="<?php echo APP_URL; ?>recetasFavoritas">Mis recetas favoritas</a>
            <?php
                /* Comprueba si es redactor */
                if ($_SESSION['redactor']) {
            ?>
                <a href="<?php echo APP_URL; ?>misRecetas">Mis recetas</a>
                <a href="<?php echo APP_URL; ?>recetaData">Enviar receta</a>
            <?php
                }
            ?>
            <?php
                /* Comprueba si es revisor */
                if ($_SESSION['revisor']) {
            ?>
                <a href="<?php echo APP_URL; ?>paraRevisar">Para revisar</a>
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
    <?php }  ?>
</div>