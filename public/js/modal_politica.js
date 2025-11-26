const modal = document.getElementById("modal-politica");
            const enlace = document.getElementById("abrir-politica");
            const cerrar = document.querySelector(".cerrar");
            const contenido = document.getElementById("contenido-politica");

            enlace.addEventListener("click", (e) => {
                e.preventDefault();
                modal.style.display = "block";
                document.body.classList.add("modal-abierto"); // bloquea el scroll del fondo

                // Cargar contenido de la política desde el archivo externo
                fetch("politica_privacidad.php")
                .then(response => {
                    if (!response.ok) throw new Error("Error al cargar la política.");
                    return response.text();
                })
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(error => {
                    contenido.innerHTML = "<p>No se pudo cargar la política. Inténtalo más tarde.</p>";
                });
            });

            cerrar.addEventListener("click", () => {
                modal.style.display = "none";
                document.body.classList.remove("modal-abierto"); // restaura el fondo
            });

            window.addEventListener("click", (e) => {
                if (e.target === modal) {
                modal.style.display = "none";
                document.body.classList.remove("modal-abierto");
                }
            });