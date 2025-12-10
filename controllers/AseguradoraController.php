<?php
require_once __DIR__ . '/../models/Aseguradora.php';

class AseguradoraController
{
    public function mostrarAseguradorasPorTipo($tipo)
    {
        $tipo = trim($tipo);
        if (empty($tipo)) {
            echo "<p style='text-align:center; color:red;'>Tipo no especificado.</p>";
            return;
        }

        $aseguradoras = Aseguradora::obtenerPorTipo($tipo);

        require __DIR__ . '/../views/aseguradoras_por_tipo.php';
    }

    public function buscarAseguradoras($texto)
    {
        $texto = trim($texto);

        if (strlen($texto) < 3) {
            echo "<p style='text-align:center; color:gray;'>Introduce al menos 3 letras.</p>";
            return;
        }

        $aseguradoras = Aseguradora::buscarPorNombre($texto);

        // Si no hay resultados avisamos, pero siempre cargamos la misma vista
        $mensaje = empty($aseguradoras)
            ? "No se encontraron resultados."
            : null;

        require __DIR__ . '/../views/aseguradoras_busqueda.php';
    }
}
