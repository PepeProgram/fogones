/* Realiza las peticiones para rellenar datos en una página sin recargar */

/* Rellena un select con los datos obtenidos de la base de datos cuando se selecciona una opción de otro */
async function rellenarSelect(idSeleccionado, idRellenar, tabla, campo, seleccionar){

    /* Obtiene el select que hay que rellenar */
    let campoSelect = document.querySelector('#'+idRellenar);

    /* Obtiene las clases para poner en cada option */
    let clasesOptions = campoSelect.querySelector('option').classList;

    /* Crea la acción para la petición */
    let accion = APP_URL+'app/ajax/peticionesAjax.php';

    /* Crea un formulario para enviar a las peticiones */
    let data = new FormData();

    /* Añade la tabla en la que hay que buscar */
    data.append('tabla', tabla);

    /* Añade el id del elemento a buscar */
    data.append('id', idSeleccionado);

    /* Añade el campo a buscar */
    data.append('campo', campo);

    /* Añade la accion a realizar */
    data.append('accion', 'rellenarSelect');

    /* Crea las cabeceras para enviar la peticion */
    let encabezados = new Headers();

    /* Configuraciones en formato JSON de los datos de la petición */
    let config ={
        "method": 'POST',
        "headers": encabezados,
        "mode": "cors",
        "cache": "no-cache",
        "body": data
    };

    /* Vacía el select */
    while (campoSelect.children[1]) {
        campoSelect.removeChild(campoSelect.children[1]);
    }

    /* Realiza la petición de búsqueda sólo si el id es distinto de 0 */
    if (idSeleccionado !== 0) {
        
        try {
            const response = await fetch(accion, config);

            /* Añadido para que al llamarla con await, espere correctamente */
            if (!response.ok) {
                throw new Error("Error en la respuesta");
            }

            const data = await response.json();

            /* Comprueba la tabla que hay que consultar */
            switch (tabla) {
                case 'zonas':
                        id_tabla = 'id_zona';
                        nombre = 'nombre_zona';
                    break;
            
                case 'paises':
                        id_tabla = 'id_pais';
                        nombre = 'esp_pais';
                    break;

                case 'regiones':
                        id_tabla = 'id_region';
                        nombre = 'nombre_region';
                    break;
                
                case 'estilos_cocina':
                        id_tabla = 'id_estilo';
                        nombre = 'nombre_estilo';

                        clasesOptions = clasesOptions.toString().split(' ');
                        clasesOptions.pop();
                    break;

                case 'tipos_plato':
                        id_tabla = 'id_tipo';
                        nombre = 'nombre_tipo';

                        clasesOptions = clasesOptions.toString().split(' ');
                        clasesOptions.pop();
                    break;
                
                case 'tecnicas':
                        id_tabla = 'id_tecnica';
                        nombre = 'nombre_tecnica';

                        clasesOptions = clasesOptions.toString().split(' ');
                        clasesOptions.pop();
                    break;
                
                case 'grupos_plato':
                        id_tabla = 'id_grupo';
                        nombre = 'nombre_grupo';

                        clasesOptions = clasesOptions.toString().split(' ');
                        clasesOptions.pop();
                    break;

                case 'utensilios':
                        id_tabla = 'id_utensilio';
                        nombre = 'nombre_utensilio';

                        clasesOptions = clasesOptions.toString().split(' ');
                        clasesOptions.pop();
                    break;
                case 'ingredientes':
                        id_tabla = 'id_ingrediente';
                        nombre = 'nombre_ingrediente';

                        clasesOptions = clasesOptions.toString().split(' ');
                        clasesOptions.pop();
                    break;
                case 'unidades_medida':
                        id_tabla = 'id_unidad';
                        nombre = 'nombre_unidad';

                        clasesOptions = clasesOptions.toString().split(' ');
                        clasesOptions.pop();
                    break;

                default:
                    break;
            }

            for (let i = 0; i < data.length; i++) {
                
                /* Crea una option para añadir al select */
                let option = document.createElement('option');
                
                /* Añade al value de la option el id del elemento */
                option.setAttribute('value', data[i][id_tabla]);

                /* Comprueba si la variable seleccionar viene definida y selecciona el elemento */
                if (typeof(seleccionar) !== 'undefined') {

                    /* Comprueba si es un array de un select múltiple o un string de un select sencillo */
                    if (Array.isArray(seleccionar)) {
                        seleccionar.forEach(element => {
                            if (element[0] == data[i][id_tabla]) {
                                option.setAttribute('selected', '');
                            }
                        });
                    }
                    else{
                        /* Si seleccionar tiene el mismo valor que el value de la option, la selecciona */
                        if (data[i][id_tabla] == seleccionar)  {
                            option.setAttribute('selected', '');
                        }
                    }

                }
                
                /* Añade las clases a la option */
                option.setAttribute('class', clasesOptions);
                
                /* Establece el texto de la option */
                option.append(data[i][nombre]);

                /* Añade la opción al select */
                campoSelect.append(option);
            }

            if (tabla == 'paises') {
                await rellenarSelect(0, 'regionEnviarReceta', 'regiones', 'id_region');
            }

            /* Añadido para esperar el await correctamente */
            return response;
            
        } catch (error) {
            textoAlerta = {
                tipo: 'recargar',
                icono: 'error',
                titulo: 'Error Fatal!!!',
                texto: error+' Se ha producido un error inesperado. Inténtelo de nuevo más tarde.',
                confirmButtonText: 'Aceptar',
                colorIcono: 'red'
            };
                ventanaModal(textoAlerta);
            }
        }
        
        /* Añadido para esperar el await correctamente */
        return true;
}

/* Devuelve las etiquetas de una receta */
function obtenerEtiquetas(id, tabla){

    /* Crea la acción para la petición */
    let accion = APP_URL+'app/ajax/peticionesAjax.php';

    /* Crea un formulario para enviar a las peticiones */
    let data = new FormData();

    /* Añade la tabla en la que hay que buscar */
    data.append('tabla', tabla);

    /* Añade el id de la etiqueta a buscar */
    data.append('id', id);

    /* Añade la accion a realizar */
    data.append('accion', 'obtenerElemento');

    /* Crea los encabezados para enviar la petición */
    let encabezados = new Headers();

     /* Configuraciones en formato JSON de los datos de la petición */
    let config ={
        "method": 'POST',
        "headers": encabezados,
        "mode": "cors",
        "cache": "no-cache",
        "body": data
    };

    /* Realiza la petición de búsqueda sólo si el id es distinto de 0 y no está vacío */
    if (id != 0 && id != "") {

        return fetch(accion, config).then(respuesta=>{
           return respuesta.json(); 
        });
    }
}

/* Selecciona los elementos de un select determinado */
function seleccionarSelect(idSelect, seleccionados){

    if (Array.isArray(seleccionados)) {
        console.log(seleccionados);
    } else {
        console.log('no es un array')
    }

}