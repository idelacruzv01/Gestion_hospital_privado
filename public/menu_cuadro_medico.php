<?php require_once __DIR__ . '/../core/verificar_sesion.php'; ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Buscador Cuadro Médico</title>
        <link rel="stylesheet" href="css/estilo_menu.css">
        <link rel="stylesheet" href="css/estilo_urgencias.css">
        <link rel="stylesheet" href="css/estilo_usuarios.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>
        <header class="encabezado">
            <div class="header-left">
                <a href="menu_cuadro_medico.php" class="logo">
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

            <h1>Buscador Cuadro Médico</h1>

            <section class="buscador">
                <input type="text" id="buscarMedico" placeholder="Buscar especialidad médica...">
            </section>

            <section id="resultado_medicos" class="resultado-medicos">
                <!-- Aquí se mostrarán los resultados -->
            </section>

        </main>

        <script src="js/buscador.js"></script>
        
    </body>
</html>