//-----MUESTRA EL FORMULARIO DE NUEVA ASEGURADORA-----//
function mostrarFormularioNuevaAseguradora() {
    // Ocultamos la tabla y el botón
    document.getElementById("tabla-aseguradoras").style.display = "none";
    document.querySelector(".acciones-usuarios").style.display = "none";

    // Mostramos el formulario
    document.getElementById("contenedor-form-nueva-aseguradora").style.display = "block";
}

//-----GUARDA LA NUEVA ASEGURADORA-----//
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

//-----ELIMINA LA ASEGURADORA-----//
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

//-----EDITA LA ASEGURADORA-----//
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
        // Ocultar tabla y boton de agregar nueva aseguradora
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

//-----FUNCIONES GENERICAS PARA EDITAR Y GUARDAR CADA OPCIÓN DE LA ASEGURADORA-----//

//Función para mostrar el formulario de edición y ocultar la tabla y el botón de agregar nueva aseguradora
function mostrarEdicion(html) {
    document.getElementById("tabla-aseguradoras").style.display = "none";
    document.querySelector(".acciones-usuarios").style.display = "none";

    const contenedor = document.getElementById("contenedor-edicion");
    contenedor.style.display = "block";
    contenedor.innerHTML = html;
}

//Función generica para editar cada opción
function editarSeccion(accion, id) {
    const datos = new FormData();
    datos.append('accion', accion);
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

//Función generica para guardar cada opción
function guardarFormulario(event, {
    formId,
    accion,
    aseguradoraId,
    mensajeOk
}) {
    event.preventDefault();

    const form = document.getElementById(formId);
    const formData = new FormData(form);

    formData.set('accion', accion);
    formData.set('aseguradora_id', aseguradoraId);

    fetch('ajax/aseguradoras.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            alert(mensajeOk);

            const contenedor = document.getElementById('contenedor-edicion');
            contenedor.style.display = 'none';
            contenedor.innerHTML = '';
        } else {
            alert('Error: ' + (data.mensaje || 'Error desconocido'));
        }
    })

    .catch(err => {
        console.error(err);
        alert('Error de conexión');
    });
}

//-----FUNCIONES ESPECIFICAS PARA CADA OPCIÓN DE LA ASEGURADORA-----//
// Función para guardar los traslados a domicilio
function guardarTrasladoDomicilio(event, aseguradoraId) {
    guardarFormulario(event, {
        formId: 'form-traslado-domicilio',
        accion: 'guardarTrasladoDomicilio',
        aseguradoraId,
        mensajeOk: 'Traslado a domicilio guardado correctamente'
    });
}

//Función para guardar los traslados a otro centro
function guardarTrasladoHospitalario(event, aseguradoraId) {
    guardarFormulario(event, {
        formId: 'form-traslado-hospitalario',
        accion: 'guardarTrasladoHospitalario',
        aseguradoraId,
        mensajeOk: 'Traslado a otro centro guardado correctamente'
    });
}

//Función para guardar los TAC
function guardarTac(event, aseguradoraId) {
    guardarFormulario(event, {
        formId: 'form-tac',
        accion: 'guardarTac',
        aseguradoraId,
        mensajeOk: 'TAC guardado correctamente'
    });
}

//Función para guardar los ingresos
function guardarIngresos(event, aseguradoraId) {
    guardarFormulario(event, {
        formId: 'form-ingresos',
        accion: 'guardarIngresos',
        aseguradoraId,
        mensajeOk: 'Ingresos guardados correctamente'
    });
}
//Función para guardar los antigenos
function guardarAntigenos(event, aseguradoraId) {
    guardarFormulario(event, {
        formId: 'form-antigenos',
        accion: 'guardarAntigenos',
        aseguradoraId,
        mensajeOk: 'Antígenos guardados correctamente'
    });
}
//Función para guardar las urgencias
function guardarUrgencias(event, aseguradoraId) {
    guardarFormulario(event, {
        formId: 'form-urgencias',
        accion: 'guardarUrgencias',
        aseguradoraId,
        mensajeOk: 'Urgencias guardadas correctamente'
    });
}
//Función para guardar el contacto
function guardarContacto(event, aseguradoraId) {
    guardarFormulario(event, {
        formId: 'form-contacto',
        accion: 'guardarContacto',
        aseguradoraId: aseguradoraId,
        mensajeOk: 'Contacto guardado correctamente'
    });
}




