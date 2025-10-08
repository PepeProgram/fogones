<button id="botonScroll" title="Volver arriba" aria-label="Volver arriba" onclick="topFunction();">
    <span class="oculto">Volver arriba</span>
    <i class="fa-solid fa-chevron-up"></i>
</button>

<script>
    /* Obtiene el botón y el div principal */
    let botonScroll = document.querySelector('#botonScroll');
    let mainContainer = document.querySelector('#main-container');

    /* Ejecuta la función que controla la posición del scroll para mostrar u ocultar el botón */
    mainContainer.onscroll = function(){scrollFunction();};

    function scrollFunction(){
        if(mainContainer.scrollTop >20){
            botonScroll.style.display = "block";
        }
        else {
            botonScroll.style.display = "none";
        }
    }

    /* Envía el scroll del div principal a cero */
    function topFunction(){
        mainContainer.scrollTo({top: 0, behavior: 'smooth'});
    }
</script>