<?php

require_once __DIR__ . '/../../controllers/AseguradoraController.php';

$controller = new AseguradoraController();

$buscar = $_GET['buscar'] ?? null;
$tipo   = $_GET['tipo']   ?? null;

if ($buscar && strlen($buscar) >= 3) {
    echo $controller->buscarAseguradoras($buscar);
    exit;
}

if ($tipo) {
    echo $controller->mostrarAseguradorasPorTipo($tipo);
    exit;
}

echo "<p style='text-align:center; color:red;'>No se especificó tipo ni búsqueda.</p>";
