<?php 

require_once __DIR__ . '/../core/verificar_sesion.php'; 
require_once __DIR__ . '/../controllers/UsuarioController.php';

$controller = new UsuarioController();
$usuarios = $controller->listarUsuarios();

if ($_SESSION['tipo'] !== 'admin') {
    header("Location: menu_principal.php?error=" . urlencode("No tienes permisos para acceder."));
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administrar Usuarios</title>
        <link rel="stylesheet" href="css/estilo_menu.css">
        <link rel="stylesheet" href="css/estilo_usuarios.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>
        <header class="encabezado">
            <div class="header-left">
                <a href="administrar_usuarios.php" class="logo">
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

            <h1>Administrar Usuarios</h1>

            <div class="acciones-usuarios">
                <button class="boton-accion boton-primario" onclick="mostrarFormularioNuevoUsuario()">
                    ➕ Agregar Nuevo Usuario
                </button>
            </div>


            <!-- Tabla de usuarios -->
            <table class="tabla-crud">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre completo</th>
                        <th>Rol</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['usuario']) ?></td>
                            <td><?= htmlspecialchars($u['nombre_completo']) ?></td>
                            <td><?= htmlspecialchars($u['tipo']) ?></td>
                            <td><?= htmlspecialchars($u['fecha_creacion']) ?></td>
                            <td>
                                <button class="boton-accion boton-editar" onclick="editarUsuario(<?= (int)$u['id'] ?>)">✏️ Editar</button>
                                <button class="boton-accion boton-borrar" onclick="eliminarUsuario(<?= (int)$u['id'] ?>)">🗑️ Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No hay usuarios registrados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>

            <!-- Formulario oculto para nuevo usuario -->
            <div id="contenedor-form-nuevo-usuario" class="form-nueva-aseguradora" style="display:none;">
                <h4>Nuevo Usuario</h4>

                <form id="form-nuevo-usuario" onsubmit="guardarUsuario(event)">
                    <label>Nombre de usuario:</label>
                    <input type="text" name="usuario" required>

                    <label>Contraseña:</label>
                    <input type="password" name="password" required>

                    <label>Nombre completo:</label>
                    <input type="text" name="nombre_completo" required>

                    <label>Tipo (Rol):</label>
                    <select name="tipo" required>
                        <option value="admin">Administrador</option>
                        <option value="super">Supervisor</option>
                        <option value="user">Empleado</option>
                    </select>

                    <div class="acciones">
                        <button type="submit" class="boton-accion boton-editar">Guardar</button>
                    </div>
                </form>
            </div>

            <!--Formulario oculto para editar usuario -->
            <div id="contenedor-form-editar-usuario" class="form-nueva-aseguradora" style="display:none;">
                <h4>Editar Usuario</h4>

                <form id="form-editar-usuario" onsubmit="guardarCambiosUsuario(event)">
                    
                    <input type="hidden" name="id" id="editar-id">

                    <label>Nombre de usuario:</label>
                    <input type="text" name="usuario" id="editar-usuario" required>

                    <label>Nombre completo:</label>
                    <input type="text" name="nombre_completo" id="editar-nombre" required>

                    <label>Tipo:</label>
                    <select name="tipo" id="editar-tipo" required>
                        <option value="admin">Administrador</option>
                        <option value="super">Supervisor</option>
                        <option value="user">Empleado</option>
                    </select>

                    <div class="acciones">
                        <button type="submit" class="boton-accion boton-editar">Guardar Cambios</button>
                    </div>
                </form>
            </div>


        </main>

        <footer>
            <p>&copy; 2025 Hospital Quirónsalud Toledo</p>
        </footer>

        <script src="js/usuarios.js"></script>

    </body>
</html>