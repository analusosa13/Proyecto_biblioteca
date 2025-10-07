<style>
    /* ... (Mismos estilos del listado anterior) ... */
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
    .table-libros {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table-libros th, .table-libros td {
        border: 1px solid var(--color-accent-soft);
        padding: 12px 15px;
        text-align: left;
    }
    .table-libros th {
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
    .btn-editar {
        background-color: var(--color-accent-medium);
        color: white;
    }
    .btn-eliminar {
        background-color: #A33D3D; /* Rojo oscuro */
        color: white;
    }
</style>

<div class="card-list">
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">Gestión de Libros</h1>

    <a href="<?= base_url('libros/nuevo') ?>" class="btn-nuevo">➕ Agregar Nuevo Libro</a>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="background-color: #D4EDDA; color: #155724; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="background-color: #F8D7DA; color: #721C24; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <table class="table-libros">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($libros)): ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No hay libros registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?= $libro['id'] ?></td>
                        <td><?= esc($libro['titulo']) ?></td>
                        <td><?= esc($libro['autor']) ?></td>
                        <td><?= esc($libro['editorial']) ?></td>
                        <td><?= esc($libro['nom_categoria']) ?></td>
                        <td><?= $libro['cantidad'] ?></td>
                        <td><?= esc($libro['estado']) ?></td>
                        <td>
                            <a href="<?= base_url('libros/editar/' . $libro['id']) ?>" class="btn-action btn-editar">Editar</a>
                            <a href="<?= base_url('libros/eliminar/' . $libro['id']) ?>" class="btn-action btn-eliminar" onclick="return confirm('¿Está seguro de que desea eliminar este libro?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>