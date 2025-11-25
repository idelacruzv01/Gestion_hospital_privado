<?php
session_start();

// Verificar usuario logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=" . urlencode("Debes iniciar sesión para acceder."));
    exit();
}

// Tiempo máximo de inactividad (en segundos)
$inactividad_max = 900; // 15 minutos

if (isset($_SESSION['ultimo_acceso'])) {
    $inactivo = time() - $_SESSION['ultimo_acceso'];
    if ($inactivo > $inactividad_max) {
        session_unset();
        session_destroy();
        header("Location: index.php?error=" . urlencode("Sesión expirada. Inicia sesión de nuevo."));
        exit();
    }
}

$_SESSION['ultimo_acceso'] = time();
?>
