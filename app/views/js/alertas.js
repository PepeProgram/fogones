/* Establece las características comunes de una ventana de alerta */
const estiloVentana = Swal.mixin({
    background: "#f8e9ca",
    iconColor: "#7E5A10",
    color: "#7E5A10",
    confirmButtonColor: "#7E5A10",
    cancelButtonColor: "#d33",
    /* Si se cierra la ventana al pulsar fuera */
    backdrop: true,
    /* Icono y títulos en horizontal o vertical (no permite cerrar pulsando fuera de la ventana) */
    toast: false,
    /* Establece si la ventana ocupará todo el ancho de pantalla, todo el alto, o toda la pantalla. Con false tiene el tamaño por defecto. (row, column, fullscreen, false) */
    grow: "false",
    /* Coloca el foco en el botón de cancelar en lugar del de aceptar */
    focusCancel: true,
    /* Html para la x de cerrar */
    closeButtonHtml: '<i class="fa-solid fa-square-xmark"></i>'
});

function ventanaModal(ventana){
    if (ventana.tipo == "simple") {
        
        if (!ventana.colorIcono) {
            ventana.colorIcono = "#7E5A10";
        }

        estiloVentana.fire({
            icon: ventana.icono,
            iconColor: ventana.colorIcono,
            title: ventana.titulo,
            text: ventana.texto,
            confirmButtonText: "Aceptar"
        });
        
    }
    if (ventana.tipo == "recargar") {
        
        if (!ventana.colorIcono) {
            ventana.colorIcono = "#7E5A10";
        }

        estiloVentana.fire({
            icon: ventana.icono,
            iconColor: ventana.colorIcono,
            title: ventana.titulo,
            text: ventana.texto,
            confirmButtonText: "Aceptar"
        })
        .then((respuesta)=>{
            if (respuesta.isConfirmed) {
                window.location.reload();
            } else {
                
            }
        });
        
    }
    if (ventana.tipo == "redirigir") {
        
        if (!ventana.colorIcono) {
            ventana.colorIcono = "#7E5A10";
        }

        estiloVentana.fire({
            icon: ventana.icono,
            iconColor: ventana.colorIcono,
            title: ventana.titulo,
            text: ventana.texto,
            confirmButtonText: "Aceptar"
        })
        .then((respuesta)=>{
            if (respuesta.isConfirmed) {
                window.location.href=ventana.url;
            } else {
                
            }
        });
    }
}