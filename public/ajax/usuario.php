<?php
require_once __DIR__ . '/../../controllers/UsuarioController.php';

$controller = new UsuarioController();

$accion = $_POST['accion'] ?? null;

switch ($accion) {
    case 'crear':
        $respuesta = $controller->crearUsuario();
        echo json_encode($respuesta);
        break;

    case 'eliminar':
        $respuesta = $controller->eliminarUsuario($_POST['id']);
        echo json_encode($respuesta);
        break;

    case 'obtener':
        $id = $_POST['id'] ?? null;
        $respuesta = $controller->obtenerUsuarioPorId($id);
        echo json_encode($respuesta);
        break;

    case 'actualizar':
        $respuesta = $controller->actualizarUsuario($_POST);
        echo json_encode($respuesta);
        break;


    default:
        echo json_encode(['status' => 'error', 'mensaje' => 'Acción no válida']);
        break;
}
