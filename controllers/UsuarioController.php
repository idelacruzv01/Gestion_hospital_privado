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

    //Obtener un usuario para poder editarlo
    public function obtenerUsuarioPorId($id) {
        if (!$id) {
            return ['status' => 'error', 'mensaje' => 'ID no enviado'];
        }

        $usuario = $this->usuarioModel->obtenerPorId($id);

        if ($usuario) {
            return ['status' => 'ok', 'usuario' => $usuario];
        } else {
            return ['status' => 'error', 'mensaje' => 'Usuario no encontrado'];
        }
    }

    //Editar un usuario ya existente
    public function actualizarUsuario($datos) {

        if (!isset($datos['id'], $datos['usuario'], $datos['nombre_completo'], $datos['tipo'])) {
            return ['status' => 'error', 'mensaje' => 'Datos incompletos'];
        }

        $id = $datos['id'];

        $resultado = $this->usuarioModel->actualizar($id, $datos);

        if ($resultado) {
            return ['status' => 'ok', 'mensaje' => 'Usuario actualizado correctamente'];
        } else {
            return ['status' => 'error', 'mensaje' => 'No se pudo actualizar'];
        }
    }



}
