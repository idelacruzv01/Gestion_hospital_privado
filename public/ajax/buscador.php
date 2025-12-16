<?php
require_once __DIR__ . '/../../controllers/BuscadorController.php';

$q    = $_GET['q']    ?? '';
$tipo = strtolower(trim($_GET['tipo'] ?? ''));

$q = trim($q);

if ($q === '' || strlen($q) < 3 || $tipo === '') {
    http_response_code(400);
    echo "<p>Parámetros de búsqueda no válidos.</p>";
    exit;
}

try {
    $controller = new BuscadorController();
    $controller->buscar($tipo, $q);
} catch (Exception $e) {
    http_response_code(500);
    echo "<p>Error en la búsqueda: " . htmlspecialchars($e->getMessage()) . "</p>";
}

