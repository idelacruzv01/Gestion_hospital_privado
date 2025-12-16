<?php
require_once __DIR__ . '/../core/Database.php';

class Buscador {

    /**
     * Realiza la búsqueda en la tabla especificada usando los campos indicados.
     *
     * @param string $tabla Nombre de la tabla
     * @param array $columnas Columnas a seleccionar
     * @param array $camposBusqueda Columnas en las que buscar
     * @param string $query Texto de búsqueda
     * @return array Resultados encontrados
     */
    public function buscar(
        string $tabla,
        array $columnas,
        array $camposBusqueda,
        string $query
    ): array {

        $db = new Database();
        $conn = $db->getConnection();

        // Creamos placeholders únicos para cada campo de búsqueda
        $where = [];
        $params = [];
        foreach ($camposBusqueda as $i => $campo) {
            $placeholder = ":query$i";
            $where[] = "$campo LIKE $placeholder";
            $params[$placeholder] = "%$query%";
        }

        $sql = "
            SELECT " . implode(', ', $columnas) . "
            FROM $tabla
            WHERE " . implode(' OR ', $where) . "
            LIMIT 20
        ";

        $stmt = $conn->prepare($sql);

        // Enlazamos todos los parámetros de forma segura
        foreach ($params as $placeholder => $value) {
            $stmt->bindValue($placeholder, $value, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
