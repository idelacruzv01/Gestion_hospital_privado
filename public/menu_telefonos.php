<?php require_once __DIR__ . '/../core/verificar_sesion.php'; ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Buscador de Telefonos</title>
        <link rel="stylesheet" href="css/estilo_menu.css">
        <link rel="stylesheet" href="css/estilo_urgencias.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>
        <header class="encabezado">
            <div class="header-left">
                <a href="menu_telefonos.php" class="logo">
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

            <h1>Buscador de Teléfonos</h1>

            <section class="buscador">
                <input type="text" id="buscarTelefono" placeholder="Buscar un número de teléfono...">
            </section>

            <section id="resultado_telefonos" class="resultado_telefonos">
                <!-- Aquí se mostrarán los resultados -->
            </section>

        </main>

        <script src="js/buscador.js"></script>
        
    </body>
</html>