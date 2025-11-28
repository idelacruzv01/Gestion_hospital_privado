document.addEventListener("DOMContentLoaded", function () {

    // ================= BOTONES DEL MENÚ =================
    document.querySelectorAll(".btn-menu").forEach((boton) => {
        boton.addEventListener("click", function () {
            const url = this.dataset.url; // URL a la que redirigir
            if (url) {
                window.location.href = url; // Redirige al URL indicado
            }
        });
    });

    // ================= COLAPSAR/EXPANDIR SECCIONES =================
    document.querySelectorAll('.menu-section').forEach(section => {
        const title = section.querySelector('.menu-title');
        const grid = section.querySelector('.menu-grid');

        title.addEventListener('click', () => {
            grid.classList.toggle('show'); // Alterna mostrar/ocultar el grid de botones
        });
    });

});
