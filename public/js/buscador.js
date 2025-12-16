document.addEventListener("DOMContentLoaded", function () {
    // Configuración de los buscadores
    const buscadores = [
        {
            inputId: 'buscarMedico',
            resultadoId: 'resultado_medicos',
            archivo: 'ajax/buscador.php?tipo=medicos',
            mensaje: 'Introduce al menos 3 caracteres para buscar una especialidad.'
        },
        {
            inputId: 'buscarPrecio',
            resultadoId: 'resultado_precios',
            archivo: 'ajax/buscador.php?tipo=precios',
            mensaje: 'Introduce al menos 3 caracteres para buscar un precio.'
        },
        {
            inputId: 'buscarTelefono',
            resultadoId: 'resultado_telefonos',
            archivo: 'ajax/buscador.php?tipo=telefonos',
            mensaje: 'Introduce al menos 3 caracteres para buscar un teléfono.'
        },
        {
            inputId: 'buscarTrafico',
            resultadoId: 'resultado_traficos',
            archivo: 'ajax/buscador.php?tipo=trafico',
            mensaje: 'Introduce al menos 3 caracteres para buscar una aseguradora de tráfico.'
        }
        // Aquí se pueden añadir nuevos buscadores
    ];

    // Función para hacer la búsqueda
    function realizarBusqueda(input, resultado, archivo, mensaje) {
        const query = input.value.trim();

        //Solicitamos al menos 3 caracteres para realizar una búsqueda, si no, se muestra un mensaje
        if (query.length < 3) {
            resultado.innerHTML = `<p>${mensaje}</p>`;
            return;
        }

        fetch(`${archivo}&q=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(html => {
                resultado.innerHTML = html;
            })
            .catch(error => {
                resultado.innerHTML = `<p>Error en la búsqueda</p>`;
                console.error('Error en la búsqueda:', error);
            });
    }

    // Recorremos cada buscador
    buscadores.forEach(b => {
        const input = document.getElementById(b.inputId);
        const resultado = document.getElementById(b.resultadoId);

        if (input && resultado) {
            // 🔹 Live search: cada vez que el usuario escribe
            input.addEventListener('input', () => {
                realizarBusqueda(input, resultado, b.archivo, b.mensaje);
            });
        }
    });
});
