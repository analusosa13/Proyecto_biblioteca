<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Panel Alumno' ?> | Café con Letras</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* ==========================================================
           PALETA DE COLORES (COPIADA DE LA PLANTILLA ADMIN)
           ========================================================== */
        :root {
            --color-primary-bg: #F8F5EF; /* Beige muy claro, fondo general del contenido */
            --color-secondary-bg: #FEFEFE; /* Blanco, fondo de tarjetas y sidebar */
            --color-header-bg: #F2EFE9; /* Tono más claro para el encabezado/barra */
            --color-accent-soft: #E6D8D2; /* Tono pastel para hover y botones suaves */
            --color-accent-medium: #C6A89C; /* Rosa/Café suave, para fondo de botón activo y bordes */
            --color-accent-strong: #A35F3D; /* Café oscuro, para texto de marca, footer y hover fuerte */
            --color-text-dark: #4A4A4A; /* Texto principal oscuro */
            --color-text-subtle: #8B8780; /* Texto secundario/menú */
            /* Estilos de Dashboard */
            --color-card-bg: #E6D8D2; /* Fondo claro para los botones/cards */
            --color-card-border: #C6A89C;
            --color-card-shadow: rgba(0, 0, 0, 0.1);

            /* Clases copiadas del panel.php admin para usar en el dashboard del alumno */
            --admin-kpi-card-bg: var(--color-card-bg);
            --admin-kpi-card-border: var(--color-card-border);
            --admin-kpi-card-shadow: var(--color-card-shadow);
        }

        /* ==========================================================
           ESTILOS BASE Y LAYOUT
           ========================================================== */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-primary-bg);
            margin: 0;
            padding: 0;
            color: var(--color-text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .page-wrapper {
            display: flex;
            flex: 1;
            width: 100%;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .main-content {
            padding: 0; 
            min-height: calc(100vh - 160px); 
        }

        /* ==========================================================
           HEADER
           ========================================================== */
        .main-header {
            background-color: var(--color-header-bg);
            border-bottom: 1px solid var(--color-accent-medium);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }
        .header-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-accent-strong);
            text-decoration: none;
        }
        .header-user-info {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--color-text-dark);
        }
        .header-user-info a {
            margin-left: 15px;
            color: var(--color-accent-strong);
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid var(--color-accent-strong);
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .header-user-info a:hover {
            background-color: var(--color-accent-soft);
        }
        .user-name {
            font-weight: 600;
        }

        /* ==========================================================
           SIDEBAR (Menú Lateral)
           ========================================================== */
        .main-sidebar {
            width: 250px;
            background-color: var(--color-secondary-bg);
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            border-right: 1px solid #EBE7E2;
            flex-shrink: 0;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .menu-item a {
            display: block;
            padding: 12px 20px;
            color: var(--color-text-dark);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
            border-left: 3px solid transparent;
        }
        .menu-item a i {
            margin-right: 10px;
            width: 18px; 
            text-align: center;
        }
        .menu-item a:hover {
            background-color: var(--color-accent-soft);
            color: var(--color-accent-strong);
        }
        .menu-item.active a {
            background-color: var(--color-accent-medium);
            color: var(--color-secondary-bg); 
            border-left: 3px solid var(--color-accent-strong);
            font-weight: 600;
        }

        /* ==========================================================
           FOOTER
           ========================================================== */
        .main-footer {
            background-color: var(--color-header-bg);
            border-top: 1px solid var(--color-accent-medium);
            padding: 15px 30px;
            text-align: center;
            font-size: 0.8rem;
            color: var(--color-text-subtle);
            flex-shrink: 0;
        }

        /* ==========================================================
           ESTILOS COPIADOS DEL DASHBOARD ADMIN (Para el Alumno)
           ========================================================== */
        .dashboard-container {
            padding: 30px;
            background-color: var(--color-secondary-bg);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Adaptado para 2 o 3 columnas flexibles */
            gap: 20px;
            margin-bottom: 30px;
        }
        /* Clase reutilizada para tarjetas clave (KPIs) */
        .kpi-card {
            background-color: var(--admin-kpi-card-bg);
            border: 1px solid var(--admin-kpi-card-border);
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px var(--admin-kpi-card-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: var(--color-text-dark);
            display: block;
        }
        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px var(--admin-kpi-card-shadow);
            background-color: var(--color-accent-soft);
        }
        .kpi-card h3 {
            margin-top: 0;
            font-size: 1.2rem;
            color: var(--color-accent-strong);
        }
        .section-title {
            font-size: 1.8rem;
            color: var(--color-text-dark);
            margin-bottom: 25px;
            border-bottom: 1px solid var(--color-accent-soft);
            padding-bottom: 10px;
        }
    </style>
    
    <?= $extra_head ?? '' ?>
</head>
<body>
    <header class="main-header">
        <a href="<?= base_url('alumno') ?>" class="header-logo">
            ☕ Café con Letras | Alumno
        </a>
        <div class="header-user-info">
            Bienvenido(a), <span class="user-name"><?= session('nombre') . ' ' . session('apellido') ?></span>
            <a href="<?= base_url('login/salir') ?>"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </div>
    </header>

    <div class="page-wrapper">
        <aside class="main-sidebar">
            <ul class="sidebar-menu">
                <li class="menu-item <?= ($menu_activo ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <a href="<?= base_url('alumno') ?>">
                         Dashboard
                    </a>
                </li>
                <li class="menu-item <?= ($menu_activo ?? '') === 'catalogo' ? 'active' : '' ?>">
                    <a href="<?= base_url('alumno/catalogo') ?>">
                        Catálogo de Libros
                    </a>
                </li>
                <li class="menu-item <?= ($menu_activo ?? '') === 'prestamos' ? 'active' : '' ?>">
                    <a href="<?= base_url('alumno/prestamos') ?>">
                        Mis Préstamos
                    </a>
                </li>
            </ul>
        </aside>

        <main class="content-wrapper">
            <?php if (!empty($titulo)): ?>
                <h1 class="section-title"><?= esc($titulo) ?></h1>
            <?php endif; ?>

            <div class="main-content">
                <?= $contenido ?? '' ?>
            </div>
        </main>
    </div>

    <footer class="main-footer">
        &copy; <?= date('Y') ?> Café con Letras | Portal de Alumnos
    </footer>
    <?= $extra_footer ?? '' ?>
</body>
</html>