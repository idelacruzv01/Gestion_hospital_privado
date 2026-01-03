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

//Eliminar aseguradora
function eliminarAseguradora(id) {
    if (!confirm("¿Seguro que quieres eliminar esta aseguradora?")) return;

    const datos = new FormData();
    datos.append('accion', 'eliminar');
    datos.append('id', id);

    fetch("ajax/aseguradoras.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "ok") {
            alert("Aseguradora eliminada correctamente");
            location.reload();
        } else {
            alert("Error: " + data.mensaje);
        }
    })
    .catch(err => console.error("Error en AJAX:", err));
}

//Editar aseguradora
function editarAseguradora(id) {
    const formData = new FormData();
    formData.append('accion', 'editar_aseguradora');
    formData.append('id', id);

    fetch('ajax/aseguradoras.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        // Ocultar tabla y botones
        document.getElementById('tabla-aseguradoras').style.display = 'none';
        document.querySelector('.acciones-usuarios').style.display = 'none';

        // Mostrar contenedor de edición
        const contenedor = document.getElementById('editar-aseguradora');
        contenedor.style.display = 'block';
        contenedor.innerHTML = html;
    })
    .catch(error => {
        console.error('Error al cargar el menú de edición:', error);
        alert('No se pudo cargar el modo edición.');
    });
}

//Ocultar tabla y mostrar edición
function mostrarEdicion(html) {
    document.getElementById("tabla-aseguradoras").style.display = "none";
    document.querySelector(".acciones-usuarios").style.display = "none";

    const contenedor = document.getElementById("contenedor-edicion");
    contenedor.style.display = "block";
    contenedor.innerHTML = html;
}

//Función para editar los traslados a domicilio
function editarTrasladoDomicilio(id) {
    const datos = new FormData();
    datos.append('accion', 'editar_traslado_domicilio');
    datos.append('id', id);

    fetch('ajax/aseguradoras.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.text())
    .then(html => {
        mostrarEdicion(html);
    })
    .catch(err => {
        console.error(err);
        alert('Error al cargar el formulario');
    });
}

// Función para guardar los traslados a domicilio
function guardarTrasladoDomicilio(event, aseguradoraId) {
    event.preventDefault();

    const form = document.getElementById('form-traslado-domicilio');
    const formData = new FormData(form);

    formData.append('accion', 'guardarTrasladoDomicilio');
    formData.append('aseguradora_id', aseguradoraId);

    fetch('ajax/aseguradoras.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok) {
            alert('Traslado a domicilio guardado correctamente');

            // Ocultar el contenedor de edición
            const contenedor = document.getElementById('contenedor-edicion');
            if (contenedor) {
                contenedor.style.display = 'none';
                contenedor.innerHTML = ''; // opcional: limpiar contenido
            }
            
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error AJAX:', error);
    });
}



