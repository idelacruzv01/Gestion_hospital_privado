function guardarUsuario(event) {
    event.preventDefault(); // evita recargar la página

    const formulario = document.getElementById("form-nuevo-usuario");
    const datos = new FormData(formulario);

    // Añadir la acción al FormData
    datos.append('accion', 'crear');

    fetch("ajax/usuario.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "ok") {
            alert("Usuario creado correctamente");
            location.reload(); // recargar la página para actualizar la tabla
        } else {
            alert("Error: " + data.mensaje);
        }
    })
    .catch(err => console.error("Error en AJAX:", err));
}

function mostrarFormularioNuevoUsuario() {
    document.getElementById("contenedor-form-nuevo-usuario").style.display = "block";
}
