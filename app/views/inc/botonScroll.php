<button id="botonScroll" title="Volver arriba" aria-label="Volver arriba" onclick="botonScrollHandler();">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<script>
    let botonScroll = document.querySelector('#botonScroll');
    let mainContainer = document.querySelector('#main-container');

    mainContainer.onscroll = function(){ scrollFunction(); };

    function scrollFunction(){
        if (mainContainer.scrollTop > 20){
            botonScroll.style.display = "block";
        } else {
            botonScroll.style.display = "none";
        }
    }

    // --- FUNCIÓN COMPATIBLE ---
    function botonScrollHandler() {

        // 1) Si estamos en la página de recetas (hay tarjetas)
        if (document.querySelector('.tarjetaReceta')) {

            if (typeof restaurarListadoInicial === 'function') {
                restaurarListadoInicial();
                return;
            }
        }

        // 2) Si NO estamos en la página de recetas → comportamiento normal
        topFunction();
    }

    function topFunction(){
        mainContainer.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
