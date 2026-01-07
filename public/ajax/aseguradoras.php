<?php
require_once __DIR__ . '/../../controllers/AseguradoraController.php';

$controller = new AseguradoraController();

/*PETICIONES POST (CRUD)*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = $_POST['accion'] ?? null;

    switch ($accion) {

        case 'crear':
            $respuesta = $controller->crearAseguradora();
            echo json_encode($respuesta);
            break;

        case 'eliminar':
            $id = $_POST['id'] ?? null;
            $respuesta = $controller->eliminarAseguradora($id);
            echo json_encode($respuesta);
            break;

        case 'editar_aseguradora':
            $id = $_POST['id'] ?? null;
            $controller->editarAseguradora($id);
            break;

        case 'editarContacto':
            $id = $_POST['id'] ?? null;
            $controller->editarContacto($id);
            break;
        case 'guardarContacto':
            $respuesta = $controller->guardarContacto($_POST);
            echo json_encode($respuesta);
            break;

        case 'editarUrgencias':
            $id = $_POST['id'] ?? null;
            $controller->editarUrgencias($id);
            break;
        case 'guardarUrgencias':
            $respuesta = $controller->guardarUrgencias($_POST);
            echo json_encode($respuesta);;
            break;

        case 'editarAntigenos':
            $id = $_POST['id'] ?? null;
            $controller->editarAntigenos($id);
            break;
        case 'guardarAntigenos':
            $respuesta = $controller->guardarAntigenos($_POST);
            echo json_encode($respuesta);
            break;

        case 'editarIngresos':
            $id = $_POST['id'] ?? null;
            $controller->editarIngresos($id);
            break;
        case 'guardarIngresos':
            $respuesta = $controller->guardarIngresos($_POST);
            echo json_encode($respuesta);
            break;

        case 'editarTAC':
            $id = $_POST['id'] ?? null;
            $controller->editarTAC($id);
            break;
        case 'guardarTac':
            $respuesta = $controller->guardarTac($_POST);
            echo json_encode($respuesta);
            break;

        case 'editarTrasladoOtroCentro':
            $id = $_POST['id'] ?? null;
            $controller->editarTrasladoOtroCentro($id);
            break;
        case 'guardarTrasladoHospitalario':
            $respuesta = $controller->guardarTrasladoHospitalario($_POST);
            echo json_encode($respuesta);
            break;

        case 'editarTrasladoDomicilio':
            $id = $_POST['id'] ?? null;
            $controller->editarTrasladoDomicilio($id);
            break;
        case 'guardarTrasladoDomicilio':
            $respuesta = $controller->guardarTrasladoDomicilio($_POST);
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

/*PETICIONES GET (búsqueda / filtrado)*/

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


