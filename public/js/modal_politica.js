const modal = document.getElementById("modal-politica");
const enlace = document.getElementById("abrir-politica");
const cerrar = document.querySelector(".cerrar");
const contenido = document.getElementById("contenido-politica");

// Función común para cerrar el modal
function cerrarModal() {
    modal.style.display = "none";
    document.body.classList.remove("modal-abierto");
}

// Abrir modal
enlace.addEventListener("click", (e) => {
    e.preventDefault();
    modal.style.display = "block";
    document.body.classList.add("modal-abierto");

    fetch("politica_privacidad.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al cargar la política.");
            }
            return response.text();
        })
        .then(data => {
            contenido.innerHTML = data;
        })
        .catch(() => {
            contenido.innerHTML = "<p>No se pudo cargar la política. Inténtalo más tarde.</p>";
        });
});

// Cerrar con la X
cerrar.addEventListener("click", cerrarModal);

// Cerrar haciendo clic fuera del modal
window.addEventListener("click", (e) => {
    if (e.target === modal) {
        cerrarModal();
    }
});

// Delegación de eventos para contenido cargado por fetch
document.addEventListener("click", (e) => {
    if (e.target.id === "volver-login") {
        e.preventDefault();
        cerrarModal();
    }
});
