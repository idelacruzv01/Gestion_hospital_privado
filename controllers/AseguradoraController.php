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

    
    // Eliminar aseguradora desde editar-aseguradoras.php
    public function eliminarAseguradora($id)
    {
        // Validar que llega un ID correcto
        if (!isset($id) || empty($id) || !is_numeric($id)) {
            return [
                'status' => 'error',
                'mensaje' => 'ID de aseguradora no válido.'
            ];
        }

        // Llamar al modelo
        $resultado = $this->aseguradoraModel->eliminar($id);

        if ($resultado) {
            return [
                'status' => 'ok',
                'mensaje' => 'Aseguradora eliminada correctamente.'
            ];
        } else {
            return [
                'status' => 'error',
                'mensaje' => 'No se pudo eliminar la aseguradora.'
            ];
        }
    }

    // Editar aseguradora desde editar-aseguradoras.php
    public function editarAseguradora($id)
    {
        // Validar que llega un ID correcto
        if (!isset($id) || empty($id) || !is_numeric($id)) {
            return [
                'status' => 'error',
                'mensaje' => 'ID de aseguradora no válido.'
            ];
        }

        // Redirigir a la vista de edición con los datos actuales
        $aseguradora = $this->aseguradoraModel->obtenerPorId($id);  
        if (!$aseguradora) {
            return [
                'status' => 'error',
                'mensaje' => 'Aseguradora no encontrada.'
            ];
        }
        require __DIR__ . '/../views/editar_aseguradora.php';

    }

    //Editar traslado a domicilio desde editar-aseguradoras.php
    public function editarTrasladoDomicilio($id)
    {
        if (!is_numeric($id)) {
            echo "<p>ID no válido</p>";
            return;
        }

        $datos = $this->aseguradoraModel->obtenerTrasladoDomicilio($id);

        if (!$datos) {
            echo "<p>No hay datos de traslado domicilio</p>";
            return;
        }

        require __DIR__ . '/../views/edicion/editar_traslado_domicilio.php';
    }

    //Guardar traslado a domicilio desde editar-aseguradoras.php
    public function guardarTrasladoDomicilio($data)
    {
        // Validar que llega ID de aseguradora
        if (empty($data['aseguradora_id'])) {
            return [
                'ok' => false,
                'error' => 'ID de aseguradora no recibido'
            ];
        }

        // Mapear datos para que el modelo reciba las claves correctas
        $traslado = [
            'id' => (int)$data['aseguradora_id'], // obligatorio para WHERE
            'telefono_traslados' => $data['telefono_traslados'] ?? '',
            'email_traslados'    => $data['email_traslados'] ?? '',
            'instrucciones'      => $data['instrucciones'] ?? ''
        ];

        // Llamada al modelo
        $resultado = $this->aseguradoraModel->guardarTrasladoDomicilio($traslado);

        // Devolver resultado
        return $resultado;
    }

}
