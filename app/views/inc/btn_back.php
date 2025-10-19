<button id="btn-back" class="btn" title="Volver" aria-label="Volver">
    <i class="fa-solid fa-chevron-left"></i>
    <span class="">Volver</span>
</button>

<!-- Script para el botón regresar atrás -->
<script type="text/javascript">
    let btn_back = document.querySelector("#btn-back");

    btn_back.addEventListener('click', function(e){
        e.preventDefault();
        window.history.back();
    });
</script>