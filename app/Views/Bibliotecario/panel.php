<div class="dashboard-container">
    <h1 class="section-title">
        Bienvenido(a), Bibliotecario(a) <?= esc(session()->get('nombre') . ' ' . session()->get('apellido')) ?>
    </h1>
    <p style="color: var(--color-text-subtle); margin-bottom: 30px; font-size: 1.1rem;">
        Este es tu centro de operaciones para gestionar los movimientos de libros de la biblioteca.
    </p>

    <div class="dashboard-grid">
        
        <a href="<?= base_url('bibliotecario/prestamos') ?>" class="kpi-card">
            <h3>Gestión de Préstamos</h3>
            <div class="kpi-line"></div>
            <p style="margin-top: 15px;">Consulta, registra y administra los préstamos activos y pendientes.</p>
        </a>

        <a href="<?= base_url('bibliotecario/devoluciones') ?>" class="kpi-card">
            <h3>Registro de Devoluciones</h3>
            <div class="kpi-line"></div>
            <p style="margin-top: 15px;">Accede rápidamente al formulario para registrar la devolución de libros.</p>
        </a>

    </div>
</div>

<style>
    /* NOTA: Estos estilos son esenciales y deben estar en tu plantilla o un CSS global. 
       Los incluimos aquí por si acaso, pero la mejor práctica es tenerlos en plantilla_bibliotecario.php */
    .dashboard-container {
        padding: 30px;
        background-color: var(--color-secondary-bg);
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .kpi-line {
        height: 10px;
        background-color: var(--color-accent-medium);
        margin: 5px auto;
        border-radius: 5px;
        opacity: 0.5;
        width: 80%;
    }
    /* Asegúrate de que .kpi-card, .section-title, y las variables de color estén definidas
       en tu plantilla_bibliotecario.php para un estilo consistente. */
</style>