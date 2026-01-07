<?php 

require_once __DIR__ . '/../core/verificar_sesion.php'; 
require_once __DIR__ . '/../controllers/AseguradoraController.php';

$controller = new AseguradoraController();
$aseguradoras = $controller->listarAseguradoras();
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Aseguradoras</title>
        <link rel="stylesheet" href="css/estilo_menu.css">
        <link rel="stylesheet" href="css/estilo_urgencias.css">
        <link rel="stylesheet" href="css/estilo_usuarios.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>
        <header class="encabezado">
            <div class="header-left">
                <a href="editar-aseguradoras.php" class="logo">
                    <img src="img/logo_header/logo_quiron.png" alt="Logo Quirónsalud" class="logo-header">
                </a>
            </div>

            <div class="header-right">
                <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></p>
                <p>Permisos: <strong><?php echo htmlspecialchars($_SESSION['tipo']); ?></strong></p>
            </div>

        </header>

        <main>

            <div class="barra-navegacion">
                <a href="menu_principal.php" class="btn-volver">
                    <i class="fas fa-house"></i> Menú Principal
                </a>
                <a href="logout.php" class="logout-link">Cerrar sesión</a>
            </div>

            <h1>Editar Aseguradoras</h1>

            <section id="resultado" class="resultado">
                <!-- Aquí se mostrarán los resultados -->
            </section>

            <div class="acciones-usuarios">
                <button class="boton-accion boton-primario" onclick="mostrarFormularioNuevaAseguradora()">
                    ➕ Agregar Nueva Aseguradora
                </button>
            </div>

            <!-- Tabla de aseguradoras -->
            <table class="tabla-crud" id="tabla-aseguradoras">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la Aseguradora</th>
                        <th>Creado Por</th>
                        <th>Creado En</th>
                        <th>Modificado Por</th>
                        <th>Modificado En</th>
                        <th>Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($aseguradoras)): ?>
                    <?php foreach ($aseguradoras as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['id']) ?></td>
                            <td><?= htmlspecialchars($a['nombre']) ?></td>
                            <td><?= htmlspecialchars($a['creado_por'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($a['creado_en'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($a['modificado_por'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($a['modificado_en'] ?? '-') ?></td>
                            <td>
                                <button class="boton-accion boton-editar" onclick="editarAseguradora(<?= (int)$a['id'] ?>)">✏️ Editar</button>
                                <button class="boton-accion boton-borrar" onclick="eliminarAseguradora(<?= (int)$a['id'] ?>)">🗑️ Eliminar</button>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No hay aseguradoras registradas.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>

            <!-- Formulario oculto para nueva aseguradora -->
            <div id="contenedor-form-nueva-aseguradora" class="form-admin" style="display:none;">
                <h4>Nueva Aseguradora</h4>

                <form id="form-nueva-aseguradora" onsubmit="guardarAseguradora(event)">
                    <label>Nombre de aseguradora:</label>
                    <input type="text" name="nombre" required>

                    <label>Teléfono:</label>
                    <input type="number" name="telefono" required>

                    <label>Horario:</label>
                    <input type="text" name="horario" required>

                    <label>Mail 1:</label>
                    <input type="text" name="mail1" required>

                    <label>Mail 2:</label>
                    <input type="text" name="mail2">

                    <label>Tipo Aseguradora:</label>
                    <select name="tipo" required>
                        <option value="1">Salud</option>
                        <option value="2">Accidentes</option>
                        <option value="3">Mutuas</option>
                        <option value="4">Privados</option>
                        <option value="5">Internacional</option>
                        <option value="6">Tráfico</option>
                    </select>

                    <div class="acciones">
                        <button type="submit" class="boton-accion boton-editar">Guardar y continuar</button>
                    </div>
                </form>
            </div>

            <!-- Contenedor para la edición específica de una aseguradora -->
            <div id="editar-aseguradora" class="menu-section" style="display:none;">
                </div>

            <!-- Contenedor para la edición de aseguradora -->
            <div id="contenedor-edicion" class="form-admin" style="display:none;"></div>


        </main>

        <script src="js/editar-aseguradoras.js"></script>
        
    </body>
</html>