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

/* Limpia elementos accesorios de un formulario, como el botón de un formulario que lleve foto y otros elementos */
function limpiarFormulario(){

    /* Comprueba si existe el botón para subir archivos */
    let botonFoto = document.querySelector('#btnFile');
    if (botonFoto != null) {
        document.querySelector('#btnFile').innerHTML = "Seleccionar Archivo";
    }

    /* Comprueba si hay listas de ingredientes o utensilios */
    let listaIngred = document.querySelector("#listaIngredientesEnviarReceta");
    if (listaIngred != null) {
        listaIngred.innerHTML = "";        
    }
    let listaUtens = document.querySelector("#listaUtensiliosEnviarReceta");
    if (listaUtens != null) {
        listaUtens.innerHTML = "";        
    }
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

    /* Comprueba si viene del módulo receta */
    if (modulo == 'subform_modulo_receta') {
        $accionForm = '#accionForm_'+idContainer;
        $idForm = '#idForm_'+idContainer;
    } else {
        $accionForm = '#accionForm';
        $idForm = '#idForm'
    }

    /* Establece en el formulario el nombre del módulo */
    document.querySelector($accionForm).name = modulo;

    /* Establece en el formulario la acción a realizar (guardar, actualizar, etc.) */
    document.querySelector($accionForm).value = accion;

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
                    document.querySelector($idForm).value = datosActualizar.id_autor;
                    document.querySelector('#nombreAutor').value = datosActualizar.nombre_autor;
                    if (datosActualizar.id_pais) {
                        document.querySelector('.opcion-'+datosActualizar.id_pais).setAttribute('selected', true);
                    }
                    document.querySelector('#descripcionAutor').value = datosActualizar.descripcion_autor;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/autor_photos/"+datosActualizar.foto_autor;
                    
                    break;
                
                case 'modulo_estilo':
                    
                    /* Rellena los datos del formulario con los del estilo a actualizar */
                    document.querySelector($idForm).value = datosActualizar.id_estilo;
                    document.querySelector('#nombreEstilo').value = datosActualizar.nombre_estilo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/styles_photos/"+datosActualizar.foto_estilo;

                    break;
                    
                case 'modulo_grupo':
                    
                    /* Rellena los datos del formulario con los del grupo a actualizar */
                    document.querySelector($idForm).value = datosActualizar.id_grupo;
                    document.querySelector('#nombreGrupo').value = datosActualizar.nombre_grupo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/groups_photos/"+datosActualizar.foto_grupo;

                    break;
                    
                case 'modulo_tipo':
                    
                    /* Rellena los datos del formulario con los del tipo a actualizar */
                    document.querySelector($idForm).value = datosActualizar.id_tipo;
                    document.querySelector('#nombreTipo').value = datosActualizar.nombre_tipo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/tipos_photos/"+datosActualizar.foto_tipo;

                    break;

                case 'modulo_metodo':
                    
                    /* Rellena los datos del formulario con los del método de cocción a actualizar */
                    document.querySelector($idForm).value = datosActualizar.id_metodo;
                    document.querySelector('#nombreMetodo').value = datosActualizar.nombre_metodo;
                    document.querySelector('.fotoautor > img').src = APP_URL+"app/views/photos/metodos_photos/"+datosActualizar.foto_metodo;

                    break;
                    
                case 'modulo_utensilio':
                    
                    /* Rellena los datos del formulario con los del utensilio a actualizar */
                    document.querySelector($idForm).value = datosActualizar.id_utensilio;
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
                            form.name = "Agregar " + this.options[this.selectedIndex].text + " a " + datosActualizar.nombre_ingrediente;
                        });

                    }
                    else{
                        /* Rellena los datos del formulario con los del ingrediente a actualizar */
                        document.querySelector($idForm).value = datosActualizar.id_ingrediente;
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
    document.querySelector('#'+idContainer).querySelector('form').reset();
    document.querySelector('#'+idContainer).classList.add('oculto');
}

