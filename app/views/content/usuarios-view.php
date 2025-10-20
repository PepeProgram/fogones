<?php 
    /* Carga el título y la barra de navegación del panel de control */
    require_once "app/views/inc/headerControl.php";
?>
<section id="contenido">
    <header class="tituloPagina">
        <h2>Gestionar Usuarios</h2>
    </header>
    <div class="contentControl">
        <form name="Buscar Usuarios" action="" class="filtrarTablas">
            <label for="busquedaUsuarios">Buscar Usuario</label>
            <input name="busquedaUsuarios" id="busquedaUsuarios" type="text" class="input" onkeyup="filtrarTablas(this.id, 'userList');">
        </form>
        <div class="botonesLista">
            <a href=<?php echo APP_URL."usuarios/" ?>>
                <button class="btn">Todos</button>
            </a>
            <a href=<?php echo APP_URL."usuarios/redactores/" ?>>
                <button class="btn">Redactores</button>
            </a>
            <a href=<?php echo APP_URL."usuarios/revisores/" ?>>
                <button class="btn">Revisores</button>
            </a>
            <a href=<?php echo APP_URL."usuarios/administradores/" ?>>
                <button class="btn">Administradores</button>
            </a>
            <a href="<?php echo APP_URL; ?>userNew/add">
                <button class="btn" title="Añadir usuario" aria-label="Añadir usuario">
                    <i class="fa-solid fa-user-plus"></i>
                    <span class="oculto">Añadir</span>
                </button>
            </a>
        </div>
        <div class="listaUsuarios">
            <table id="tablaUsuarios" class="userList">
                <thead>
                    <?php
                        /* Carga el controlador de usuario */
                        use app\controllers\userController;

                        /* Crea una instancia del controlador */
                        $listaUsuarios = new userController();

                        /* Llama al método del controlador para obtener los usuarios */
                        $listaUsuarios = $listaUsuarios->listarUsuariosControlador();
                    ?>
                    <tr class="headerUserList">
                        <th>Nombre</th>
                        <th>Login</th>
                        <th class="userMail">e-mail</th>
                        <th class="userOptions" colspan="5">Opciones</th>
                    </tr>
                </thead>
                <tbody id="userList">
                    <?php

                        /* Recorre la lista de usuarios para insertar cada usuario en una fila de la tabla */
                        foreach ($listaUsuarios as $usuario) {
                            
                            /* Comprueba si el usuario es redactor */
                            if ($usuario->getRedactor()) {
                                $colorRedactor = "green";
                                $tituloRedactor = "Eliminar de redactores a ";
                            } else {
                                $colorRedactor = "grey";
                                $tituloRedactor = "Agregar a redactores a ";
                            }

                            /* Comprueba si el usuario es revisor */
                            if ($usuario->getRevisor()) {
                                $colorRevisor = "green";
                                $tituloRevisor = "Eliminar de revisores a ";
                            } else {
                                $colorRevisor = "grey";
                                $tituloRevisor = "Agregar a revisores a ";
                            }
                            
                            /* Comprueba si el usuario es Administrador */
                            if ($usuario->getAdministrador()) {
                                $colorAdministrador = "green";
                                $tituloAdministrador = "Eliminar de administradores a ";
                            } else {
                                $colorAdministrador = "grey";
                                $tituloAdministrador = "Agregar a administradores a ";
                            }

                            /* Crea el html para ir concatenando los datos e ir insertándolo después en la página */
                            $html = '
                                <tr class="userUserList" id="'.$usuario->getId_usuario().'">
                                    <td>'.$usuario->getNombre_usuario().' '.$usuario->getAp1_usuario().' '.$usuario->getAp2_usuario().'</td>
                                    <td>'.$usuario->getLogin_usuario().'</td>
                                    <td class="userMail">'.$usuario->getEmail_usuario().'</td>
                                    <td class="userData userLink">
                                        <a href="'.APP_URL.'userData/'.$usuario->getId_usuario().'"><i class="fa-regular fa-eye" aria-label="Ver o editar datos de '.$usuario->getLogin_usuario().'" title="Ver o editar datos de '.$usuario->getLogin_usuario().'"></i><span class="oculto">Ver</span></a>
                                    </td>
                                    <td class="userRedactor userLink" >
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" name="'.$tituloRedactor.$usuario->getLogin_usuario().'?">
                                            <input type="hidden" name="modulo_usuario" value="cambiarRedactor">
                                            <input type="hidden" name="id_usuario" value="'.$usuario->getId_usuario().'">

                                            <button type="submit" class="userDel btnIcon" aria-label="'.$tituloRedactor.$usuario->getLogin_usuario().'" title="'.$tituloRedactor.$usuario->getLogin_usuario().'" style="color:'.$colorRedactor.'">
                                                <i class="fa-solid fa-user-pen"></i>
                                            </button> 
                                        </form>
                                    </td>
                                    <td class="userRedactor userLink" >
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" name="'.$tituloRevisor.$usuario->getLogin_usuario().'?">
                                            <input type="hidden" name="modulo_usuario" value="cambiarRevisor">
                                            <input type="hidden" name="id_usuario" value="'.$usuario->getId_usuario().'">

                                            <button type="submit" class="userDel btnIcon" aria-label="'.$tituloRevisor.$usuario->getLogin_usuario().'" title="'.$tituloRevisor.$usuario->getLogin_usuario().'" style="color:'.$colorRevisor.'">
                                                <i class="fa-solid fa-user-graduate"></i>
                                            </button> 
                                        </form>
                                    </td>
                                    <td class="userAdmin userLink">
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" name="'.$tituloAdministrador.$usuario->getLogin_usuario().'?">
                                            <input type="hidden" name="modulo_usuario" value="cambiarAdministrador">
                                            <input type="hidden" name="id_usuario" value="'.$usuario->getId_usuario().'">

                                            <button type="submit" class="userDel btnIcon" aria-label="'.$tituloAdministrador.$usuario->getLogin_usuario().'" title="'.$tituloAdministrador.$usuario->getLogin_usuario().'" style="color:'.$colorAdministrador.'">
                                                <i class="fa-solid fa-user-gear"></i>
                                            </button> 
                                        </form>
                                    </td>
                                    <td class="userDel userLink">
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" name="Eliminar a '.$usuario->getLogin_usuario().'?">
                                            <input type="hidden" name="modulo_usuario" value="eliminar">
                                            <input type="hidden" name="id_usuario" value="'.$usuario->getId_usuario().'">

                                            <button type="submit" class="userDel btnIcon" aria-label="Eliminar a '.$usuario->getLogin_usuario().'" title="Eliminar a '.$usuario->getLogin_usuario().'">
                                                <i class="fa-solid fa-user-xmark"></i>
                                            </button> 
                                        </form>
                                    </td>
                                </tr>';

                            /* Inserta el usuario en la tabla */
                            echo $html;
                        }
                        
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</section>