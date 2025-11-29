<button id="botonScroll" title="Volver arriba" aria-label="Volver arriba" onclick="topFunction();">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<script>

    let botonScroll = document.querySelector('#botonScroll');
    let mainContainer = document.querySelector('#main-container');

    const haySection = document.querySelector('#ultimasAgregadas');

    mainContainer.addEventListener('scroll', () => {

        /* Muestra el botón scroll cuando se ha desplazado más de 20 de la parte superior */
        if (mainContainer.scrollTop > 20){
            botonScroll.style.display = "block";
        } else {
            botonScroll.style.display = "none";
        }
    });


    function topFunction(){
        if (haySection) {
            window.mostrarIniciales();
            setTimeout(() => {
                mainContainer.scrollTop = 0;
            }, 50);
        } else {
            mainContainer.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
</script>
