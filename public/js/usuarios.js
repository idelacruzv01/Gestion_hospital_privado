function guardarUsuario(event) {
    event.preventDefault();

    const form = event.target;
    const datos = new FormData(form);
    datos.append("accion", "crear");

    fetch("ajax/usuario.php", {
        method: "POST",
        body: datos
    })
    .then(r => r.json())
    .then(respuesta => {
        alert(respuesta.mensaje);
        if (respuesta.status === "ok") {
            window.location.reload();
        }
    })
    .catch(error => console.error("Error AJAX:", error));
}

function mostrarFormularioNuevoUsuario() {
    document.getElementById("form-nuevo-usuario").style.display = "block";
}
