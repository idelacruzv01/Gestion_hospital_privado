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

function eliminarUsuario(id) {
    if (!confirm("¿Seguro que quieres eliminar este usuario?")) return;

    const datos = new FormData();
    datos.append('accion', 'eliminar');
    datos.append('id', id);

    fetch("ajax/usuario.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "ok") {
            alert("Usuario eliminado correctamente");
            location.reload();
        } else {
            alert("Error: " + data.mensaje);
        }
    })
    .catch(err => console.error("Error en AJAX:", err));
}

function editarUsuario(id) {

    const datos = new FormData();
    datos.append("accion", "obtener");
    datos.append("id", id);

    fetch("ajax/usuario.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "ok") {

            // Rellenar formulario
            document.getElementById("editar-id").value = data.usuario.id;
            document.getElementById("editar-usuario").value = data.usuario.usuario;
            document.getElementById("editar-nombre").value = data.usuario.nombre_completo;
            document.getElementById("editar-tipo").value = data.usuario.tipo;

            // Mostrar formulario
            document.getElementById("contenedor-form-editar-usuario").style.display = "block";

        } else {
            alert("Error: " + data.mensaje);
        }
    })
    .catch(err => console.error("Error en AJAX:", err));
}

function guardarCambiosUsuario(event) {
    event.preventDefault();

    const formulario = document.getElementById("form-editar-usuario");
    const datos = new FormData(formulario);

    datos.append("accion", "actualizar");

    fetch("ajax/usuario.php", {
        method: "POST",
        body: datos
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === "ok") {
            alert("Usuario actualizado");
            location.reload();
        } else {
            alert("Error: " + data.mensaje);
        }
    })
    .catch(e => console.error("Error AJAX:", e));
}


