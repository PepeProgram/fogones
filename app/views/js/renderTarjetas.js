document.addEventListener('DOMContentLoaded', () => {

    /* Obtiene el JSON de las tarjetas */
    const hayRecetas = document.querySelector('#recetasJSON');

    /* Obtiene el contenedor para colocar las tarjetas */
    const haySection = document.querySelector('#ultimasAgregadas');

    /* Si hay contenedor y hay tarjetas, renderiza las tarjetas */
    if (hayRecetas && haySection) {
        renderTarjetas();
    }
});


/* Renderiza las tarjetas de las recetas recibidas */
function renderTarjetas() {

    /* Establece el número de tarjeta de inicio */
    let inicioActual = 0;

    /* Número de tarjetas que carga al inicio */
    const CARGA_INICIAL = 9;
    
    /* Establece la posición final en el array de la última tarjeta inicial */
    let finalActual = CARGA_INICIAL - 1;

    /* Número de tarjetas que carga al cargar pulsar ver más */
    const CARGA = 6;

    /* Número de tarjetas que recorta cuando agrega nuevas tarjetas al pulsar ver más en la primera página */
    const RECORTAR = 3;

    /* Número máximo de tarjetas visibles */
    const MAX_VISIBLE = 12;

    /* Recupera la sección para colocar tarjetas */
    const section = document.querySelector('#ultimasAgregadas');

    /* Recupera el botón ver más */
    const btnVerMas = document.querySelector('#btnVerMas');

    /* Establece el directorio de imágenes */
    const img_dir = APP_URL + 'app/views/photos/recetas_photos/';

    /* Establece el directorio de iconos de los alérgenos */
    const icon_dir = APP_URL + 'app/views/photos/alergen_photos/';

    /* Recupera el id usuario del dataset del form */
    const id_usuario_ver = section.dataset.idusuario;

    /* Recupera si es revisor del dataset del form */
    const revisor = section.dataset.revisor;

    /* Convierte las recetas recuperadas del script de la página */
    const todasLasRecetas = JSON.parse(
        document.querySelector('#recetasJSON').textContent
    );

    /* Genera el html de las tarjetas */
    const tarjetasDOM = todasLasRecetas.map(receta => {
        /* Genera el container de cada tarjeta mapeando el array de tarjetas */
        let containerTarjeta = document.createElement('article');
        containerTarjeta.classList.add("column", "tarjetaReceta", "col-100", "vertical", "top");

        containerTarjeta.innerHTML = generarHTMLTarjeta(receta, img_dir, icon_dir, id_usuario_ver, revisor);
        return containerTarjeta;
    });

    /* Genera las 9 tarjetas iniciales */
    function mostrarIniciales() {
        section.innerHTML = "";
        inicioActual = 0;

        /* Establece la posicion de la tarjeta final actual en lo que sea menor:
        el número de tarjetas en el array, o las 9 tarjetas */
        finalActual = Math.min(CARGA_INICIAL - 1, tarjetasDOM.length - 1);

        /* Añade las tarjetas desde el inicio actual (0 por ser las primeras) hasta el final actual */
        for (let i = inicioActual; i <= finalActual; i++) {
            section.appendChild(tarjetasDOM[i].cloneNode(true));
        }

        /* Coloca el botón de ver más, volver arriba o nada si las tarjetas son menores que la vista inicial */
        configurarBoton();
    }

    /* Cuelga la función de la ventana para poder usarla fuera del script en el botón volver al inicio */
    window.mostrarIniciales = mostrarIniciales;

    // ----------- Acción "Ver más..." -----------
    function verMas() {

        /* Guarda el scroll que hay al pulsar el botón ver más */
        const scrollAntes = mainContainer.scrollTop;

        /* Si no hay más tarjetas, sale de la función */
        if (finalActual >= tarjetasDOM.length - 1) return;

        /* Suma la carga de tarjetas al nuevo final */
        const nuevoFinal = Math.min(finalActual + CARGA, tarjetasDOM.length - 1);

        /* Añade tarjetas desde el final actual hasta el nuevo final */
        for (let i = finalActual + 1; i <= nuevoFinal; i++) {
            section.appendChild(tarjetasDOM[i].cloneNode(true));
        }

        /* Actualiza el final actual */
        finalActual = nuevoFinal;

        /* Si supera el máximo visible, quita las del principio */
        if (section.children.length > MAX_VISIBLE) {
            for (let i = 0; i < RECORTAR; i++) {
                section.removeChild(section.firstElementChild);
                inicioActual++;
            }
        }

        /* Restaura la posición del scroll */
        mainContainer.scrollTop = scrollAntes;

        /* Coloca el botón del final */
        configurarBoton();
    }

    /* Gestiona el estado del botón */
    function configurarBoton() {

        /* Si hay 9 tarjetas o menos, no pone el botón */
        if (tarjetasDOM.length < CARGA_INICIAL) {
            btnVerMas.style.display = "none";
            return;
        }

        /* Muestra el botón */
        btnVerMas.style.display = "inline";
        

        /* Si no hay más tarjetas, pone botón volver arriba */
        if (finalActual >= tarjetasDOM.length - 1) {
            btnVerMas.textContent = "Volver arriba";
            btnVerMas.onclick = () => {
                mostrarIniciales();
                setTimeout(() => {
                    mainContainer.scrollTop = 0;
                }, 50);
            };

        /* Si hay más tarjetas, pone botón de ver más */
        } else {
            btnVerMas.textContent = "Mostrar más...";
            btnVerMas.onclick = verMas;
        }
    }

    /* Llama a la función para poner las tarjetas iniciales */
    mostrarIniciales();
}


