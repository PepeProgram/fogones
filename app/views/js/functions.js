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


/* Activa un formulario en pantalla */
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
                
                case 'modulo_estilo':
                    
                    /* Rellena los datos del formulario con los del estilo a actualizar */
                    document.querySelector('#idForm').value = datosActualizar.id_estilo;
                    document.querySelector('#nombreEstilo').value = datosActualizar.nombre_estilo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/styles_photos/"+datosActualizar.foto_estilo;

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

                case 'modulo_metodo':
                    
                    /* Rellena los datos del formulario con los del método de cocción a actualizar */
                    document.querySelector('#idForm').value = datosActualizar.id_metodo;
                    document.querySelector('#nombreMetodo').value = datosActualizar.nombre_metodo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/metodos_photos/"+datosActualizar.foto_metodo;

                    break;
                    
                case 'modulo_utensilio':
                    
                    /* Rellena los datos del formulario con los del utensilio a actualizar */
                    document.querySelector('#idForm').value = datosActualizar.id_utensilio;
                    document.querySelector('#nombreUtensilio').value = datosActualizar.nombre_utensilio;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/utensilios_photos/"+datosActualizar.foto_utensilio;

                    break;
                    
                case 'modulo_ingrediente':

                    /* Comprueba si estoy actualizando datos o agregando alérgenos */
                    if (form.alergenos) {

                        /* Establece el nombre del módulo y el id del ingrediente porque al haber dos formularios ocultos, hay dos id diferentes */
                        
                        form.accionFormAgregar.name = modulo;
                        form.accionFormAgregar.value = accion;
                        form.idFormAgregar.value = datosActualizar.id_ingrediente;

                        /* Detecta cuándo cambia la opción seleccionada para cambiar el nombre del formulario y ponerlo en la ventana emergente */
                        form.alergeno.addEventListener("change", function(){
                            console.log(this.options[this.selectedIndex].text);
                            form.name = "Agregar " + this.options[this.selectedIndex].text + " a " + datosActualizar.nombre_ingrediente;
                        });

                    }
                    else{
                        /* Rellena los datos del formulario con los del ingrediente a actualizar */
                        document.querySelector('#idForm').value = datosActualizar.id_ingrediente;
                        document.querySelector('#nombreIngrediente').value = datosActualizar.nombre_ingrediente;
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

/* Oculta un formulario en pantalla sin recargar la página */
function ocultarFormulario(idContainer){
    document.querySelector('#'+idContainer).classList.add('oculto');
    document.querySelector('#'+idContainer).querySelector('form').reset();
}

/* Recibe una option seleccionada de un select y añade un input con sus datos a una lista */
function agregarElementoLista(evento, idCampoSelect, idLista, idArray){

    /* Anula la acción del botón */
    evento.preventDefault();
    
    /* Recupera la lista donde hay que agregar elementos */
    let lista = document.querySelector('#'+idLista);

    /* Recupera el campo para agregar los id de los elementos */
    idArray = document.querySelector('#'+idArray);
    
    
    /* Recupera el select con el elemento */
    let campoSelect = document.querySelector('#' + idCampoSelect);
    
    /* Solo se ejecuta si hay algo seleccionado */
    if (campoSelect.options.selectedIndex != -1) {

        /* Id del elemento a agregar */
        let id_elemento = campoSelect.value;

        /* Recupera los elementos que están en la lista */
        let elementos_lista = lista.childNodes;

        /* Crea un array con los id de los elementos que ya están en la lista */
        let id_elementos_lista = [];
        
        for (let i = 1; i < elementos_lista.length; i++) {
            id_elementos_lista.push(elementos_lista[i].id.split('-')[1])
        }
        
        /* Texto del elemento a agregar */
        let texto_elemento = campoSelect.options[campoSelect.options.selectedIndex].text;

        /* Comprueba que el elemento no esté ya en la lista */
        if (!id_elementos_lista.includes(id_elemento)) {

            /* Añade el id del elemento al array de elementos */
            id_elementos_lista.push(id_elemento);

            /* Guarda los elementos en el input */
            idArray.value = id_elementos_lista.toString();

            /* Crea la linea de la lista */
            let linea = document.createElement("li");
            linea.setAttribute('id', 'lu-'+id_elemento);
    
            /* Crea el button para eliminar el elemento de la lista */
            let button = document.createElement('button');
            button.setAttribute('class', 'fa-solid fa-square-xmark btnIcon userDel');
            button.setAttribute('title', 'Eliminar '+texto_elemento+' de la lista');
            button.setAttribute('onclick', 'quitarElementoLista(this, event);');
    
            /* Añade el button a la linea */
            linea.appendChild(button);

            /* Crea el texto de la linea */
            let texto_linea = document.createElement('span');
            texto_linea.append(' '+texto_elemento);

            /* Añade el texto a la linea */
            linea.appendChild(texto_linea);
    
            /* Añade la linea a la lista */
            lista.appendChild(linea);

            console.log(idArray.value);
            
        }
        else{
            textoAlerta = {
                tipo: 'simple',
                icono: 'error',
                titulo: 'Elemento repetido',
                texto: texto_elemento+' ya está en la lista',
                confirmButtonText: 'Aceptar',
                colorIcono: 'red'};
            ventanaModal(textoAlerta);
    
        }

    }
    
}

/* Elimina una linea de una lista */
function quitarElementoLista(linea, evento){
    evento.preventDefault();
    linea.parentNode.remove();
}
