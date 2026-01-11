<?php require_once __DIR__ . '/../core/verificar_sesion.php'; ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menú Urgencias</title>
        <link rel="stylesheet" href="css/estilo_menu.css">
        <link rel="stylesheet" href="css/estilo_urgencias.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>
        <header class="encabezado">
            <div class="header-left">
                <a href="menu_urgencias.php" class="logo">
                    <img src="img/logo_header/logo_hospital_2.png" alt="Logo Quirónsalud" class="logo-header">
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

            <h1>Menú de Urgencias</h1>

            <section class="buscador">
                <input type="text" id="buscarAseguradora" placeholder="Buscar aseguradora...">
            </section>

            <section class="menu">

                <button class="btn-menu" data-tipo="salud" id="btn-seguros-salud">
                    <i class="fas fa-user-md"></i>
                    <span>Seguros Salud</span>
                </button>
                
                <button class="btn-menu" data-tipo="accidentes" id="btn-seguros-deportes">
                    <i class="fas fa-running"></i>
                    <span>Seguros Deportivos y Accidentes</span>
                </button>
                
                <button class="btn-menu" data-tipo="mutuas" id="btn-mutuas-laborales">
                    <i class="fas fa-briefcase-medical"></i>
                    <span>Mutuas Laborales</span>
                </button>
                
                <button class="btn-menu" data-tipo="privados">
                    <i class="fas fa-user"></i>
                    <span>Privados</span>
                </button>
                
                <button class="btn-menu" data-tipo="internacional">
                    <i class="fas fa-globe"></i>
                    <span>Internacional</span>
                </button>
                
                <button class="btn-menu" data-tipo="trafico">
                    <i class="fas fa-car-crash"></i>
                    <span>Tráfico</span>
                </button>
                
                <!--SOLO LOS SUPERVISORES PUEDEN MODIFICAR LOS DATOS DE LAS ASEGURADORAS-->
                <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'super'): ?>
                
                <button class="btn-menu btn-menu-editar" data-url="editar-aseguradoras.php">  
                    <i class="fas fa-pencil-alt"></i>
                    <span>Editar Aseguradoras</span>
                </button>

                
                <?php endif; ?>
                
            </section>

            <section id="resultado"></section>
            <!--AQUÍ SE CARGAN LOS BOTONES DE LAS OPCIONES PARA CADA RESULTADO DE ASEGURADORA SELECCIONADA-->
            <section id="resultado-opcion"></section>
        </main>

        <footer>
            <p>&copy; 2025 Hospital Privado Toledo</p>
        </footer>

        <script src="js/aseguradoras.js"></script>
    </body>
</html>