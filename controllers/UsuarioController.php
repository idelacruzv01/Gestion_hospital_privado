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
    public function crearUsuario($datos) {
        return $this->usuarioModel->crear($datos);
    }

    // Editar usuario existente
    public function actualizarUsuario($id, $datos) {
        return $this->usuarioModel->actualizar($id, $datos);
    }

    // Eliminar usuario
    public function eliminarUsuario($id) {
        return $this->usuarioModel->eliminar($id);
    }
}
