<style>
    /* Estilos base (iguales a los CRUDs anteriores) */
    .card-list {
        background-color: var(--color-secondary-bg);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    .btn-nuevo {
        background-color: var(--color-accent-strong);
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
        background-color: #8c4a2a;
    }
    .table-prestamos {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table-prestamos th, .table-prestamos td {
        border: 1px solid var(--color-accent-soft);
        padding: 12px 15px;
        text-align: left;
        font-size: 0.9rem;
    }
    .table-prestamos th {
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
    .btn-devolver {
        background-color: #3C8DBC; /* Azul para Devolver */
        color: white;
    }
    .btn-eliminar {
        background-color: #A33D3D; /* Rojo oscuro */
        color: white;
    }
    /* Clases de estado */
    .estado-proceso { background-color: #FFF3CD; color: #856404; padding: 4px; border-radius: 3px; font-weight: bold; }
    .estado-devuelto { background-color: #D4EDDA; color: #155724; padding: 4px; border-radius: 3px; font-weight: bold; }
    .estado-vencido { background-color: #F8D7DA; color: #721C24; padding: 4px; border-radius: 3px; font-weight: bold; }
</style>

<div class="card-list">
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">Gestión de Préstamos</h1>

    <a href="<?= base_url('prestamos/nuevo') ?>" class="btn-nuevo">➕ Registrar Nuevo Préstamo</a>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="background-color: #D4EDDA; color: #155724; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="background-color: #F8D7DA; color: #721C24; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <table class="table-prestamos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Libro Prestado</th>
                <th>F. Préstamo</th>
                <th>F. Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($prestamos)): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay préstamos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($prestamos as $prestamo): ?>
                    <?php
                        $clase_estado = 'estado-' . strtolower(str_replace(' ', '-', $prestamo['estado']));
                    ?>
                    <tr>
                        <td><?= $prestamo['id'] ?></td>
                        <td><?= esc($prestamo['nombre_usuario'] . ' ' . $prestamo['apellido_usuario']) ?></td>
                        <td><?= esc($prestamo['titulo_libro']) ?></td>
                        <td><?= date('d/m/Y', strtotime($prestamo['fecha_prestamo'])) ?></td>
                        <td><?= $prestamo['fecha_devolucion'] ? date('d/m/Y', strtotime($prestamo['fecha_devolucion'])) : '---' ?></td>
                        <td><span class="<?= $clase_estado ?>"><?= esc($prestamo['estado']) ?></span></td>
                        <td>
                            <?php if ($prestamo['estado'] === 'En proceso'): ?>
                                <a href="<?= base_url('prestamos/devolver/' . $prestamo['id']) ?>" class="btn-action btn-devolver" onclick="return confirm('¿Confirmar devolución de este libro?');">Devolver</a>
                            <?php else: ?>
                                <span style="color: #6c757d; font-style: italic;">Completado</span>
                            <?php endif; ?>
                            
                            <a href="<?= base_url('prestamos/eliminar/' . $prestamo['id']) ?>" class="btn-action btn-eliminar" onclick="return confirm('ADVERTENCIA: ¿Está seguro de eliminar este registro? Solo hágalo si está devuelto y es un error histórico.');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>