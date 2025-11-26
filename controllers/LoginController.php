<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';

// Verificación del token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    unset($_SESSION['csrf_token']);
    header("Location: ../public/index.php?error=" . urlencode("Token CSRF inválido. Vuelve a intentarlo."));
    exit();
}
unset($_SESSION['csrf_token']); // invalidamos el token tras el uso

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificación del checkbox de política de privacidad
    if (empty($_POST['aceptar_politica'])) {
        $mensaje = urlencode("Debes aceptar la política de privacidad para continuar.");
        header("Location: ../public/index.php?error=$mensaje");
        exit();
    }

    $usuarioInput = htmlspecialchars(trim($_POST['usuario']));
    $claveInput = $_POST['clave'];

    // Validación en el servidor de campos vacíos
    if (empty($usuarioInput) || empty($claveInput)) {
        header("Location: ../public/index.php?error=" . urlencode("Debes completar todos los campos."));
        exit();
    }

    $usuarioModel = new Usuario();
    $user = $usuarioModel->obtenerPorUsuario($usuarioInput);

    if ($user && password_verify($claveInput, $user['clave'])) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // nuevo token para navegación segura
        header("Location: ../public/menu_principal.php");
        exit();
    } else {
        $mensaje = urlencode("Usuario o contraseña incorrectos");
        header("Location: ../public/index.php?error=$mensaje");
        exit();
    }
}
