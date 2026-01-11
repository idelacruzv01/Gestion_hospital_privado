    <?php

    // Configurar las cookies de sesión para mayor seguridad (antes de session_start)
    session_set_cookie_params([
        'lifetime' => 0,        // Se elimina al cerrar el navegador
        'path' => '/',
        'domain' => '',         // Vacío = dominio actual
        'secure' => true,       // Solo enviar la cookie por HTTPS
        'httponly' => true,     // Evita acceso desde JavaScript
        'samesite' => 'Lax'     // Bloquea la mayoría de ataques CSRF básicos
    ]);

    session_start();

    // Si el usuario ya ha iniciado sesión, redirigir al menú principal
    if (isset($_SESSION['usuario'])) {
        header("Location: menu_principal.php");
        exit();
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
        <title>Login - Hospital Privado</title>
        <link rel="stylesheet" href="css/estilo_login.css">
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@700&display=swap" rel="stylesheet">
    </head>
    
    <body>

        <header class="main-header">
            <div class="logo-container">
                <img src="img/logo_header/logo_hospital_2.png" alt="Logo Hospital" class="logo">
            </div>
        </header>

        <div class="login-container">
        <h2>Admisión Toledo</h2>
        <h3>Inicia Sesión</h3>

        <!-- Mostrar mensajes de error o confirmación -->
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['mensaje'])): ?>
            <p class="mensaje"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
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
        <div id="modal-politica" class="modal" role="dialog" aria-modal="true">
        <div class="modal-contenido">
            <span class="cerrar" role="button" aria-label="Cerrar">&times;</span>
            <div id="contenido-politica">
            <p>Cargando...</p>
            </div>      
        </div>
        </div>

        <script src="js/modal_politica.js"></script>

    </body>
    </html>
