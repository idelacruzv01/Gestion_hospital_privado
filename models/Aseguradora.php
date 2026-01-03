<?php
require_once __DIR__ . '/../core/Database.php';

class Aseguradora {

    public static function obtenerTodas() {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "SELECT id, nombre
                FROM seguros_salud
                ORDER BY nombre ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    //Crear una nueva aseguradora desde edtiar-aseguradoas.php
    public function crearAseguradora($datos)
{
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Iniciamos transacción
        $conn->beginTransaction();

        // Insert principal
        $sql = "INSERT INTO seguros_salud 
                (nombre, telefono, horario, mail1, mail2, tipo_aseguradora_id)
                VALUES (:nombre, :telefono, :horario, :mail1, :mail2, :tipo)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre'   => $datos['nombre'],
            ':telefono' => $datos['telefono'],
            ':horario'  => $datos['horario'],
            ':mail1'    => $datos['mail1'],
            ':mail2'    => $datos['mail2'],
            ':tipo'     => $datos['tipo']
        ]);

        $aseguradoraId = $conn->lastInsertId();

        if ($aseguradoraId <= 0) {
            throw new Exception("No se generó ID de aseguradora");
        }

        /* INSERTS MANUALES TABLA A TABLA 

        // 1. Antígenos
        $sql = "INSERT INTO antigenos (aseguradora_id) VALUES (:id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $aseguradoraId]);

        // 2. Protocolos de urgencias
        $sql = "INSERT INTO protocolos_urgencias (aseguradora_id) VALUES (:id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $aseguradoraId]);

        // 3. Ingresos
        $sql = "INSERT INTO ingresos (aseguradora_id) VALUES (:id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $aseguradoraId]);

        // 4. TAC
        $sql = "INSERT INTO tac (aseguradora_id) VALUES (:id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $aseguradoraId]);

        // 5. Traslado domicilio
        $sql = "INSERT INTO traslado_domicilio (aseguradora_id) VALUES (:id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $aseguradoraId]);

        // 7. Traslado hospitalario
        $sql = "INSERT INTO traslado_hospitalario (aseguradora_id) VALUES (:id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $aseguradoraId]);
*/        
        // Inserts en tablas hijas (vacíos)
        $tablasHijas = [
            'antigenos',
            'ingresos',
            'protocolos_urgencias',
            'tac',
            'traslado_domicilio',
            'traslado_hospitalario'
        ];

        foreach ($tablasHijas as $tabla) {
            $sqlHija = "INSERT INTO {$tabla} (aseguradora_id) VALUES (:id)";
            $stmtHija = $conn->prepare($sqlHija);
            $stmtHija->execute([
                    ':id' => $aseguradoraId
                ]);
        }

        // Confirmamos todo
        $conn->commit();

        return [
            'status' => 'ok',
            'id'     => $aseguradoraId
        ];

    } catch (Exception $e) {

        // Si algo falla, deshacemos TODO
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        // DEVOLVEMOS EL ERROR REAL (clave para depurar)
        return [
            'status'  => 'error',
            'mensaje' => $e->getMessage()
        ];
    }
}

    /*Eliminar aseguradora*/
    public function eliminar($id) {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "DELETE FROM seguros_salud WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }   

    //Obtener datos de una aseguradora por su ID
    public function obtenerPorId($id) {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "SELECT *
                FROM seguros_salud
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Obtener los datos de traslado a domicilio de una aseguradora
    public function obtenerTrasladoDomicilio($id)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "SELECT *
                FROM traslado_domicilio
                WHERE aseguradora_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //UPDATE traslado a domicilio
    public function guardarTrasladoDomicilio($datos)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "UPDATE traslado_domicilio
                SET telefono_traslados = :telefono,
                    email_traslados = :email,
                    instrucciones = :instrucciones
                WHERE aseguradora_id = :id";

        $stmt = $conn->prepare($sql);

        // Ejecutamos asegurándonos de que todas las claves existan
        $exito = $stmt->execute([
            ':telefono'      => $datos['telefono_traslados'] ?? '',
            ':email'         => $datos['email_traslados'] ?? '',
            ':instrucciones' => $datos['instrucciones'] ?? '',
            ':id'            => $datos['id'] ?? 0 // nunca vacío
        ]);

        return ['ok' => (bool)$exito];
    }


}