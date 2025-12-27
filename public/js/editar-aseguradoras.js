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

            /*

            // Guardamos el ID de la nueva aseguradora
            const aseguradoraId = data.id;

            // Cargar siguiente paso (protocolo urgencias)
            cargarFormularioProtocoloUrgencias(aseguradoraId);

            */

        } else {
            alert("Error: " + data.mensaje);
        }
    })
    .catch(err => {
        console.error("Error en AJAX:", err);
        alert("Error de conexión");
    });
}

/*
//CARGA LOS DATOS DEL FORMULARIO DEL PROTOCOLO DE URGENCIAS
function cargarFormularioProtocoloUrgencias(aseguradoraId) {
    document.getElementById('urgencias_aseguradora_id').value = aseguradoraId;
    document.getElementById('formProtocoloUrgencias').style.display = 'block';
}

//ENVÍA LOS DATOS POR AJAX Y RECIBE RESPUESTA POR JSON. MUESTRA EL SIGUIENTE FORMULARIO SI LA RESPUESTA ES OK
function guardarProtocoloUrgencias() {
    const form = document.getElementById('formProtocoloUrgencias');
    const datos = new FormData(form);
    datos.append('accion', 'crear_protocolo_urgencias');

    fetch('ajax/aseguradora.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            form.style.display = 'none';
            cargarFormularioAntigenos(); // siguiente paso
        } else {
            alert(data.mensaje);
        }
    });
}

*/
