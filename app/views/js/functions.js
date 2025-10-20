/* Despliega el menú de hamburguesa */
function menuHamburguesa(menu){
    var x = document.getElementById(menu);
    if(x.className === menu){
        x.className += " responsive";
    } else {
        x.className = menu;
    }
}

/* Muestra el texto de la contraseña */
function verPass(ojo){
    let input = ojo.previousElementSibling; 
    let tipo = ojo.previousElementSibling.getAttribute('type');
    if (tipo == "password") {
        input.setAttribute("type", "text");
        ojo.classList.remove("fa-eye");
        ojo.classList.add("fa-eye-slash");
    } else {
        input.setAttribute("type", "password");
        ojo.classList.remove("fa-eye-slash");
        ojo.classList.add("fa-eye");
    }
}

/* Activa los botones para editar los alérgenos */
function activarBotonesAlergenos(boton){
    let id = boton.id.split("-")[1];
    let botones = document.querySelectorAll('.desactivar');
    if (!document.querySelector('#nombreAlergeno-'+id).hasAttribute('disabled')) {
        location.reload();
        
    } else {
        botones.forEach(boton => {
            if (boton.id == "guardarCambios-"+id || boton.id == "cambiarIconoAlergeno-"+id) {
                boton.removeAttribute('disabled');
                document.querySelector('#nombreAlergeno-'+boton.id.split("-")[1]).removeAttribute('disabled');
                document.querySelector('#nombreAlergeno-'+boton.id.split("-")[1]).focus();
            }
            else{
                boton.setAttribute('disabled', true);
                document.querySelector('#nombreAlergeno-'+boton.id.split("-")[1]).setAttribute('disabled', true);
            }
        });
    }
}


/* Pone el nombre del archivo en el input file cuando se elige un archivo */
function ponerNombreArchivo(){
    let nombre = document.querySelector('#foto_usuario').value;
    nombre = nombre.split("\\");
    document.querySelector('#btnFile').innerHTML = nombre.at(-1);
}

/* Muestra la previsualización de la foto que se selecciona */
function previewImage(entrada, idIcono, iconoDefecto){
    const icono = document.querySelector('#'+idIcono);
    if (entrada.files[0]) {
        if (entrada.files[0].type != "image/jpeg" && entrada.files[0].type != "image/png") {
            textoAlerta = {
                tipo: 'simple',
                icono: 'error',
                titulo: 'Error en la imagen',
                texto: 'Debe seleccionar un archivo .jpg, .png o .jpeg',
                confirmButtonText: 'Aceptar',
                colorIcono: 'red'};
            ventanaModal(textoAlerta);
            icono.src = iconoDefecto;
            entrada.value = "";
        }
        else{
            const reader = new FileReader();
            reader.onload = function(e){
                icono.src = e.target.result;
            }
            reader.readAsDataURL(entrada.files[0]);
        }
    }
}

/* Elimina la foto del input */
function quitarFoto(){
    document.querySelector('#foto_usuario').value = "";
    document.querySelector('#btnFile').innerHTML = "Seleccionar Archivo";
}

/* Limpia el botón de un formulario que lleve foto */
function limpiarFormulario(){
    document.querySelector('#btnFile').innerHTML = "Seleccionar Archivo";
}

/* Filtra una tabla por lo que se introduce en el input */
function filtrarTablas(input, tabla){
    var input, filter, table, tr, td, i, txtValue;

    /* Trae el input de la búsqueda */
    input = document.getElementById(input);

    /* Convierte el texto del input a mayúsculas */
    filter = input.value.toUpperCase();

    /* Trae el body de la tabla a filtrar. OJO: la variable tabla es el id del tbody, no el de la tabla.  */
    table = document.getElementById(tabla);

    /* Trae las filas del body de la tabla */
    tr = table.querySelectorAll('tr');

    /* Recorre cada fila de la tabla */
    for (let i = 0; i < tr.length; i++) {

        /* Trae las celdas de cada fila */
        td = tr[i].getElementsByTagName('td');

        /* Oculta la fila actual */
        tr[i].style.display = "none";

        /* Comprueba si la fila actual tiene celdas */
        if (td) {

            /* Recorre las celdas de la fila actual */
            for (let j = 0; j < td.length; j++) {

                /* Extrae el texto de la celda actual */
                txtValue = td[j].textContent || td[j].innerText;

                /* Si el texto de la celda actual en mayúsculas contiene el texto del input, muestra la fila actual */
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                }
            }
        }
    }
}

function activarFormulario(modulo, idContainer, accion, datosActualizar){
        
    /* Enseña el formulario solicitado */
    document.querySelector('#'+idContainer).classList.toggle('oculto');

    /* Obtiene el formulario solicitado completo */
    let form = document.querySelector('#'+idContainer+' > form');

    /* Establece en el formulario el nombre del módulo */
    document.querySelector('#accionForm').name = modulo;

    /* Establece en el formulario la acción a realizar (guardar, actualizar, etc.) */
    document.querySelector('#accionForm').value = accion;

    /* Verifica la acción a realizar */
    switch (accion) {
        case 'guardar':
            /* Cambia el nombre para mostrarlo en la ventana de sweetAlert2 */
            form.name='¿Añadir nuevo?'
            break;
        case 'actualizar':
            /* Cambia el name para mostrarlo en la ventana de sweetAlert2 */
            form.name='¿Actualizar Datos?'

            /* Verifica el formulario del que viene */
            switch (modulo) {
                case 'modulo_autor':
                    
                    /* Rellena los datos del formulario con los del autor a actualizar */
                    document.querySelector('#idForm').value = datosActualizar.id_autor;
                    document.querySelector('#nombreAutor').value = datosActualizar.nombre_autor;
                    if (datosActualizar.id_pais) {
                        document.querySelector('.opcion-'+datosActualizar.id_pais).setAttribute('selected', true);
                    }
                    document.querySelector('#descripcionAutor').value = datosActualizar.descripcion_autor;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/autor_photos/"+datosActualizar.foto_autor;
                    
                    break;
                
                case 'modulo_grupo':
                    
                    /* Rellena los datos del formulario con los del grupo a actualizar */
                    document.querySelector('#idForm').value = datosActualizar.id_grupo;
                    document.querySelector('#nombreGrupo').value = datosActualizar.nombre_grupo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/groups_photos/"+datosActualizar.foto_grupo;

                    break;
                    
                case 'modulo_tipo':
                    
                    /* Rellena los datos del formulario con los del tipo a actualizar */
                    document.querySelector('#idForm').value = datosActualizar.id_tipo;
                    document.querySelector('#nombreTipo').value = datosActualizar.nombre_tipo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/tipos_photos/"+datosActualizar.foto_tipo;

                    break;
                    
                default:
                    let textoAlerta = {
                        tipo: 'recargar',
                        icono: 'error',
                        titulo: 'ERROR',
                        texto: 'Se ha producido un error inesperado. Presione aceptar para continuar',
                        confirmButtonText: 'Aceptar',
                        colorIcono: 'red'};
        
                    ventanaModal(textoAlerta);
            }

            break;

        default:
            let textoAlerta = {
                tipo: 'recargar',
                icono: 'error',
                titulo: 'ERROR',
                texto: 'Se ha producido un error inesperado. Presione aceptar para continuar',
                confirmButtonText: 'Aceptar',
                colorIcono: 'red'};

            ventanaModal(textoAlerta);

    }
}

/* Desactiva un formulario en pantalla */
function desactivarFormulario(idContainer){
    window.location.reload();
    
}