/* Agrega un elemento recién guardado a un select y su lista asociada */
function nuevoElementoEnLista(idSelect, idLista, idElemento, nombreElemento, idArrayElementos){
    
    /* Recupera el select de los elementos */
    let selectElementos = document.querySelector('#'+idSelect);

    /* Recupera la lista de clases que tienen las options del primer elemento que está oculto */
    let claseOptions = selectElementos.querySelector('option').classList.toString();

    /* Quita el oculto de la lista de clases */
    claseOptions = claseOptions.toString().split(' ');
    claseOptions.pop();

    /* Crea la option para añadir al select */
    let option = document.createElement('option');

    /* Añade la clase de la option */
    option.setAttribute('class', claseOptions);

    /* Añade el value a la option */
    option.setAttribute('value', idElemento);

    /* Selecciona la opción */
    option.setAttribute('selected', '');

    /* Añade el texto a la option */
    option.innerText = nombreElemento;

    /* Añade la option al select */
    selectElementos.appendChild(option);

    /* Añade el elemento a la lista */
    agregarElementoLista('', idSelect, idLista, idArrayElementos);


}

/* Recibe una option seleccionada de un select y añade un input con sus datos a una lista */
function agregarElementoLista(evento, idCampoSelect, idLista, idArray){

    /* Comprueba si llamo a la función desde el botón seleccionar elemento o desde añadir un elemento nuevo */
    if (evento != '') {
        /* Anula la acción del botón */
        evento.preventDefault();
    }

    const array = idArray;
    
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
            button.setAttribute('onclick', 'quitarElementoLista(this, event, '+array+');');
            
            /* Añade el button a la linea */
            linea.appendChild(button);
            
            /* Comprueba si el elemento es un ingrediente */
            if (idLista == 'listaIngredientesEnviarReceta') {
                
                /* Crea input para la cantidad */
                input_cantidad = document.createElement('input');
                input_cantidad.setAttribute('type', 'number');
                input_cantidad.setAttribute('name', 'cant['+id_elemento+']');
                input_cantidad.setAttribute('id', 'cant-'+id_elemento);
                input_cantidad.setAttribute('class', 'inputCantidad col-20 static');
                input_cantidad.setAttribute('step', '0.01');
                input_cantidad.setAttribute('min', '0.01');
                input_cantidad.setAttribute('placeholder', 'cant.');
                input_cantidad.setAttribute('title', 'Cantidad de '+texto_elemento);
                
                /* Añade el input a la linea */
                linea.appendChild(input_cantidad);
                
                /* Crea el input para las unidades */
                input_unidad = document.createElement('select');
                input_unidad.setAttribute('name', 'unid['+id_elemento+']');
                input_unidad.setAttribute('id', 'unid-'+id_elemento);
                input_unidad.setAttribute('class', 'inputUnidad col-20 static');
                input_unidad.setAttribute('title', 'Seleccione unidad de medida para '+texto_elemento);
                
                /* Establece las options con las unidades. Las acaba de rellenar al final */
                
                select0 = document.createElement('option');
                select0.setAttribute('value', 0);
                select0.append('un./med.');
                select0.setAttribute('class', 'unaCualquiera oculto');
                select0.setAttribute('selected', '');
                input_unidad.append(select0);
                
                /* Añade el select a la linea */
                linea.appendChild(input_unidad);
                
            }
            
            /* Crea el texto de la linea */
            let texto_linea = document.createElement('span');
            texto_linea.append(' '+texto_elemento);
            
            /* Añade el texto a la linea */
            linea.appendChild(texto_linea);
            
            /* Añade la linea a la lista */
            lista.appendChild(linea);
            
            /* Rellena el select de las unidades con las unidades de medida */
            if (idLista == 'listaIngredientesEnviarReceta') {
                rellenarSelect('', 'unid-'+id_elemento, 'unidades_medida', '');
            }

            /* Elimina la selección del select tras haber añadido un elemento a la lista */
            campoSelect.selectedIndex = -1;
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
function quitarElementoLista(linea, evento, array){
    evento.preventDefault();

    /* Recupera el id del elemento */
    id_elemento = linea.parentNode.id.split('-')[1];

    /* Convierte el input de los elementos a array */
    array_elementos = array.value.split(',');

    /* Busca el index del elemento en el array */
    indexElement = array_elementos.indexOf(id_elemento);

    /* Elimina el elemento del array */
    array_elementos.splice(indexElement, 1);

    /* Devuelve al input el array con el elemento borrado */
    array.value = array_elementos;

    /* Elimina la línea de la lista de elementos */
    linea.parentNode.remove();
}
