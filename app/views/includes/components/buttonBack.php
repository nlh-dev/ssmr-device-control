<button class="buttonBack sm:mb-2 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Cancelar</button>

<script type="text/javascript">
    let buttonBack = document.querySelector(".buttonBack");

    buttonBack.addEventListener('click', function(e) {
        e.preventDefault();
        window.history.back();
    });
</script>