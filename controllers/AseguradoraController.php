<?php
require_once __DIR__ . '/../models/Aseguradora.php';

class AseguradoraController
{
    private $aseguradoraModel;

    public function __construct() {
        $this->aseguradoraModel = new Aseguradora();
    }

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

    // Obtener lista de aseguradoras para editar-aseguradoras.php
    public function listarAseguradoras() {
        return $this->aseguradoraModel->obtenerTodas();
    }

    //Crear una nueva aseguradora desde editar-aseguradoras.php
    public function crearAseguradora()
    {
        $campos = ['nombre', 'telefono', 'horario', 'mail1', 'mail2', 'tipo'];

        foreach ($campos as $campo) {
            if (empty($_POST[$campo])) {
                return [
                    'status' => 'error',
                    'mensaje' => 'Faltan datos obligatorios'
                ];
            }
        }

        $datos = [
            'nombre'   => trim($_POST['nombre']),
            'telefono' => trim($_POST['telefono']),
            'horario'  => trim($_POST['horario']),
            'mail1'    => trim($_POST['mail1']),
            'mail2'    => trim($_POST['mail2']),
            'tipo'     => (int) $_POST['tipo']
        ];

        $resultado = $this->aseguradoraModel->crearAseguradora($datos); 

        if ($resultado['status'] === 'ok') {
            return $resultado; // devuelve status + id
        }

        return [
            'status' => 'error',
            'mensaje' => 'Error al crear la aseguradora'
        ];
    }

}
