document.addEventListener('DOMContentLoaded', () =>{
    const hayRecetas = document.querySelector('#recetasJSON');
    const haySection = document.querySelector('#ultimasAgregadas');
    if (hayRecetas && haySection) {
        renderTarjetas();
    }
});

function renderTarjetas(){

    /* Variables para el scroll infinito */
    let inicioActual = 0;
    let finalActual = 0;

    const CARGA_INICIAL = 6;
    const MAX_VISIBLE = 9;
    const CARGA = 3;

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

    /* Crea un array para guardar el html de cada tarjeta */
    let todasLasTarjetas = [];

    todasLasTarjetas = todasLasRecetas.map(receta => {
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
            legend = 'Agregar ' + receta.nombre + ' a mis recetas favoritas';
        }

        /* Recupera las estrellas de la dificultad */
        let estrellas = obtenerEstrellasDificultad(receta.dificultad);

        /* Recupera los alergenos */
        const alergenos = receta.alergenos;

        let htmlAlergenos = "";
        alergenos.forEach(alergeno => {
            htmlAlergenos += `
                <div class="foto pointer">
                    <img class="alergenoTarjeta" src="${icon_dir}${alergeno.foto_alergeno}" alt="${alergeno.nombre_alergeno}" title="Alérgeno: ${alergeno.nombre_alergeno}"</img>
                </div>
            `;
        });

        /* Establece el html si el usuario es revisor o la receta es suya */
        let htmlIconoEditar = "";
        if ((revisor && revisor == true) || id_usuario_ver == receta.id_usuario) {
            htmlIconoEditar += `
                <div class="opcionesAutores brnRecetaUpdate">
                    <a href="${APP_URL}recetaUpdate/${receta.id}" alt="Editar receta ${receta.nombre}" aria-label="Editar ${receta.nombre}">
                        <button class="fa-regular fa-pen-to-square" alt="Editar receta ${receta.nombre}" aria-label="Editar ${receta.nombre}"></button>
                    </a>
                </div>
            `;
        }

        const htmlTarjeta = `
            <div class="column tarjetaReceta col-100 vertical top">
                <a href="${APP_URL}vistaReceta/${receta.id}">
                    <div class="fotoTarjetaReceta col-100 static">
                        <img class="lazy-img" data-src="${img_dir}${foto}" alt="Foto de ${receta.nombre}" title="Fotografía de ${receta.nombre}" src="${img_dir}${foto}">
                    </div>
                    <h3 class="medio">
                        <form class="FormularioAjax formFavoritos" action="${APP_URL}app/ajax/recetaAjax.php" method="POST" autocomplete="off" name="${legend}">
                            <input type="hidden" name="modulo_receta" value="cambiarFavorito">
                            <input type="hidden" name="id_usuario" value="${id_usuario_ver}">
                            <input type="hidden" name="id_receta" value="${receta.id}">
                            <input type="hidden" name="nombre_receta" value="${receta.nombre}">
    
                            <button type="submit" class="btnIcon" aria-label="${legend}" title="${legend}">
                                ${heart}
                            </button>
                        </form>
                        <span>
                            ${receta.nombre}
                        </span>
                    </h3>
                </a>
                <div class="col-100 static total vertical">
                    <div id="dif-${receta.id}" class="iconoDificultad horizontal static pointer" title="Dificultad ${receta.dificultad} de 5">
                        ${estrellas}
                    </div>
                    <div class="col-100">
                        <p class="textoLargo">${receta.descripcion}</p>
                    </div>
                </div>
                <div class="etiquetasTarjeta col-100 total horizontal static">
                    <div class="etiqueta tiempo static centrar pointer" title="Tiempo de elaboración ${receta.tiempo.slice(0, receta.tiempo.lastIndexOf(":"))}">
                        <i class="fa-solid fa-clock-rotate-left"></i> ${receta.tiempo.slice(0, receta.tiempo.lastIndexOf(":"))}h.
                    </div>
                    <div class="iconoEtiqueta horizontal static">
                        ${htmlAlergenos}
                    </div>
                    ${htmlIconoEditar}
                </div>
            </div>
        `;

        return(htmlTarjeta);

    });

    /* Establece las CARGA_INICIAL primeras tarjetas */
    window.mostrarIniciales = function(){
        inicioActual = 0;
        finalActual = CARGA_INICIAL - 1;
        pintarVentana();
    }

    /* Pinta las tarjetas en la section desde inicioActual hasta finalActual */
    function pintarVentana(){

        /* Obtiene las tarjetas del array */
        const slice = todasLasTarjetas.slice(inicioActual, finalActual + 1);

        /* Pinta las tarjetas */
        section.innerHTML = slice.join('');

    }

    /* Carga CARGA tarjetas nuevas al hacer scroll hacia abajo */
    window.cargarAbajo = function(){
        if(finalActual >= todasLasTarjetas.length - 1){
            return;
        }

        finalActual += CARGA;

        if (finalActual - inicioActual +1 > MAX_VISIBLE) {
            inicioActual += CARGA;
        }

        pintarVentana();

        mainContainer.scrollTop -= 100;

    }

    window.cargarArriba = function(){
        if (inicioActual === 0) {
            return;
        }

        inicioActual -= CARGA;

        if (finalActual - inicioActual +1 > MAX_VISIBLE) {
            finalActual -= CARGA;
        }

        pintarVentana();

        mainContainer.scrollTop += 100;
    }

    mostrarIniciales();


    let cargando = false; // flag para evitar llamadas simultáneas

    mainContainer.addEventListener('scroll', () => {
        if (!document.querySelector('#ultimasAgregadas')) {
            return;
        }

        // Scroll hacia abajo
        if (mainContainer.scrollTop + mainContainer.clientHeight >= mainContainer.scrollHeight - 10) {
            if (!cargando) {
                cargando = true;
                cargarAbajo();
                setTimeout(() => { cargando = false; }, 300); // bloqueo mínimo para evitar recarga múltiple
            }
        }

        // Scroll hacia arriba
        if (mainContainer.scrollTop <= 35) {
            if (!cargando) {
                cargando = true;
                cargarArriba();
                setTimeout(() => { cargando = false; }, 300);
            }
        }
    });


}