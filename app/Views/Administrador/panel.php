<style>
    /* Estilos adicionales para el contenido del Dashboard */
    .dashboard-container {
        padding: 30px;
        background-color: var(--color-secondary-bg);
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    .kpi-card {
        background-color: var(--color-card-bg);
        border: 1px solid var(--color-card-border);
        border-radius: 6px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 5px var(--color-card-shadow);
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none; /* Para que parezca un botón/tarjeta */
        color: var(--color-text-dark);
        display: block;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px var(--color-card-shadow);
        background-color: var(--color-accent-soft);
    }
    .kpi-card h3 {
        margin-top: 0;
        font-size: 1.2rem;
        color: var(--color-accent-strong);
    }
    .kpi-line {
        height: 10px;
        background-color: var(--color-accent-medium);
        margin: 5px auto;
        border-radius: 5px;
        opacity: 0.5;
        width: 80%; /* Simula la línea del KPI */
    }
    .section-title {
        font-size: 1.8rem;
        color: var(--color-text-dark);
        margin-bottom: 25px;
        border-bottom: 1px solid var(--color-accent-soft);
        padding-bottom: 10px;
    }
    .activity-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }
    .activity-box {
        background-color: var(--color-card-bg);
        border: 1px solid var(--color-card-border);
        border-radius: 6px;
        padding: 20px;
        box-shadow: 0 2px 5px var(--color-card-shadow);
    }
    .activity-box h3 {
        color: var(--color-accent-strong);
        margin-top: 0;
        margin-bottom: 15px;
        border-bottom: 1px solid var(--color-card-border);
        padding-bottom: 5px;
    }
    .placeholder-line {
        height: 12px;
        background-color: var(--color-accent-medium);
        opacity: 0.2;
        margin-bottom: 10px;
        border-radius: 3px;
    }
    
    @media (max-width: 900px) {
        .dashboard-grid, .activity-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <h1 class="section-title">Dashboard</h1>

    <div class="dashboard-grid">
        <a href="<?= base_url('libros') ?>" class="kpi-card">
            <h3>Libros</h3>
            <div class="kpi-line"></div>
            <div class="kpi-line" style="width: 70%;"></div>
            <p>Ver inventario completo</p>
        </a>

        <a href="<?= base_url('usuarios') ?>" class="kpi-card">
            <h3>Usuarios</h3>
            <div class="kpi-line"></div>
            <div class="kpi-line" style="width: 70%;"></div>
            <p>Gestionar cuentas de alumnos/admins</p>
        </a>

        <a href="<?= base_url('prestamos') ?>" class="kpi-card">
            <h3>Préstamos</h3>
            <div class="kpi-line"></div>
            <div class="kpi-line" style="width: 70%;"></div>
            <p>Ver préstamos activos y pendientes</p>
        </a>
    </div>

    <div class="activity-container">
        <div class="activity-box">
            <h3>Actividad reciente</h3>
            <?php for ($i = 0; $i < 8; $i++): ?>
                <div class="placeholder-line" style="width: <?= 80 + ($i % 5) * 4 ?>%;"></div>
            <?php endfor; ?>
        </div>

        <div class="activity-box">
            <h3>Notificaciones</h3>
            <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="placeholder-line" style="width: <?= 90 - ($i % 3) * 5 ?>%;"></div>
            <?php endfor; ?>
        </div>
    </div>
</div>