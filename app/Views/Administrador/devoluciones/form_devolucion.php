<style>
    /* Estilos base (iguales a los CRUDs anteriores) */
    .card-list {
        background-color: var(--color-secondary-bg);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    .btn-back {
        background-color: var(--color-text-subtle);
        color: var(--color-secondary-bg);
        padding: 10px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s;
        margin-bottom: 20px;
        display: inline-block;
    }
    .btn-back:hover {
        background-color: #6c757d;
    }
    .table-activos {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table-activos th, .table-activos td {
        border: 1px solid var(--color-accent-soft);
        padding: 12px 15px;
        text-align: left;
        font-size: 0.9rem;
    }
    .table-activos th {
        background-color: var(--color-header-bg);
        color: var(--color-text-dark);
    }
    .btn-action {
        padding: 5px 10px;
        border-radius: 3px;
        text-decoration: none;
        margin-right: 5px;
        font-size: 0.85rem;
    }
    .btn-confirmar {
        background-color: #3C8DBC;
        color: white;
    }
    .estado-proceso { background-color: #FFF3CD; color: #856404; padding: 4px; border-radius: 3px; font-weight: bold; }
</style>

<div class="card-list">
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">Registrar Devolución (Préstamos Activos)</h1>

    <a href="<?= base_url('devoluciones') ?>" class="btn-back">⬅️ Volver al Historial</a>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="background-color: #F8D7DA; color: #721C24; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    
    <table class="table-activos">
        <thead>
            <tr>
                <th>ID Préstamo</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>F. Préstamo</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($prestamos_activos)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay préstamos pendientes de devolución.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($prestamos_activos as $prestamo): ?>
                    <tr>
                        <td><?= $prestamo['id'] ?></td>
                        <td><?= esc($prestamo['nombre_usuario'] . ' ' . $prestamo['apellido_usuario']) ?></td>
                        <td><?= esc($prestamo['titulo_libro']) ?></td>
                        <td><?= date('d/m/Y', strtotime($prestamo['fecha_prestamo'])) ?></td>
                        <td><span class="estado-proceso">En proceso</span></td>
                        <td>
                            <a href="<?= base_url('devoluciones/devolver/' . $prestamo['id']) ?>" class="btn-action btn-confirmar" onclick="return confirm('¿Confirmar devolución de: <?= esc($prestamo['titulo_libro']) ?>?');">Confirmar Devolución</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>