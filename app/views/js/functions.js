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

/* Elimina la foto del input de las recetas y de la preview */
function eliminarFotoReceta(){
    console.log(document.querySelector('#fotoReceta-0').value);
    document.querySelector('#fotoReceta-0').value = "";
    console.log(document.querySelector('#fotoReceta-0').value);
    document.querySelector('#fotoReceta').src = APP_URL+'app/views/photos/recetas_photos/default.png';
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

function filtrarRecetas(input, divRecetas){

    /* Trae el input de búsqueda */
    input = document.querySelector('#'+input);

    /* Convierte el texto del input a mayúsculas */
    filter = input.value.toUpperCase();
    
    /* Trae las tarjetas de las recetas */
    let recetas = document.querySelectorAll('.'+divRecetas);
    
    /* Recorre cada tarjeta de la lista */
    for (let i = 0; i < recetas.length; i++) {
        
        /* Trae los div de cada tarjeta */
        let receta = recetas[i].children;

        /* Oculta la tarjeta actual */
        recetas[i].style.display = "none";

        /* recorre cada div de la tarjeta */
        for (let j = 0; j < receta.length; j++) {
            
            /* Extrae el texto del div actual */
            txtValue = receta[j].textContent;
            
            /* Si el texto del div actual en mayúsculas contiene el texto del input, muestra la tarjeta actual */
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                recetas[i].style.display = "";
            }
            
        }
        
    }

}

