function mostrarFormularioNuevaAseguradora() {
    // Ocultamos la tabla y el botón
    document.getElementById("tabla-aseguradoras").style.display = "none";
    document.querySelector(".acciones-usuarios").style.display = "none";

    // Mostramos el formulario
    document.getElementById("contenedor-form-nueva-aseguradora").style.display = "block";
}

function guardarAseguradora(event) {
    event.preventDefault(); // evita recargar la página

    const formulario = document.getElementById("form-nueva-aseguradora");
    const datos = new FormData(formulario);

    // Indicamos la acción (igual que en usuarios)
    datos.append("accion", "crear");

    fetch("ajax/aseguradoras.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "ok") {

            alert("Aseguradora creada correctamente");
            // Recargamos la página para ver la nueva aseguradora en la lista
            window.location.reload();

        } else {
            alert("Error: " + data.mensaje);
        }
    })
    .catch(err => {
        console.error("Error en AJAX:", err);
        alert("Error de conexión");
    });
}
