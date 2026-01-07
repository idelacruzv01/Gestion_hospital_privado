<?php
require_once __DIR__ . '/../models/Aseguradora.php';

class AseguradoraController
{
    private $aseguradoraModel;

    public function __construct() {
        $this->aseguradoraModel = new Aseguradora();
    }

    //-----VISTAS DE ASEGURADORAS-----//
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

    //-----BÚSQUEDA DE ASEGURADORAS-----//
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

    //-----GESTIÓN DE ASEGURADORAS DESDE editar-aseguradoras.php-----//
    //Listar todas las aseguradoras en editar-aseguradoras.php
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

    //EDITAR Y GUARDAR SECCIONES DE LA ASEGURADORA

    //FUNCIÓN GENÉRICA PARA GUARDAR DATOS DE CUALQUIER SECCIÓN
    private function guardarSeccion(
        array $data,
        callable $modelCallback,
        array $mapping
    ) {
        if (empty($data['aseguradora_id']) || !is_numeric($data['aseguradora_id'])) {
            return ['ok' => false, 'mensaje' => 'ID de aseguradora no válido'];
        }

        $aseguradoraId = (int)$data['aseguradora_id'];

        $payload = [];

        foreach ($mapping as $origen => $destino) {
            $payload[$destino] = $data[$origen] ?? null;
        }

        $ok = $modelCallback($payload, $aseguradoraId);

        return $ok
            ? ['ok' => true]
            : ['ok' => false, 'mensaje' => 'No se pudo guardar'];
    }


    //-----SECCIONES DE LA ASEGURADORA-----//

    //-----CONTACTO-----//
    //Editar CONTACTO desde editar-aseguradoras.php
    public function editarContacto($id)
    {
        if (!is_numeric($id)) {
            echo "<p>ID no válido</p>";
            return;
        }
        $datos = $this->aseguradoraModel->obtenerContacto($id);
        if (!$datos) {
            echo "<p>No hay datos de contacto</p>";
            return;
        }
        require __DIR__ . '/../views/edicion/editar_contacto.php';
    }
    //Guardar CONTACTO desde editar-aseguradoras.php
    public function guardarContacto($data)
    {
        return $this->guardarSeccion(
            $data,
            [$this->aseguradoraModel, 'guardarContacto'],
            [
                'telefono' => 'telefono',
                'horario'  => 'horario',
                'mail1'   => 'mail1',
                'mail2'   => 'mail2',
                'horario'  => 'horario'
            ]
        );
    }

    //-----URGÊNCIAS-----//
    //Editar URGENCIAS desde editar-aseguradoras.php
    public function editarUrgencias($id)
    {
        if (!is_numeric($id)) {
            echo "<p>ID no válido</p>";
            return;
        }
        $datos = $this->aseguradoraModel->obtenerUrgencias($id);
        if (!$datos) {
            echo "<p>No hay datos de urgencias</p>";
            return;
        }
        require __DIR__ . '/../views/edicion/editar_urgencias.php';
    }
    //Guardar URGENCIAS desde editar-aseguradoras.php
    public function guardarUrgencias($data)
    {
        return $this->guardarSeccion(
            $data,
            [$this->aseguradoraModel, 'guardarUrgencias'],
            [
                'codigo_general'   => 'codigo_general',
                'codigo_pediatria' => 'codigo_pediatria',
                'terminal'         => 'terminal',
                'instrucciones'    => 'instrucciones'
            ]
        );
    }

