<?php
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

    /* Comprueba si el usuario es administrador, redactor o revisor */
    if (!isset($_SESSION['administrador'])) {

        /* Comprueba si el usuario es redactor */
        if (!isset($_SESSION['redactor'])) {
            # code...
            echo "
            <script>
            textoAlerta = {
                tipo: 'redirigir',
                icono: 'error',
                titulo: 'Acción no permitida',
                texto: 'No puede acceder a esta sección',
                confirmButtonText: 'Aceptar',
                colorIcono: 'red',
                url: '".APP_URL."'};
                ventanaModal(textoAlerta);
                </script>
                ";
                exit();
        }
    }
?>



<header class="tituloPagina">
    <h2>Editar una receta</h2>
    <?php include "./app/views/inc/btn_back.php"; ?>
</header>



