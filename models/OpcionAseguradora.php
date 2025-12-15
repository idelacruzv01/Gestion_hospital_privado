<?php
require_once __DIR__ . '/../core/Database.php';

class OpcionAseguradora {
    public static function obtener($opcion, $id) {
        $db = new Database();
        $conn = $db->getConnection();

        $tablas = [
            'contacto' => ['tabla' => 'seguros_salud', 'columna' => 'id'],
            'protocolo_urgencias' => ['tabla' => 'protocolos_urgencias', 'columna' => 'aseguradora_id'],
            'antigeno' => ['tabla' => 'antigenos', 'columna' => 'aseguradora_id'],
            'tac' => ['tabla' => 'tac', 'columna' => 'aseguradora_id'],
            'ingresos' => ['tabla' => 'ingresos', 'columna' => 'aseguradora_id'],
            'traslado_hospitalario' => ['tabla' => 'traslado_hospitalario', 'columna' => 'aseguradora_id'],
            'traslado_domicilio' => ['tabla' => 'traslado_domicilio', 'columna' => 'aseguradora_id'],
            'incidencias' => ['tabla' => 'incidencias', 'columna' => 'aseguradora_id']
        ];

        if (!isset($tablas[$opcion])) {
            throw new Exception("Opción '$opcion' no reconocida.");
        }

        $tabla = $tablas[$opcion]['tabla'];
        $columna = $tablas[$opcion]['columna'];

        $stmt = $conn->prepare("SELECT * FROM $tabla WHERE $columna = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

