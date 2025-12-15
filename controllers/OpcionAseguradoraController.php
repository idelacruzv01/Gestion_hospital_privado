<?php
require_once __DIR__ . '/../models/OpcionAseguradora.php';

class OpcionAseguradoraController {
    public function mostrar($opcion, $id = null) {
        try {
            $opcion = strtolower(trim($opcion)); // Normaliza la opción

            // Llama al método y dirige a la vista de cada opción solicitada
            $datos = OpcionAseguradora::obtener($opcion, $id);
            $rutaVista = __DIR__ . "/../views/opciones/{$opcion}.php";
            if (file_exists($rutaVista)) {
                require $rutaVista;
            } else {
                echo "<p>Error: la vista para la opción '{$opcion}' no existe.</p>";
            }

        } catch (Exception $e) {
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
