<?php
require_once __DIR__ . '/../../controllers/OpcionAseguradoraController.php';

$opcion = $_GET['opcion'] ?? '';
$id     = $_GET['id'] ?? null;

$opcion = trim($opcion);
$id     = $id !== null ? (int)$id : null;

if ($opcion === '' || $id === null || $id <= 0) {
    http_response_code(400);
    echo "<p>Parámetros no válidos.</p>";
    exit;
}

$controller = new OpcionAseguradoraController();
$controller->mostrar($opcion, $id);