/* Generador del HTML de cada tarjeta */
function generarHTMLTarjeta(receta, img_dir, icon_dir, id_usuario_ver, revisor) {

    let foto = receta.foto || "default.png";

    let heart = receta.favorito
        ? '<i class="fa-solid fa-heart userDel"></i>'
        : '<i class="fa-regular fa-heart"></i>';

    let legend = receta.favorito
        ? `Quitar ${receta.nombre} de mis recetas favoritas`
        : `Agregar ${receta.nombre} a mis recetas favoritas`;

    let estrellas = obtenerEstrellasDificultad(receta.dificultad);

    let htmlAlergenos = receta.alergenos.map(alergeno => `
        <div class="foto pointer">
            <img class="alergenoTarjeta"
                 src="${icon_dir}${alergeno.foto_alergeno}"
                 alt="${alergeno.nombre_alergeno}"
                 title="Contiene: ${alergeno.nombre_alergeno}">
        </div>
    `).join('');

    let htmlIconoEditar = "";
    if (id_usuario_ver == receta.id_usuario) {
        htmlIconoEditar = `
            <div class="opcionesAutores brnRecetaUpdate">
                <a href="${APP_URL}recetaUpdate/${receta.id}" title="Editar ${receta.nombre}">
                    <button class="fa-regular fa-pen-to-square" title="Cambiar datos de ${receta.nombre}"></button>
                </a>
            </div>
        `;
    }

    return `
        <a href="${APP_URL}vistaReceta/${receta.id}">
            <div class="fotoTarjetaReceta col-100 static">
                <img class="lazy-img" src="${img_dir}${foto}" alt="Foto de ${receta.nombre}">
            </div>
            <h3 class="medio">
                <form class="FormularioAjax formFavoritos" action="${APP_URL}app/ajax/recetaAjax.php" method="POST"  name="${legend}">
                    <input type="hidden" name="modulo_receta" value="cambiarFavorito">
                    <input type="hidden" name="id_usuario" value="${id_usuario_ver}">
                    <input type="hidden" name="id_receta" value="${receta.id}">
                    <input type="hidden" name="nombre_receta" value="${receta.nombre}">
                    <button type="submit" class="btnIcon" aria-label="${legend}">${heart}</button>
                </form>
                <span>${receta.nombre}</span>
            </h3>
        </a>

        <div class="col-100 static total vertical">
            <div class="iconoDificultad" title="Dificultad ${receta.dificultad}">
                ${estrellas}
            </div>
            <p class="textoLargo">${receta.descripcion}</p>
        </div>

        <div class="etiquetasTarjeta col-100 total horizontal static">
            <div class="etiqueta tiempo" title="Tiempo ${receta.tiempo.slice(0, receta.tiempo.lastIndexOf(":"))}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                ${receta.tiempo.slice(0, receta.tiempo.lastIndexOf(":"))}h.
            </div>
            <div class="iconoEtiqueta horizontal static">${htmlAlergenos}</div>
            ${htmlIconoEditar}
        </div>
    `;
}
