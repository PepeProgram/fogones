document.addEventListener('DOMContentLoaded', () =>{
    const hayRecetas = document.querySelector('#recetasJSON');
    const haySection = document.querySelector('#ultimasAgregadas');
    if (hayRecetas && haySection) {
        renderTarjetas();
    }
});

function renderTarjetas(){

    /* Recupera la sección donde irán las tarjetas de las recetas */
    const section = document.querySelector('#ultimasAgregadas');

    /* Vacía el html de la sección */
    section.innerHTML = "";

    /* Establece el directorio de fotos */
    const img_dir = APP_URL + 'app/views/photos/recetas_photos/';

    /* Establece el directorio de icono de los alérgenos */
    const icon_dir = APP_URL + 'app/views/photos/alergen_photos/';

    /* Comprueba si hay sesión iniciada */
    const id_usuario_ver = section.dataset.idusuario;

    /* Comprueba si el usuario es revisor */
    const revisor = section.dataset.revisor;
    
    

    /* Recupera el json de las recetas */
    const todasLasRecetas = JSON.parse(document.querySelector('#recetasJSON').textContent);

    let todasLasTarjetas = [];
    todasLasRecetas.forEach(receta => {
        /* Comprueba si hay foto o foto por defecto */
        let foto = 'default.png';
        if (receta.foto) {
            foto = receta.foto;
        }

        /* Comprueba si es favorita para establecer el icono y la leyenda */
        let heart = "";
        let legend = "";
        if (receta.favorito) {
            heart = '<i class="fa-solid fa-heart userDel"></i>';
            legend = 'Quitar ' + receta.nombre + ' de mis recetas favoritas';
        } else {
            heart = '<i class="fa-regular fa-heart"></i>';
            legend = 'Quitar ' + receta.nombre + ' de mis recetas favoritas';
        }

        /* Recupera los alergenos */
        alergenos = receta.alergenos;

        const html = `
            <div class="column tarjetaReceta col-100 vertical top">
                <div class="fotoTarjetaReceta col-100 static">
                    <img class="lazy-img" data-src="${img_dir}${foto}" alt="Foto de ${receta.nombre}" title="Foto de ${receta.nombre}">
                </div>
                <div class="col-100 static total vertical">
                    <h3>
                        <form class="FormularioAjax formFavoritos" action="${APP_URL}app/ajax/recetaAjax.php" method="POST" autocomplete="off" name="${legend}">
                            <input type="hidden" name="modulo_receta" value="cambiarFavorito">
                            <input type="hidden" name="id_usuario" value="${id_usuario_ver}">
                            <input type="hidden" name="id_receta" value="${receta.id}">
                            <input type="hidden" name="nombre_receta" value="${receta.nombre}">

                            <button type="submit" class="btnIcon" aria-label="${legend}" title="${legend}">
                                ${heart}
                            </button>
                        </form>
                        <a href="${APP_URL}vistaReceta/${receta.id}">
                            ${receta.nombre}
                        </a>
                    </h3>
                </div>

            </div>
        `;

        /* RECORDAR CAMBIAR EL Ajax.js PARA QUE FUNCIONE EL AÑADIR A FAVORITOS CON LAS VENTANAS */

        
        todasLasTarjetas.push(html);

        section.innerHTML = todasLasTarjetas.join('');
    });

}