<?php require_once __DIR__ . '/../core/verificar_sesion.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="css/estilo_menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <header class="encabezado">
        <div class="header-left">
            <a href="menu_principal.php" class="logo">
                <img src="img/logo_header/logo_quiron.png" alt="Logo Quirónsalud" class="logo-header">
            </a>
        </div>

        <div class="header-right">
            <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></p>
            <p>Permisos: <strong><?php echo htmlspecialchars($_SESSION['tipo']); ?></strong></p>
        </div>

    </header>

    <main>

        <div class="cerrar_sesion">
            <a href="logout.php" class="logout-link">Cerrar sesión</a>
        </div>

        <h1>Menú Principal</h1>

        <!-- ================= SERVICIOS ================= -->
        <section class="menu-section">
            <h2 class="menu-title">Servicios</h2>
            <div class="menu-grid">
                <button class="btn-menu" data-tipo="urgencias" data-url="menu_urgencias.php">
                    <i class="fas fa-briefcase-medical"></i>
                    <span>Urgencias</span>
                </button>
                <button class="btn-menu" data-tipo="consultas" data-url="menu_consultas.php">
                    <i class="fas fa-stethoscope"></i>
                    <span>Consultas</span>
                </button>
                <button class="btn-menu" data-tipo="rayos" data-url="menu_rayos.php">
                    <i class="fas fa-x-ray"></i>
                    <span>Rayos</span>
                </button>
            </div>
        </section>

        <!-- ================= BUSCADORES ================= -->
        <section class="menu-section">
            <h2 class="menu-title">Buscadores</h2>
            <div class="menu-grid">
                <button class="btn-menu" data-tipo="precios_privados" data-url="menu_privados.php">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Precios Privados</span>
                </button>
                <button class="btn-menu" data-tipo="cuadro_medico" data-url="menu_cuadro_medico.php">
                    <i class="fas fa-hospital-user"></i>
                    <span>Cuadro médico</span>
                </button>
                <button class="btn-menu" data-tipo="listado_telefonos" data-url="menu_telefonos.php">
                    <i class="fas fa-address-book"></i>
                    <span>Listado de teléfonos</span>
                </button>
            </div>
        </section>

    <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin'): ?>
        <!-- ================= ADMINISTRAR USUARIOS ================= -->
        <section class="menu-section">
            <h2 class="menu-title">Administrar Usuarios</h2>
            <div class="menu-grid">
                <button class="btn-menu" data-tipo="administrar_usuarios" data-url="administrar_usuarios.php">
                    <i class="fas fa-users-cog"></i>
                    <span>Administrar Usuarios</span>
                </button>
            </div>
        </section>
    <?php endif; ?>

        <section id="resultado"></section>
    </main>

    <footer>
        <p>&copy; 2025 Hospital Quirónsalud Toledo</p>
    </footer>

    <script src="js/menu.js"></script>

</body>

</html>