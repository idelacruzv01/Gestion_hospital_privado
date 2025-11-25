    <?php
    session_start();

    // Si el usuario ya ha iniciado sesión, redirigir al menú principal
    if (isset($_SESSION['usuario'])) {
        header("Location: menu_principal.php");
        exit();
    }

    // Regenerar ID de sesión al cargar el login (reduce riesgo de fijación de sesión)
    session_regenerate_id(true);

    // Limpieza adicional opcional (por seguridad y consistencia)
    if (isset($_SESSION['usuario'])) {
        unset($_SESSION['usuario']);
    }

    // Crear token CSRF si no existe
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));    
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Login - Urgencias</title>
        <link rel="stylesheet" href="css/estilo_login.css">
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@700&display=swap" rel="stylesheet">
    </head>
    <body>

        <header class="main-header">
            <div class="logo-container">
                <img src="img/logo_header/logo_quiron.png" alt="Logo Quirón" class="logo">
            </div>
        </header>

        <div class="login-container">
        <h2>Admisión Toledo</h2>
        <h3>Inicia Sesión</h3>

        
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['mensaje'])): ?>
            <p class="mensaje"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
        <?php endif; ?>


        <form action="../controllers/LoginController.php" method="POST" autocomplete="off">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" required autocomplete="off">

            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave" required autocomplete="off">

            <div class="form-group">
                <label>
                    <input type="checkbox" name="aceptar_politica" required>
                    He leído y acepto la 
                    <a href="#" id="abrir-politica">política de privacidad y protección de datos.</a>

                </label>
            </div>

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Iniciar sesión">
        </form>
        </div>

            <!-- Modal de Política de Privacidad -->
            <div id="modal-politica" class="modal">
            <div class="modal-contenido">
                <span class="cerrar">&times;</span>
                <div id="contenido-politica">
                <p>Cargando...</p>
                </div>
            </div>
            </div>

            <script>
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
            </script>

    </body>
    </html>
