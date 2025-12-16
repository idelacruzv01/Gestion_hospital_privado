<?php
require_once __DIR__ . '/../models/Buscador.php';

class BuscadorController {

    public function buscar(string $tipo, string $query): void {

        $config = $this->obtenerConfiguracion($tipo);

        if ($config === null) {
            throw new Exception('Tipo de búsqueda no válido');
        }

        $modelo = new Buscador();
        $resultados = $modelo->buscar(
            $config['tabla'],
            $config['columnas'],
            $config['busqueda'],
            $query
        );

        if (!$resultados) {
            echo "<p>No se encontraron resultados.</p>";
            return;
        }

        // Datos preparados para la vista
        $columnas  = $config['columnas'];
        $cabeceras = $config['cabeceras'];

        require __DIR__ . '/../views/buscador/tabla.php';
    }


    private function obtenerConfiguracion(string $tipo): ?array {

        $config = [
            'medicos' => [
                'tabla' => 'cuadro_medico',
                'columnas' => [
                    'nombre','especialidad','subespecialidad','edad',
                    'ubicacion','zona','seguros_excluidos','notas'
                ],
                'busqueda' => [
                    'especialidad','subespecialidad','ubicacion',
                    'zona','seguros_excluidos','notas'
                ],
                'cabeceras' => [
                    'Nombre','Especialidad','Subespecialidad','Edad',
                    'Ubicación','Zona','Seguros Excluidos','Notas'
                ]
            ],
            'precios' => [
                'tabla' => 'precios_privados',
                'columnas' => ['producto','especialidad','precio'],
                'busqueda' => ['producto','especialidad'],
                'cabeceras' => ['Producto','Especialidad','Precio']
            ],
            'telefonos' => [
                'tabla' => 'listado_telefonos',
                'columnas' => [
                    'servicio','ubicacion','contacto',
                    'telefono_fijo','extension','movil','email','notas'
                ],
                'busqueda' => [
                    'servicio','ubicacion','contacto',
                    'telefono_fijo','extension','movil','email'
                ],
                'cabeceras' => [
                    'Servicio / Nombre','Ubicación / Especialidad','Contacto',
                    'Teléfono Fijo','Extensión','Móvil','Email','Notas'
                ]
            ]
        ];

        return $config[$tipo] ?? null;
    }
}
