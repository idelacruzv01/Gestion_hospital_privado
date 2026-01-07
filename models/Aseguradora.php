<?php
require_once __DIR__ . '/../core/Database.php';

class Aseguradora {

    //-----OBTENER ASEGURADORAS-----//
    public static function obtenerTodas() {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "SELECT id, nombre, creado_por, creado_en, modificado_por, modificado_en
                FROM seguros_salud
                ORDER BY nombre ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //-----OBTENER ASEGURADORAS POR TIPO-----//
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

    //-----BUSCAR ASEGURADORAS POR NOMBRE-----//
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

    //-----GESTIÓN DE ASEGURADORAS DESDE editar-aseguradoras.php-----//
    //Listar todas las aseguradoras en editar-aseguradoras.php
    public static function listar(): array
    {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->query("SELECT id, nombre, tipo_aseguradora_id AS tipo, creado_por, creado_en, modificado_por, modificado_en FROM seguros_salud ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva aseguradora desde editar-aseguradoras.php
    public function crearAseguradora($datos)
    {
        $database = new Database();
        $conn = $database->getConnection();

        try {
            // Iniciamos transacción
            $conn->beginTransaction();

            // Insert principal en seguros_salud
            $sql = "INSERT INTO seguros_salud 
                    (nombre, telefono, horario, mail1, mail2, tipo_aseguradora_id, creado_por, creado_en)
                    VALUES (:nombre, :telefono, :horario, :mail1, :mail2, :tipo, :creado_por, :creado_en)";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nombre'     => $datos['nombre'],
                ':telefono'   => $datos['telefono'],
                ':horario'    => $datos['horario'],
                ':mail1'      => $datos['mail1'],
                ':mail2'      => $datos['mail2'],
                ':tipo'       => $datos['tipo'],
                ':creado_por' => $_SESSION['usuario'] ?? 'desconocido', 
                ':creado_en'  => date('Y-m-d H:i:s')
            ]);

            $aseguradoraId = $conn->lastInsertId();

            if ($aseguradoraId <= 0) {
                throw new Exception("No se generó ID de aseguradora");
            }

            // Inserts en tablas hijas (vacíos), incluyendo creado_por y creado_en
            $tablasHijas = [
                'antigenos',
                'ingresos',
                'protocolos_urgencias',
                'tac',
                'traslado_domicilio',
                'traslado_hospitalario'
            ];

            foreach ($tablasHijas as $tabla) {
                $sqlHija = "INSERT INTO {$tabla} (aseguradora_id, creado_por, creado_en)
                            VALUES (:id, :creado_por, :creado_en)";
                $stmtHija = $conn->prepare($sqlHija);
                $stmtHija->execute([
                    ':id'          => $aseguradoraId,
                    ':creado_por'  => $_SESSION['usuario'] ?? 'desconocido',
                    ':creado_en'   => date('Y-m-d H:i:s')
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

            // Devolvemos el error real para depuración
            return [
                'status'  => 'error',
                'mensaje' => $e->getMessage()
            ];
        }
    }


    //Eliminar aseguradora
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

    //FUNCION GENÉRICA PARA OBTENER DATOS DE LAS DISTINTAS SECCIONES DE EDICIÓN
    private function obtenerPorAseguradora(string $tabla, int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $database = new Database();
        $conn = $database->getConnection();

        $sql = "SELECT * FROM {$tabla} WHERE aseguradora_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    //FUNCIONES ESPECIFICAS PARA CADA SECCIÓN DE EDICIÓN
    public function obtenerContacto($id)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "SELECT * FROM seguros_salud WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public  function obtenerUrgencias($id)
    {
        return $this->obtenerPorAseguradora('protocolos_urgencias', $id);
    }
    public  function obtenerAntigenos($id)
    {
        return $this->obtenerPorAseguradora('antigenos', $id);
    }
    public  function obtenerIngresos($id)
    {
        return $this->obtenerPorAseguradora('ingresos', $id);
    }
    public  function obtenerTAC($id)
    {
        return $this->obtenerPorAseguradora('tac', $id);
    }
    public  function obtenerTrasladoDomicilio($id)
    {
        return $this->obtenerPorAseguradora('traslado_domicilio', $id);
    }
    public  function obtenerTrasladoOtroCentro($id)
    {
        return $this->obtenerPorAseguradora('traslado_hospitalario', $id);
    }

    //FUNCION GENERICA PARA GUARDAR DATOS DE LAS DISTINTAS SECCIONES DE EDICIÓN
    private function updatePorAseguradora(
        string $tabla,
        array $campos,
        int $aseguradoraId
    ): bool {
        if ($aseguradoraId <= 0 || empty($campos)) {
            return false;
        }

        $database = new Database();
        $conn = $database->getConnection();

        // --- AUDITORÍA ---
        $campos['modificado_por'] = $_SESSION['usuario'] ?? 'desconocido';
        $campos['modificado_en']  = date('Y-m-d H:i:s');

        $sets = [];
        $params = [];

        foreach ($campos as $columna => $valor) {
            $sets[] = "{$columna} = :{$columna}";
            $params[":{$columna}"] = $valor;
        }

        $params[':id'] = $aseguradoraId;

        $sql = "UPDATE {$tabla} SET " . implode(', ', $sets) . " WHERE aseguradora_id = :id";

        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }

    

    //FUNCIONES ESPECIFICAS PARA GUARDAR CADA SECCIÓN DE EDICIÓN

    public function guardarContacto(array $datos, int $aseguradoraId): bool
    {
        $campos = [
            'telefono' => $datos['telefono'] ?? null,
            'horario'  => $datos['horario'] ?? null,
            'mail1'    => $datos['mail1'] ?? null,
            'mail2'    => $datos['mail2'] ?? null
        ];

        if ($aseguradoraId <= 0 || empty($campos)) {
            return false;
        }

        $database = new Database();
        $conn = $database->getConnection();

        $sets = [];
        $params = [];

        foreach ($campos as $columna => $valor) {
            $sets[] = "{$columna} = :{$columna}";
            $params[":{$columna}"] = $valor;
        }

        $params[':id'] = $aseguradoraId;

        $sql = "UPDATE seguros_salud 
                SET " . implode(', ', $sets) . " 
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }


    public function guardarUrgencias(array $datos, int $aseguradoraId): bool
    {
        $campos = [
            'codigo_general'   => $datos['codigo_general'] ?? null,
            'codigo_pediatria' => $datos['codigo_pediatria'] ?? null,
            'terminal'         => $datos['terminal'] ?? null,
            'instrucciones'    => $datos['instrucciones'] ?? null
        ];

        return $this->updatePorAseguradora(
            'protocolos_urgencias',
            $campos,
            $aseguradoraId
        );
    }

    public function guardarAntigenos(array $datos, int $aseguradoraId): bool
    {
        $campos = [
            'precisa_autorizacion' => $datos['precisa_autorizacion'] ?? null,
            'codigo_aut'           => $datos['codigo_aut'] ?? null,
            'instrucciones'        => $datos['instrucciones'] ?? null
        ];

        return $this->updatePorAseguradora(
            'antigenos',
            $campos,
            $aseguradoraId
        );
    }

    public function guardarIngresos(array $datos, int $aseguradoraId): bool
    {
        $campos = [
            'autorizable_por_terminal' => $datos['autorizable_por_terminal'] ?? null,
            'autorizable_por_telefono' => $datos['autorizable_por_telefono'] ?? null,
            'telefono_autorizaciones'  => $datos['telefono_autorizaciones'] ?? null,
            'email_autorizaciones'     => $datos['email_autorizaciones'] ?? null,
            'instrucciones'            => $datos['instrucciones'] ?? null
        ];

        return $this->updatePorAseguradora('ingresos', $campos, $aseguradoraId);
    }

    public function guardarTac(array $datos, int $aseguradoraId): bool
    {
        $campos = [
            'precisa_autorizacion'     => $datos['precisa_autorizacion'] ?? null,
            'autorizable_por_terminal' => $datos['autorizable_por_terminal'] ?? null,
            'autorizable_por_telefono' => $datos['autorizable_por_telefono'] ?? null,
            'telefono_autorizaciones'  => $datos['telefono_autorizaciones'] ?? null,
            'email_autorizaciones'     => $datos['email_autorizaciones'] ?? null,
            'instrucciones'            => $datos['instrucciones'] ?? null,
            'tac_doble'                => $datos['tac_doble'] ?? null,
            'tac_con_contraste'        => $datos['tac_con_contraste'] ?? null
        ];

        return $this->updatePorAseguradora('tac', $campos, $aseguradoraId);
    }

    public function guardarTrasladoDomicilio(array $datos, int $aseguradoraId): bool
    {
        $campos = [
            'telefono_traslados' => $datos['telefono_traslados'] ?? null,
            'email_traslados'    => $datos['email_traslados'] ?? null,
            'instrucciones'      => $datos['instrucciones'] ?? null
        ];

        return $this->updatePorAseguradora('traslado_domicilio', $campos, $aseguradoraId);
    }
    public function guardarTrasladoHospitalario(array $datos, int $aseguradoraId): bool
    {
        $campos = [
            'telefono_traslados' => $datos['telefono_traslados'] ?? null,
            'email_traslados'    => $datos['email_traslados'] ?? null,
            'instrucciones'      => $datos['instrucciones'] ?? null
        ];

        return $this->updatePorAseguradora('traslado_hospitalario', $campos, $aseguradoraId);
    }
}