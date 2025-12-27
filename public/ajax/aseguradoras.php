<?php
require_once __DIR__ . '/../../controllers/AseguradoraController.php';

$controller = new AseguradoraController();

/*
|--------------------------------------------------------------------------
| PETICIONES POST (CRUD)
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = $_POST['accion'] ?? null;

    switch ($accion) {

        case 'crear':
            $respuesta = $controller->crearAseguradora();
            echo json_encode($respuesta);
            break;

        default:
            echo json_encode([
                'status'  => 'error',
                'mensaje' => 'Acción no válida'
            ]);
            break;
    }

    exit;
}

/*
|--------------------------------------------------------------------------
| PETICIONES GET (búsqueda / filtrado)
|--------------------------------------------------------------------------
*/
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