/* Busca options en un select */
function filtrarSelect(textoInput, idSelect){
    
    /* Convierte a mayúsculas el texto a buscar */
    textoInput = textoInput.toUpperCase();

    /* Trae las options del select donde hay que buscar */
    const options = document.querySelector('#'+idSelect).options;

    /* Recorre cada option del select */
    for (let i = 1; i < options.length; i++) {
        
        /* Oculta la option actual */
        options[i].style.display = "none";
    
        /* Extrae el texto de la option actual y lo convierte a mayúsculas */
        txtValue = options[i].innerText.toUpperCase();
    
        /* Si el texto de la option actual contiene el texto del input, muestra la option actual */
        if (txtValue.indexOf(textoInput) > -1) {
            options[i].style.display = "";
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
    let container = document.querySelector('#'+idContainer);
    if (container.querySelector('img') != null) {
        container.querySelector('img').src = APP_URL+'app/views/photos/default.png';
    }
    container.querySelector('form').reset();
    container.classList.add('oculto');
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

/* Agrega elementos a la lista en la vista de actualizar recetas */
function agregarElementoListaUpdate(idCampoSelect, idLista, idArray, idElementos){

    /* Recupera el select donde están los elementos */
    selectNodes = document.querySelector('#'+idCampoSelect).options;
    
    /* Recorre los elementos del array */
    idElementos.forEach(elemento => {
    
        if (typeof(elemento['id_ingrediente']) !== 'undefined') {
            elemento[0] = elemento['id_ingrediente'];
        }
        /* Recorre las opciones para ver si el elemento coincide con el value de la opción y seleccionarlo */
        for (let i = 0; i < selectNodes.length; i++) {
            if (selectNodes[i].value == elemento[0]) {
                selectNodes[i].setAttribute('selected', '');
                agregarElementoLista('', idCampoSelect, idLista, idArray, elemento);
                break;
            }
        }    

    });
}

/* Recibe una option seleccionada de un select y añade un input con sus datos a una lista */
async function agregarElementoLista(evento, idCampoSelect, idLista, idArray, elemento){

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

                /* Comprueba si se ha enviado un elemento */
                if (typeof(elemento) !== 'undefined') {
                    /* Comprueba si el elemento trae cantidad y le añade su valor al input cantidad */
                    if ('cantidad' in elemento) {
                        input_cantidad.setAttribute('value', parseFloat(elemento['cantidad']));
                    }
                }

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
                await rellenarSelect('', 'unid-'+id_elemento, 'unidades_medida', '');
            }

            /* Selecciona la unidad del ingrediente en la receta en el select */
            if (typeof(elemento) !== 'undefined') {
                if ('id_unidad' in elemento) {
                    /* Recupera las options del select de unidades */
                    optionsUnidades = document.querySelector('#unid-'+id_elemento).options;

                    /* Recorre las options para seleccionar la del elemento si es la misma */
                    for (let i = 0; i < optionsUnidades.length; i++) {
                        if (optionsUnidades[i].value == elemento['id_unidad']) {
                            optionsUnidades[i].setAttribute('selected', '');
                            break;
                        }
                        
                    }
                }
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

/* Rellena la dificultad de una receta con estrellas */
function rellenarDificultad(elemento, dif){
    let texto = document.querySelector('#'+elemento).innerHTML+" ";
    for (let i = 1; i <= 5; i++) {
        if (i <= dif) {
            texto += '<i class="fa-solid fa-star"></i>';
        } else {
            texto += '<i class="fa-regular fa-star"></i>';
        }
        
    }

    document.querySelector('#'+elemento).innerHTML = texto;

}

/* Aprueba una receta cambiando el estado de activo_receta */
function aprobarReceta(receta, IdsUtensilios, IdsIngredientes){

    /* Aprueba automáticamente los UTENSILIOS de la receta si los hay */
    if (IdsUtensilios != "") {
        
        /* Crea un formulario para enviar al utensilioAjax */
        let formUtensilio = document.createElement('form');
        
        /* Añade el method al formulario */
        formUtensilio.setAttribute('method', 'POST');
        
        
        /* Crea un formdata con el formulario */
        let dataUtensilio = new FormData(formUtensilio);
        
        /* Añade el campo módulo para enviar al utensilioAjax */
        dataUtensilio.append('modulo_utensilio', 'aprobar');
        
        /* Aañade el campo id_utensilio para enviar al controlador */
        dataUtensilio.append('id_utensilio', IdsUtensilios);
        
        /* Crea las cabeceras para enviar la peticion */
        let encabezadosUtensilio = new Headers();
        
        /* Establece el action para enviar */
        let actionUtensilio = APP_URL+'app/ajax/utensilioAjax.php';
    
        /* Configuraciones en formato JSON de los datos de la petición */
        let configUtensilio ={
            "method": "POST",
            "headers": encabezadosUtensilio,
            "mode": "cors",
            "cache": "no-cache",
            "body": dataUtensilio
        };
    
        /* Realiza la petición a la acción del formulario */
        fetch(actionUtensilio, configUtensilio).then(respuesta => {
            return respuesta.json();
        }).then(respuestaJSON=>{
            if (respuestaJSON.length == 0) {
                return true;
            } else {
                return alertas_ajax(respuestaJSON);
            }
        });
    }
    
    /* Aprueba automáticamente los INGREDIENTES de la receta si los hay */
    if (IdsIngredientes != "") {
        
        /* Crea un formulario para enviar al utensilioAjax */
        let formIngrediente = document.createElement('form');
        
        /* Añade el method al formulario */
        formIngrediente.setAttribute('method', 'POST');
        
        /* Crea un formdata con el formulario */
        let dataIngrediente = new FormData(formIngrediente);
        
        /* Añade el campo módulo para enviar al ingredienteAjax */
        dataIngrediente.append('modulo_ingrediente', 'aprobar');
        
        /* Aañade el campo id_ingrediente para enviar al controlador */
        dataIngrediente.append('id_ingrediente', IdsIngredientes);
        
        /* Crea las cabeceras para enviar la peticion */
        let encabezadosIngrediente = new Headers();
        
        /* Establece el action para enviar */
        let actionIngrediente = APP_URL+'app/ajax/ingredienteAjax.php';
    
        /* Configuraciones en formato JSON de los datos de la petición */
        let configIngrediente ={
            "method": "POST",
            "headers": encabezadosIngrediente,
            "mode": "cors",
            "cache": "no-cache",
            "body": dataIngrediente
        };
    
        /* Realiza la petición a la acción del formulario */
        fetch(actionIngrediente, configIngrediente).then(respuesta => {
            return respuesta.json();
        }).then(respuestaJSON=>{
            if (respuestaJSON.length == 0) {
                return true;
            } else {
                return alertas_ajax(respuestaJSON);
            }
        });
    }

    /* Aprueba la RECETA */

    if ('id' in receta && receta.id != null &&receta.id != "") {
        
        /* Crea un formulario para enviar al recetaAjax */
        let formReceta = document.createElement('form');
        
        /* Añade el method al formulario */
        formReceta.setAttribute('method', 'POST');
        
        /* Crea un formdata con el formulario */
        let dataReceta = new FormData(formReceta);
        
        /* Añade el campo módulo para enviar al recetaAjax */
        dataReceta.append('modulo_receta', 'aprobar');
        
        /* Aañade el campo id_receta para enviar al controlador */
        dataReceta.append('id_receta', receta.id);
        
        /* Crea las cabeceras para enviar la peticion */
        let encabezadosReceta = new Headers();
        
        /* Establece el action para enviar */
        let actionReceta = APP_URL+'app/ajax/recetaAjax.php';
    
        /* Configuraciones en formato JSON de los datos de la petición */
        let configReceta ={
            "method": "POST",
            "headers": encabezadosReceta,
            "mode": "cors",
            "cache": "no-cache",
            "body": dataReceta
        };
    
        /* Realiza la petición a la acción del formulario */
        fetch(actionReceta, configReceta).then(respuesta => {
            return respuesta.json();
        }).then(respuestaJSON=>{
            document.querySelector('#btnAprobarReceta').classList.add('oculto');
            if (respuestaJSON.length == 0) {
                return true;
            } else {
                return alertas_ajax(respuestaJSON);
            }
        });
    }


        
}

/* Rellena la lista de utensilios de la vistaReceta */
function rellenarUtensiliosReceta(idLista, arrayUtensilios) {

    /* Recupera la lista para insertar los utensilios */
    let lista = document.querySelector('#'+idLista);

    /* Recorre el array de utensilios para agregar un li por cada utensilio */
    arrayUtensilios.forEach(utensilio => {
        let linea = document.createElement('li');
        linea.setAttribute('class', 'liListaUtensilios');
        linea.innerText = utensilio['nombre_utensilio'];
        lista.appendChild(linea);
    });

}

/* Rellena la lista de ingredientes de la vistaReceta */
function rellenarIngredientesReceta(idLista, arrayIngredientes){

    /* Recupera la lista para insertar los ingredientes */
    let lista = document.querySelector('#'+idLista);
    
    /* Recorre el array de ingredientes para agregar un li por cada ingrediente */
    arrayIngredientes.forEach(ingrediente => {

        /* Crea la línea para cada ingrediente */
        let linea = document.createElement('li');
        linea.setAttribute('class', 'liListaIngredientes col-100 horizontal static');

        /* Crea un div para el nombre */
        let divNombre = document.createElement('div');
        divNombre.setAttribute('class', 'nombreIngredienteListaReceta col-60 static');
        
        /* Añade el nombre del ingrediente al div */
        divNombre.append(' '+ingrediente['nombre_ingrediente']);

        /* Añade el div a la linea */
        linea.append(divNombre);

        
        
        /* Comprueba si la cantidad corresponde a alguna de las unidades incontables para eliminarla */
        
        /* Crea un div para la cantidad */
        let divCantidad = document.createElement('div');
        divCantidad.setAttribute('class', 'cantidadIngredienteListaReceta');
        
        /* Crea el output para la cantidad */
        let cantidad = document.createElement('output');
        cantidad.setAttribute('class', 'outputCantidadIngrediente');
        
        /* Si la cantidad pertenece a alguna de las unidades incontables, no la pone */        
        if (![5, 6, 11].includes(ingrediente['id_unidad'])) {

            /* Añade la cantidad al output */
            cantidad.value = parseFloat(ingrediente['cantidad']);
        }

        /* Guarda como data attribute la cantidad original para tenerla disponible al recalcular los ingredientes */
        cantidad.dataset.original = cantidad.value;

        /* Guarda como data attribute el id de la unidad para tenerlo disponible al recalcular los ingredientes */
        cantidad.dataset.unidad = ingrediente['id_unidad'];
        
        /* Añade output al div */
        divCantidad.append(cantidad);
        
        /* Añade el div a la linea */
        linea.append(divCantidad);

        /* Crea un div para la unidad */
        let divUnidad = document.createElement('div');
        divUnidad.setAttribute('class', 'unidadIngredienteListaReceta');

        /* Añade las unidades al div */
        divUnidad.append(ingrediente['nombre_unidad']);

        /* Añade el div a la linea */
        linea.append(divUnidad);

        /* Añade la linea a la lista */
        lista.appendChild(linea);
        
    });
}

/* Rellena todas las etiquetas de la vistaReceta */
function rellenarEtiquetasReceta(idDiv, idsEtiquetas, tabla) {

    /* Recupera el div donde hay que poner las etiquetas */
    let divEtiquetas = document.querySelector('#'+idDiv);

    /* Convierte a array lo que viene en idsEtiquetas si no lo es */
    if (typeof idsEtiquetas === 'number') {
        idsEtiquetas = [{0: idsEtiquetas}];
        
    }
    
    if (idsEtiquetas != "") {
        idsEtiquetas.forEach(id => {
            obtenerEtiquetas(id[0], tabla).then(etiqueta => {

                /* Crea la etiqueta */
                let divEtiqueta = document.createElement('div');
                divEtiqueta.setAttribute('class', 'etiqueta ' + tabla);

                /* Añade el icono a la etiqueta */
                let iconoEtiqueta = document.createElement('i');
                iconoEtiqueta.setAttribute('class', 'fa-solid fa-tag');
                divEtiqueta.append(iconoEtiqueta);

                /* Añade el texto a la etiqueta */
                divEtiqueta.append(' '+etiqueta[1]);
 
                /* Añade la etiqueta al div */
                divEtiquetas.append(divEtiqueta);
            });
        });
    }
    
}

/* Recalcula la cantidad de ingredientes al cambiar el número de personas */
function calcularIngredientes(numeroPersonasNuevo){

    /* Recupera el valor de la cantidad de ingredientes original y lo convierte a float */
    let personasOriginal = parseFloat(document.querySelector('#personasOld').value);

    /* Convierte a float el número de personas actual */
    numeroPersonasFloat = parseFloat(numeroPersonasNuevo);

    /* Recupera los output de las cantidades de cada ingrediente */
    let cantidadIngredientes = document.querySelectorAll('.outputCantidadIngrediente');

    /* Solo si nº de personas es mayor o igual a 1 */
    if (numeroPersonasFloat >= 1 && Number.isInteger(numeroPersonasFloat)) {
        
        cantidadIngredientes.forEach(cantidad => {

            if (cantidad.dataset.original !== "") {
                /* Convierte a float la cantidad original */
                let cantidadOriginal = parseFloat(cantidad.dataset.original);
        
                /* Calcula la cantidad nueva */
                let cantidadNew = parseFloat(((cantidadOriginal/personasOriginal)*numeroPersonasFloat).toFixed(2));
        
                /* Redondea las cantidades dependiendo de las unidades */
                if (["2", "4", "7", "8", "9", "10"].includes(cantidad.dataset.unidad)) {
                    cantidadNew = Math.round(cantidadNew * 4) / 4;
                }
        
                cantidad.value = cantidadNew;
                
            }
    
        });
    }


}

/* Procesa un bloque de texto con párrafos largos para paginarlos si es necesario y poner negrita al principio
si un párrafo empieza con una frase terminada en : */
function procesarBloqueTexto({
    doc,
    titulo,
    selectorParrafos,
    inicioY,
    anchoTexto = 180,
    margenX = 14,
    margenInferior = 10
}) {
    /* Estilos del título */
    doc.setFont('helvetica', 'bolditalic');
    doc.setFontSize(12);

    /* Posición del título del bloque */
    const tituloY = inicioY;
    doc.text(titulo, 12, tituloY);

    /* Parámetros de texto */
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);

    /* Recupera todos los párrafos del texto */
    const parrafos = document.querySelectorAll(selectorParrafos);

    /* Recupera la altura de página del documento */
    const pageHeight = doc.internal.pageSize.getHeight();

    /* Recupera el tamaño de fuente y calcula el alto de línea */
    const fontSizePt = doc.internal.getFontSize();
    const ptToMm = 0.3528;
    const lineHeight = fontSizePt * ptToMm * 1.15;

    /* Posición inicial del texto que no es título */
    let actualY = tituloY + 6;

    /* Inicio del rectántulo */
    let inicioRectY = actualY - 9;

    /* *************************************************************** */
    /* Función auxiliar para dibujar el rectángulo final */
    /* *************************************************************** */
    function dibujarRect() {
        const altoRect = actualY - inicioRectY + 2;
        doc.rect(10, inicioRectY - 2, 190, altoRect);
    }
    /* *************************************************************** */

    /* *************************************************************** */
    /* Función auxiliar que verifica si se llega al final de la página
    para añadir una nueva página y resetear la posición vertical */
    /* *************************************************************** */
    function verificarPaginado(alto) {

        /* Comprueba si el párrafo cabe en lo que queda de página */
        if (actualY + alto > pageHeight - margenInferior) {

            /* Dibuja el rectángulo alrededor de lo que hay escrito */
            dibujarRect();

            /* Añade una nueva página */
            doc.addPage();

            /* Restablece la posición vertical del texto y el rectángulo */
            actualY = 20;
            inicioRectY = actualY - 5;
        }
    }
    /* *************************************************************** */


    /* Pone el flag de primer párrafo a true */
    let esPrimerParrafo = true;
    
    /* Recorre los párrafos */
    parrafos.forEach((p, index) => {

        /* Detecta si el párrafo está vacío */
        let texto = p.textContent.trim();
        if (texto === "") return;

        /* Detecta si hay : en el párrafo */
        let encabezado = "";
        let resto = texto;
        let tieneEncabezado = false;

        const idx = texto.indexOf(":");

        /* Si hay : divice el texto en dos partes */
        if (idx !== -1) {
            encabezado = texto.substring(0, idx + 1);
            resto = texto.substring(idx + 1).trim();
            tieneEncabezado = true;
        }

        /* Si no tiene encabezado pone el texto controlando si hay salto de página y vuelve arriba */
        if (!tieneEncabezado) {

            const lineas = doc.splitTextToSize("     " + texto, anchoTexto);
            const altoParrafo = lineas.length * lineHeight;

            verificarPaginado(altoParrafo);

            doc.setFont("helvetica", "normal");
            doc.text(lineas, margenX, actualY);
            actualY += altoParrafo;

            return;
        }

        /* Comprueba si el párrafo tiene encabezado en negrita para poner un salto de línea si NO es el primer párrafo */
        if (tieneEncabezado && !esPrimerParrafo) {

            const espacioExtra = lineHeight;
            verificarPaginado(espacioExtra);
            actualY += espacioExtra;
        }

        /* Coloca el encabezado en negrita verificando si cabe en la página */
        doc.setFont("helvetica", "bold");
        const lineasEnc = doc.splitTextToSize(encabezado, anchoTexto);
        const altoEnc = lineasEnc.length * lineHeight;

        verificarPaginado(altoEnc);
        doc.text(lineasEnc, margenX, actualY);
        actualY += altoEnc;

        /* Coloca el resto del texto si no está vacío verificando si cabe en la página */
        doc.setFont("helvetica", "normal");
        if (resto !== "") {
            const lineasTxt = doc.splitTextToSize("     " + resto, anchoTexto);
            const altoTxt = lineasTxt.length * lineHeight;

            verificarPaginado(altoTxt);
            doc.text(lineasTxt, margenX, actualY);
            actualY += altoTxt;
        }

        /* Cambia el flag de primer párrafo porque el siguiente ya no lo es */
        esPrimerParrafo = false;
    });

    /* Dibuja el rectángulo del párrafo */
    dibujarRect();

    /* Devuelve la posición actual del texto */
    return actualY;
}




/* Genera el pdf de la receta */
async function generarPDFReceta(){

    /* Crea el documento */
    const doc = new window.jspdf.jsPDF();

    /* Imagen de la cabecera: Obtiene el logo, lo convierte a base64 y lo coloca */
    const bannerSuperior = await cargarImagenBase64("http://192.168.1.53/fogones/app/views/img/BannerAlargado.jpg");

    doc.addImage(bannerSuperior, "JPEG", 10, 5, 190, 28.75);

    /* Titulo de la ficha */
    doc.rect(10, 35, 190, 10);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.text("Ficha Técnica", 105, 42.5, null, null, "center");


    /* Nombre de la receta */
    const nombre = document.querySelector('#datosCabeceraReceta h2').innerText;
    
    doc.rect(10, 45, 190, 10);
    doc.setFontSize(14);
    doc.text(nombre, 105, 53, null, null, "center");

    /* Enviada por */
    const redactor = document.querySelector('#propietarioReceta .total').innerText;

    doc.rect(10, 55, 130, 6);
    doc.setFont('helvetica', 'bolditalic');
    doc.setFontSize(8);
    doc.text('Enviada por: ', 12, 59);
    doc.setFont('helvetica', 'italic');
    doc.text(redactor, 30, 59);

    /* Tiempo de elaboracion */
    const tiempo = document.querySelector('#textoTiempoElaboracion').innerText;

    doc.rect(140, 55, 60, 6);
    doc.setFont('helvetica', 'bolditalic');
    doc.text('Tiempo Elaboración: ', 142, 59);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.text(tiempo, 172, 59);

    /* Cambia el tamaño de la letra */
    doc.setFontSize(12);

    /* Estilo de cocina */
    textoEstilo = '';
    let estilos = document.querySelectorAll('.estilos_cocina');
    estilos.forEach(estilo => {
        textoEstilo += estilo.innerText.trim() + ' / ';
        
    });

    if (textoEstilo != '') {
        doc.setFont('helvetica', 'bolditalic');
        doc.rect(10, 61, 190, 8);
        doc.text('Estilo de cocina: ', 12, 67);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(10);
        doc.text(textoEstilo, 47, 67);
    }

    /* Tipo y grupo de plato */
    textoEtiquetas = '';

    let grupo_plato = document.querySelector('.grupos_plato').innerText;
    if (grupo_plato != "") {
        textoEtiquetas += grupo_plato.trim() + ' / ';
    }
    
    
    let tipos_plato = document.querySelectorAll('.tipos_plato');
    tipos_plato.forEach(tipo => {
        textoEtiquetas += tipo.innerText.trim() + ' / ';
        
    });

    textoEtiquetas = textoEtiquetas.slice(0, 62);

    doc.rect(10, 69, 130, 8);
    doc.setFont("helvetica", "bolditalic");
    doc.text("Grupo/Familia: " , 12, 75);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.text(textoEtiquetas, 38, 75);
    
    /* Número de personas */
    const nPersonas = document.querySelector('#nPersonas').value;
    doc.rect(140, 69, 60, 8);
    doc.setFont('helvetica', 'bolditalic');
    doc.setFontSize(12);
    doc.text("Núm. Raciones: ", 142, 75);
    doc.setFont('helvetica', 'normal');
    doc.text(nPersonas + " Pax", 176, 75);

    /* Ingredienes */
    doc.setFont('helvetica', 'bolditalic');
    doc.text('Ingredientes:', 12, 81);
    
    let listaIngredienes = document.querySelectorAll('.liListaIngredientes');
    let posicion = 88;
    
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    listaIngredienes.forEach(ingrediente => {
        const nombre = ingrediente.children[0].innerText;
        const cantidad = ingrediente.children[1].innerText;
        const unidad = ingrediente.children[2].innerText;
        
        doc.text(nombre, 14, posicion);
        doc.text(cantidad, 108, posicion, null, null, 'right');
        doc.text(unidad, 110, posicion);
        posicion += 4;
        
    });
    
    /* Utensilios */
    doc.setFont('helvetica', 'bolditalic');
    doc.setFontSize(12);
    doc.text('Utensilios:', 132, 81);
    
    let listaUtensilios = document.querySelectorAll('.liListaUtensilios');
    let posicionUtensilios = 88;
    
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    listaUtensilios.forEach(utensilio => {
        const nombreUtensilio = utensilio.textContent;
        doc.text(nombreUtensilio, 134, posicionUtensilios);
        posicionUtensilios += 4;
    });
    
    
    /* Comprueba cual de los rectángulos de utensilios o ingredientes es mayor */
    if (posicionUtensilios > posicion) {
        posicion = posicionUtensilios;
    }
    
    doc.rect(10, 77, 120, posicion - 76);
    doc.rect(130, 77, 70, posicion - 76);

    /* Elaboración */
    
    actualY = procesarBloqueTexto({
        doc,
        titulo: "Elaboración:",
        selectorParrafos: "#elaboracionReceta p",
        inicioY: posicion + 6
    });


    /* Presentación */
    actualY = procesarBloqueTexto({
        doc,
        titulo: "Presentación:",
        selectorParrafos: "#emplatadoReceta p",
        inicioY: actualY + 5
    });

    const pdfBlob = doc.output('blob');

    const pdfUrl = URL.createObjectURL(pdfBlob);

    window.open(pdfUrl, '_blank');


}

/* Convierte a Base64 una imagen */
async function cargarImagenBase64(url) {
    const res = await fetch(url);
    const blob = await res.blob();
    return await new Promise(resolve => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.readAsDataURL(blob);
    });
}

