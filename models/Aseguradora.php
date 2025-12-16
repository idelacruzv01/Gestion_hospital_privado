<?php
require_once __DIR__ . '/../core/Database.php';

class Aseguradora {
    public static function obtenerPorTipo($tipo) {
    $tiposValidos = ['salud', 'accidentes', 'mutuas', 'privados', 'internacional', 'trafico'];

    if (!in_array($tipo, $tiposValidos)) {
        throw new Exception('Tipo de aseguradora no válido');
    }

    $database = new Database();
    $conn = $database->getConnection();

    $sql = "SELECT s.id, s.nombre, s.logo
            FROM seguros_salud s
            JOIN tipos_aseguradora t ON s.tipo_aseguradora_id = t.id
            WHERE t.nombre = :tipo
            ORDER BY s.nombre ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Nuevo método para buscar por nombre (mínimo 3 letras)
    public static function buscarPorNombre($texto) {
        $texto = trim($texto);
        if (strlen($texto) < 3) {
            return [];
        }

        $database = new Database();
        $conn = $database->getConnection();

        // Busca en todas las aseguradoras 
        $sql = "SELECT s.id, s.nombre, s.logo
                FROM seguros_salud s
                JOIN tipos_aseguradora t ON s.tipo_aseguradora_id = t.id
                WHERE s.nombre LIKE :texto
                ORDER BY s.nombre ASC
                LIMIT 20";
        $stmt = $conn->prepare($sql);
        $likeTexto = "%$texto%";
        $stmt->bindParam(':texto', $likeTexto, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listar(): array
    {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->query("SELECT id, nombre, tipo_aseguradora_id AS tipo FROM seguros_salud ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}