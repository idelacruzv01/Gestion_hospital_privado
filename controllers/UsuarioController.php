<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    // Obtener lista de usuarios para la vista administrar_usuarios.php
    public function listarUsuarios() {
        return $this->usuarioModel->obtenerTodos();
    }

    // Obtiene un usuario concreto (para editar)
    public function obtenerUsuarioPorId($id) {
        return $this->usuarioModel->obtenerPorId($id);
    }

    // Crear un nuevo usuario
    public function crearUsuario() {
        if (!isset($_POST['usuario'], $_POST['password'], $_POST['nombre_completo'], $_POST['tipo'])) {
            return ['status' => 'error', 'mensaje' => 'Faltan datos'];
        }

        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $nombre_completo = $_POST['nombre_completo'];
        $tipo = $_POST['tipo'];

        $resultado = $this->usuarioModel->crearUsuario($usuario, $password, $nombre_completo, $tipo);

        if ($resultado) {
            return ['status' => 'ok', 'mensaje' => 'Usuario creado correctamente'];
        } else {
            return ['status' => 'error', 'mensaje' => 'Error al crear usuario'];
        }
    }


    // Editar usuario existente
    public function actualizarUsuario($id, $datos) {
        return $this->usuarioModel->actualizar($id, $datos);
    }

    // Eliminar usuario
    public function eliminarUsuario($id) {

        // Validar que llega un ID correcto
        if (!isset($id) || empty($id) || !is_numeric($id)) {
            return [
                'status' => 'error',
                'mensaje' => 'ID de usuario no válido.'
            ];
        }

        // Llamar al modelo
        $resultado = $this->usuarioModel->eliminar($id);

        if ($resultado) {
            return [
                'status' => 'ok',
                'mensaje' => 'Usuario eliminado correctamente.'
            ];
        } else {
            return [
                'status' => 'error',
                'mensaje' => 'No se pudo eliminar el usuario.'
            ];
        }
    }

}
