document.addEventListener("DOMContentLoaded", function () {

    /* FUNCIONES BÁSICAS */

    function limpiarBloquesAseguradoras() {
        document.getElementById("resultado").innerHTML = "";
    }

    function limpiarBloquesDinamicos() {
        const contenedor = document.getElementById("resultado-opcion");
        if (contenedor) {
            contenedor.innerHTML = "";
        }
    }

    /* MENÚ PRINCIPAL: CARGA DE ASEGURADORAS */

    document.querySelectorAll(".btn-menu").forEach((boton) => {
        boton.addEventListener("click", function () {
            const tipo = this.dataset.tipo;
            const url = this.dataset.url;

            if (url) {
                window.location.href = url;
                return;
            }

            limpiarBloquesAseguradoras();

            fetch(`ajax/aseguradoras.php?tipo=${tipo}`)
                .then((response) => response.text())
                .then((data) => {
                    document.getElementById("resultado").innerHTML = data;
                    activarClicksEnAseguradoras();
                })
                .catch((error) => console.error("Error en la petición:", error));
        });
    });


    /* ACTIVAR CLICS EN ASEGURADORAS LISTADAS */

    function activarClicksEnAseguradoras() {
        document.querySelectorAll(".aseguradora").forEach((item) => {
            item.addEventListener("click", () => {
                const nombre = item.dataset.nombre;
                const logo = item.dataset.logo;
                const id = item.dataset.id;
                mostrarOpciones(nombre, logo, id);
            });
        });
    }


    /* MOSTRAR LAS OPCIONES DE UNA ASEGURADORA */

    function mostrarOpciones(nombre, logo, id) {
        const opciones = [
            { texto: "contacto", icono: "fas fa-phone", label: "Contacto" },
            { texto: "protocolo_urgencias", icono: "fas fa-ambulance", label: "Urgencias" },
            { texto: "antigeno", icono: "fas fa-vial", label: "Antígenos" },
            { texto: "tac", icono: "fas fa-x-ray", label: "TAC" },
            { texto: "ingresos", icono: "fas fa-file-signature", label: "Autorización de Ingreso" },
            { texto: "traslado_hospitalario", icono: "fas fa-hospital-alt", label: "Traslado a otro centro" },
            { texto: "traslado_domicilio", icono: "fas fa-house-medical", label: "Traslado a domicilio" },
        ];

        let html = `
            <div class="cabecera-aseguradora">
                <img src="img/logos/${logo}" alt="Logo ${nombre}" class="logo-seleccionado">
                <h2>¿Qué quieres hacer con <span>${nombre}</span>?</h2>
            </div>
            <div class="opciones">
        `;

        opciones.forEach((op) => {
            html += `
                <button class="btn-opcion"
                        data-opcion="${op.texto}"
                        data-id="${id}">
                    <i class="${op.icono}"></i>
                    <span>${op.label}</span>
                </button>
            `;
        });

        html += `</div>`;

        document.getElementById("resultado").innerHTML = html;

        // Limpia SOLO el contenido de la opción
        limpiarBloquesDinamicos();
    }




    /* CARGAR CONTENIDO DE CADA OPCIÓN */

    document.addEventListener("click", function (e) {
        if (e.target.closest(".btn-opcion")) {
            const boton = e.target.closest(".btn-opcion");
            const opcion = boton.dataset.opcion;
            const id = boton.dataset.id;
            mostrarOpcion(id, opcion);
        }
    });

    function mostrarOpcion(id, opcion) {
        limpiarBloquesDinamicos();

        fetch(`ajax/opcion.php?id=${id}&opcion=${encodeURIComponent(opcion)}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Respuesta no válida del servidor");
                }
                return response.text();
            })
            .then((data) => {
                const contenedor = document.getElementById("resultado-opcion");
                if (!contenedor) return;
                contenedor.innerHTML = data;
            })
            .catch((error) =>
                console.error(`Error al cargar los datos de ${opcion}:`, error)
            );
    }




    /* BUSCADOR DE ASEGURADORAS */

    const buscador = document.getElementById("buscarAseguradora");

    if (buscador) {
        buscador.addEventListener("input", function () {
            const texto = this.value.trim();

            if (texto.length < 3) {
                document.getElementById("resultado").innerHTML = "";
                return;
            }

            fetch(`ajax/aseguradoras.php?buscar=${encodeURIComponent(texto)}`)
                .then((response) => response.text())
                .then((data) => {
                    document.getElementById("resultado").innerHTML = data;
                    activarClicksEnAseguradoras();
                })
                .catch((error) => console.error("Error en la búsqueda:", error));
        });
    }

});
