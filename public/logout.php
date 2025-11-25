<?php
session_start();

// Elimina todas las variables de sesión
$_SESSION = [];

// Borra la cookie de sesión si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destruye la sesión
session_destroy();

// Redirige al login con un mensaje de confirmación
header("Location: index.php?mensaje=" . urlencode("Has cerrado sesión correctamente."));
exit();
