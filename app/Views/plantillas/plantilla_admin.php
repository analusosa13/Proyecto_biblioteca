<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Panel de Administración' ?> | Café con Letras</title>
    <style>
        /* ==========================================================
           PALETA DE COLORES (Basada en el Login y Dashboard)
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
            /* Ya no tiene color de fondo ni sombra, lo tiene la plantilla del dashboard */
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

        /* [Estilos Responsive Omitidos por brevedad, asume que están aquí] */
        @media (max-width: 768px) {
            /* ... (Tus estilos responsive) ... */
        }
    </style>
    <?= $extra_head ?? '' ?>
</head>
<body>
    <header class="main-header">
        <a href="<?= base_url('panel/admin') ?>" class="header-logo">
            <i class="fas fa-mug-hot"></i> Café con Letras | Admin
        </a>
        <div class="header-user-info">
            Bienvenido(a), <span class="user-name"><?= session('nombre') . ' ' . session('apellido') ?></span>
            <a href="<?= base_url('login/salir') ?>">Cerrar Sesión</a>
        </div>
    </header>

    <div class="page-wrapper">
        <aside class="main-sidebar">
            <ul class="sidebar-menu">
                <li class="menu-item <?= ($menu_activo ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <a href="<?= base_url('panel/admin') ?>">
                        Dashboard
                    </a>
                </li>
                <li class="menu-item <?= ($menu_activo ?? '') === 'libros' ? 'active' : '' ?>">
                    <a href="<?= base_url('libros') ?>">
                        Gestión de Libros
                    </a>
                </li>
                <li class="menu-item <?= ($menu_activo ?? '') === 'usuarios' ? 'active' : '' ?>">
                    <a href="<?= base_url('usuarios') ?>">
                        Gestión de Usuarios
                    </a>
                </li>
                <li class="menu-item <?= ($menu_activo ?? '') === 'prestamos' ? 'active' : '' ?>">
                    <a href="<?= base_url('prestamos') ?>">
                        Préstamos
                    </a>
                </li>
                <li class="menu-item <?= ($menu_activo ?? '') === 'devoluciones' ? 'active' : '' ?>">
                    <a href="<?= base_url('devoluciones') ?>">
                        Devoluciones
                    </a>
                </li>
                <li class="menu-item <?= ($menu_activo ?? '') === 'reportes' ? 'active' : '' ?>">
                    <a href="<?= base_url('reportes') ?>">
                        Reportes
                    </a>
                </li>
                
            </ul>
        </aside>

        <main class="content-wrapper">
            <?= $contenido ?? '' ?>
        </main>
    </div>

    <footer class="main-footer">
        &copy; <?= date('Y') ?> Café con Letras | Sistema de Gestión Bibliotecaria
    </footer>
    <?= $extra_footer ?? '' ?>
</body>
</html>