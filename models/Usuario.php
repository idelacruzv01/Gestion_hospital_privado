<?php
require_once __DIR__ . '/../core/Database.php';

class Usuario {
    private $db;

    public function __construct() {
        $database = new Database(); // crear instancia
        $this->db = $database->getConnection(); // obtener conexión
    }

    /*OBTENER USUARIOS PARA EL LOGIN*/
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

    /*CARGAR LA LISTA DE USUARIOS EN ADMINISTRAR USUARIOS*/
    public function obtenerTodos() {
        $sql = "SELECT id, usuario, nombre_completo, tipo, fecha_creacion 
                FROM usuarios 
                ORDER BY id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*CREAR UN NUEVO USUARIO*/
    public function crearUsuario($usuario, $password, $nombre_completo, $tipo) {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO usuarios (usuario, clave, nombre_completo, tipo)
                    VALUES (:usuario, :clave, :nombre_completo, :tipo)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':clave', $passwordHash);//CIFRA LA CONTRASEÑA
            $stmt->bindParam(':nombre_completo', $nombre_completo);
            $stmt->bindParam(':tipo', $tipo);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }


}
