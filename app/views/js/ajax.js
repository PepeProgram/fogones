/* Seleccionar todos los formularios que se enviaran vía AJAX que seleccionaremos mediante su clase */

/* Establece las características comunes de una ventana de alerta */
const Ventana = Swal.mixin({
    background: "#f8e9ca",
    /* iconColor: "#7E5A10", */
    color: "#7E5A10",
    /* Si se cierra la ventana al pulsar fuera */
    backdrop: true,
    /* Icono y títulos en horizontal o vertical (no permite cerrar pulsando fuera de la ventana) */
    toast: false,
    /* Establece si la ventana ocupará todo el ancho de pantalla, todo el alto, o toda la pantalla. Con false tiene el tamaño por defecto. (row, column, fullscreen, false) */
    grow: "false",
    confirmButtonColor: "#7E5A10",
    cancelButtonColor: "#d33",
    /* Coloca el foco en el botón de cancelar en lugar del de aceptar */
    focusCancel: true
});

const formularios_ajax = document.querySelectorAll(".FormularioAjax");

formularios_ajax.forEach(formularios => {
    /* Añade el evento submit de los formularios y ejecuta preventDefault para impedir el funcionamiento del submit por defecto */
    formularios.addEventListener("submit", function(e){
        e.preventDefault();
        
        /* Obtiene el nombre del formulario para ponerlo en el título */
        let form_name = this.getAttribute("name");
        
        /* Ventana de alerta creada por sweetAlert2 */
        Ventana.fire({
            title: form_name,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                /* Crea un array de datos para recibir los datos del formulario */
                let data = new FormData(this);

                /* añade el tipo de búsqueda al data del formulario según el id del botón */
                if (e.submitter.id != "") {
                    data.append("tipobusqueda", e.submitter.id);
                }

                /* Obtiene el método del formulario recibido */
                let method = this.getAttribute("method");

                /* Obtiene la ruta a donde van a ir los datos del formulario */
                let action = this.getAttribute("action");

                /* Crea las cabeceras para enviar la peticion */
                let encabezados = new Headers();

                /* Configuraciones en formato JSON de los datos de la petición */
                let config ={
                    "method": method,
                    "headers": encabezados,
                    "mode": "cors",
                    "cache": "no-cache",
                    "body": data
                };

                /* Realiza la petición al action del formulario */
                fetch(action, config)

                /* Convierte la respuesta a json */
                .then(respuesta => respuesta.json())

                /* Devuelve la respuesta */
                .then(respuesta => {
                    return alertas_ajax(respuesta);
                });
            }
        });

    });
});

/* Función que se encarga de enviar los datos a las alertas para mostrar los distintos tipos de ventanas de alerta */
function alertas_ajax(alerta){
    /* Comprueba el tipo de alerta que recibe del formulario php */
    if (alerta.tipo == "simple") {

        Ventana.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: "Aceptar"

        });
        
    }
    else if (alerta.tipo == "recargar"){

        Ventana.fire({
            title: alerta.titulo,
            text: alerta.texto,
            icon: alerta.icono,
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
        
    }
    else if (alerta.tipo == "limpiar"){

        Ventana.fire({
            title: alerta.titulo,
            text: alerta.texto,
            icon: alerta.icono,
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".FormularioAjax").reset();
            }
        });
        
    }
    else if (alerta.tipo == "limpiarRegistro"){

        Ventana.fire({
            title: alerta.titulo,
            text: alerta.texto,
            icon: alerta.icono,
            showCancelButton: false,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".FormularioAjax").reset();
                limpiarFormulario();
            }
        });
        
    }
    else if (alerta.tipo == "redireccionar"){
        window.location.href=alerta.url;
    }
}

/* Botón cerrar sesión */

let btn_exit = document.querySelector('#btn_exit');

/* Comprueba que el botón está en la pantalla para poder asignarle el evento */
if (btn_exit != null) {
    btn_exit.addEventListener("click", function(e){
        e.preventDefault();
        Ventana.fire({
            title: "Cerrar Sesión",
            text: "¿Quieres cerrar la sesión?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                /* Accede al botón y obtiene su href */
                let url = this.getAttribute("href");
    
                /* Redirige la página igual que si lo hiciese directamente */
                window.location.href = url;
            }
        });
    });
}
