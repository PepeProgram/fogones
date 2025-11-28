// =====================================================================
// Scroll infinito + Lazy Loading + FadeIn + Restaurar listado inicial
// Para tarjetas .tarjetaReceta dentro de #main-container
// =====================================================================

document.addEventListener("DOMContentLoaded", () => {

    const contenedor = document.getElementById("main-container");
    const section = contenedor.querySelector('#ultimasAgregadas');
    const todasLasRecetas = Array.from(document.querySelectorAll(".tarjetaReceta")); // Array en memoria de todas las tarjetas
    let visibles = 12;        // Cuántas se muestran inicialmente
    const paso = 6;           // Cuántas añadir por scroll
    const maxVisibles = 18;   // Máximo de tarjetas en el DOM

    // -------------------------------------------------------
    // Inicialización: mostrar las primeras 12 tarjetas
    // -------------------------------------------------------
    function initTarjetas() {
        todasLasRecetas.forEach((t, i) => {
            if (i < visibles) {
                t.style.display = "flex";
                t.classList.add("fade-in");
            } else {
                t.style.display = "none";
                t.classList.remove("fade-in");
            }
            // Asegurar que las tarjetas están dentro del contenedor
            if (!t.parentNode) section.appendChild(t);
        });
        cargarImagenesVisibles();
    }

    initTarjetas();

    // -------------------------------------------------------
    // Scroll infinito dentro del contenedor
    // -------------------------------------------------------
    contenedor.addEventListener("scroll", () => {
        const pos = contenedor.scrollTop + contenedor.clientHeight;
        const max = contenedor.scrollHeight;

        if (pos >= max * 0.75) {
            mostrarMasTarjetas();
        }

        cargarImagenesVisibles();
    });

    // -------------------------------------------------------
    // Mostrar más tarjetas al hacer scroll
    // -------------------------------------------------------
    function mostrarMasTarjetas() {
        if (visibles >= todasLasRecetas.length) return; // No hay más tarjetas

        const inicio = visibles;
        const fin = Math.min(visibles + paso, todasLasRecetas.length);
        const nuevas = todasLasRecetas.slice(inicio, fin);

        nuevas.forEach(t => {
            t.style.display = "flex";
            t.classList.add("fade-in");
            if (!t.parentNode) contenedor.appendChild(t);
        });

        visibles += nuevas.length;

        // Eliminar las primeras tarjetas si superamos maxVisibles
        if (visibles > maxVisibles) {
            const aEliminar = visibles - maxVisibles;
            for (let i = 0; i < aEliminar; i++) {
                const t = todasLasRecetas[i];
                if (t.parentNode) t.parentNode.removeChild(t);
            }
            visibles = maxVisibles;
        }

        cargarImagenesVisibles();
    }

    // -------------------------------------------------------
    // Lazy loading manual por data-src
    // -------------------------------------------------------
    function cargarImagenesVisibles() {
        const imgs = contenedor.querySelectorAll("img.lazy-img");

        const contRect = contenedor.getBoundingClientRect();

        imgs.forEach(img => {
            if (img.src && img.src === img.dataset.src) return;

            const rect = img.getBoundingClientRect();

            const visible =
                rect.top < contRect.bottom &&
                rect.bottom > contRect.top;

            if (visible) {
                img.src = img.dataset.src;
            }
        });
    }

    // -------------------------------------------------------
    // Restaurar listado inicial
    // -------------------------------------------------------
    function restaurarListadoInicial() {

        // Limpiar seccion recetas
        section.innerHTML = "";

        visibles = 12;
        todasLasRecetas.forEach((t, i) => {
            if (i < visibles) {
                t.style.display = "flex";
                t.classList.add("fade-in");
            } else {
                t.style.display = "none";
                t.classList.remove("fade-in");
            }
            section.appendChild(t);
        });

        // Scroll al inicio usando requestIdleCallback
        const scrollToTop = () => {
            contenedor.scrollTo({ top: 0, behavior: 'smooth' });
            cargarImagenesVisibles();
        };

        if ('requestIdleCallback' in window) {
            requestIdleCallback(() => {
                scrollToTop();
            });
        } else {
            // fallback para navegadores que no soportan requestIdleCallback
            setTimeout(() => {
                scrollToTop();
            }, 50);
        }

        cargarImagenesVisibles();
    }

    // Hacemos accesible la función desde fuera
    window.restaurarListadoInicial = restaurarListadoInicial;

});
