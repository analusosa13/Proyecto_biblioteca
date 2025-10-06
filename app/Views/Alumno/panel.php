<div class="dashboard-container">
    <h1 class="section-title">
        Bienvenido(a), Alumno(a) <?= esc(session()->get('nombre') . ' ' . session()->get('apellido')) ?>
    </h1>
    <p style="color: var(--color-text-subtle); margin-bottom: 30px; font-size: 1.1rem;">
        Este es tu centro de control para explorar el catálogo y gestionar tus préstamos.
    </p>

    <div class="dashboard-grid">
        
        <a href="<?= base_url('alumno/catalogo') ?>" class="kpi-card">
            <h3> Explorar Catálogo</h3>
            <div class="kpi-line"></div>
            <p style="margin-top: 15px;">Busca los libros disponibles en la biblioteca.</p>
        </a>

        <a href="<?= base_url('alumno/prestamos') ?>" class="kpi-card">
            <h3>Mis Préstamos</h3>
            <div class="kpi-line"></div>
            <p style="margin-top: 15px;">Revisa el estado de tus préstamos activos y tu historial de devoluciones.</p>
        </a>

    </div>
</div>

<style>
    .dashboard-container {
        padding: 30px;
        background-color: var(--color-secondary-bg);
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    /* Líneas de simulación KPI (Para mantener el estilo de diseño) */
    .kpi-line {
        height: 10px;
        background-color: var(--color-accent-medium);
        margin: 5px auto;
        border-radius: 5px;
        opacity: 0.5;
        width: 80%;
    }
</style>