    //Editar ANTÍGENOS desde editar-aseguradoras.php
    public function editarAntigenos($id)
    {
        if (!is_numeric($id)) {
            echo "<p>ID no válido</p>";
            return;
        }
        $datos = $this->aseguradoraModel->obtenerAntigenos($id);
        if (!$datos) {
            echo "<p>No hay datos de antígenos</p>";
            return;
        }
        require __DIR__ . '/../views/edicion/editar_antigenos.php';
    }
    //Guardar ANTÍGENOS desde editar-aseguradoras.php
    public function guardarAntigenos($data)
    {
        return $this->guardarSeccion(
            $data,
            [$this->aseguradoraModel, 'guardarAntigenos'],
            [
                'precisa_autorizacion'     => 'precisa_autorizacion',
                'codigo_aut'               => 'codigo_aut',
                'instrucciones_antigenos'  => 'instrucciones'
            ]
        );
    }

    
    //Editar INGRESOS desde editar-aseguradoras.php
    public function editarIngresos($id)
    {
        if (!is_numeric($id)) {
            echo "<p>ID no válido</p>";
            return;
        }
        $datos = $this->aseguradoraModel->obtenerIngresos($id);
        if (!$datos) {
            echo "<p>No hay datos de ingresos</p>";
            return;
        }
        require __DIR__ . '/../views/edicion/editar_ingresos.php';
    }
    // Guardar INGRESOS desde editar-aseguradoras.php
    public function guardarIngresos($data)
    {
        return $this->guardarSeccion(
            $data,
            [$this->aseguradoraModel, 'guardarIngresos'],
            [
                'autorizable_por_terminal' => 'autorizable_por_terminal',
                'autorizable_por_telefono' => 'autorizable_por_telefono',
                'telefono_autorizaciones'  => 'telefono_autorizaciones',
                'email_autorizaciones'     => 'email_autorizaciones',
                'instrucciones'   => 'instrucciones'
            ]
        );
    }


    //Editar TAC desde editar-aseguradoras.php
    public function editarTAC($id)
    {
        if (!is_numeric($id)) {
            echo "<p>ID no válido</p>";
            return;
        }
        $datos = $this->aseguradoraModel->obtenerTAC($id);
        if (!$datos) {
            echo "<p>No hay datos de TAC</p>";
            return;
        }
        require __DIR__ . '/../views/edicion/editar_tac.php';
    }
    // Guardar TAC desde editar-aseguradoras.php
public function guardarTac($data)
{
    return $this->guardarSeccion(
        $data,
        [$this->aseguradoraModel, 'guardarTac'],
        [
            'precisa_autorizacion'     => 'precisa_autorizacion',
            'autorizable_por_terminal' => 'autorizable_por_terminal',
            'autorizable_por_telefono' => 'autorizable_por_telefono',
            'telefono_autorizaciones'  => 'telefono_autorizaciones',
            'email_autorizaciones'     => 'email_autorizaciones',
            'instrucciones'            => 'instrucciones',
            'tac_doble'                => 'tac_doble',
            'tac_con_contraste'        => 'tac_con_contraste'
        ]
    );
}
    

    //Editar TRASLADO A DOMICILIO desde editar-aseguradoras.php
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
    //Guardar TRASLADO A DOMICILIO desde editar-aseguradoras.php
    public function guardarTrasladoDomicilio($data)
    {
        return $this->guardarSeccion(
            $data,
            [$this->aseguradoraModel, 'guardarTrasladoDomicilio'],
            [
                'telefono_traslados' => 'telefono_traslados',
                'email_traslados'    => 'email_traslados',
                'instrucciones'      => 'instrucciones'
            ]
        );
    }

    //Editar TRASLADO A OTRO CENTRO desde editar-aseguradoras.php
    public function editarTrasladoOtroCentro($id)
    {
        if (!is_numeric($id)) {
            echo "<p>ID no válido</p>";
            return;
        }
        $datos = $this->aseguradoraModel->obtenerTrasladoOtroCentro($id);
        if (!$datos) {
            echo "<p>No hay datos de traslado a otro centro</p>";
            return;
        }
        require __DIR__ . '/../views/edicion/editar_traslado_otro_centro.php';
    }   
    //Guardar TRASLADO A OTRO CENTRO desde editar-aseguradoras.php
    public function guardarTrasladoHospitalario($data)
    {
        return $this->guardarSeccion(
            $data,
            [$this->aseguradoraModel, 'guardarTrasladoHospitalario'],
            [
                'telefono_traslados' => 'telefono_traslados',
                'email_traslados'    => 'email_traslados',
                'instrucciones'      => 'instrucciones'
            ]
        );
    }




}
