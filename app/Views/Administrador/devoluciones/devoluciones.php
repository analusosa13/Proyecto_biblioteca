<style>
    /* Estilos base (iguales a los CRUDs anteriores) */
    .card-list {
        background-color: var(--color-secondary-bg);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    .btn-nuevo {
        background-color: #3C8DBC; /* Azul para "Registrar Devolución" */
        color: var(--color-secondary-bg);
        padding: 10px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s;
        margin-bottom: 20px;
        display: inline-block;
    }
    .btn-nuevo:hover {
        background-color: #337ab7;
    }
    .table-devoluciones {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table-devoluciones th, .table-devoluciones td {
        border: 1px solid var(--color-accent-soft);
        padding: 12px 15px;
        text-align: left;
        font-size: 0.9rem;
    }
    .table-devoluciones th {
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
    .btn-eliminar {
        background-color: #A33D3D; /* Rojo oscuro */
        color: white;
    }
    .estado-devuelto { background-color: #D4EDDA; color: #155724; padding: 4px; border-radius: 3px; font-weight: bold; }
</style>

<div class="card-list">
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">Historial de Devoluciones (Completadas)</h1>

    <a href="<?= base_url('devoluciones/nuevo') ?>" class="btn-nuevo">🔄 Registrar Devolución</a>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="background-color: #D4EDDA; color: #155724; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="background-color: #F8D7DA; color: #721C24; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <table class="table-devoluciones">
        <thead>
            <tr>
                <th>ID Préstamo</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>F. Préstamo</th>
                <th>F. Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($devoluciones)): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay devoluciones registradas en el historial.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($devoluciones as $devolucion): ?>
                    <tr>
                        <td><?= $devolucion['id'] ?></td>
                        <td><?= esc($devolucion['nombre_usuario'] . ' ' . $devolucion['apellido_usuario']) ?></td>
                        <td><?= esc($devolucion['titulo_libro']) ?></td>
                        <td><?= date('d/m/Y', strtotime($devolucion['fecha_prestamo'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($devolucion['fecha_devolucion'])) ?></td>
                        <td><span class="estado-devuelto">Devuelto</span></td>
                        <td>
                            <a href="<?= base_url('devoluciones/eliminar/' . $devolucion['id']) ?>" class="btn-action btn-eliminar" onclick="return confirm('¿Está seguro de eliminar este registro del historial?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>