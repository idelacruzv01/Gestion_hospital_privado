<?php
require_once __DIR__ . '/../core/Database.php';

class Usuario {
    private $db;

    public function __construct() {
        $database = new Database(); // crear instancia
        $this->db = $database->getConnection(); // obtener conexión
    }

    public function obtenerPorUsuario($usuario) {
    try {
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener usuario: " . $e->getMessage());
        return false;
    }
}

}
