<style>
    /* Estilos base del CRUD (iguales al de libros) */
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
    .table-usuarios {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table-usuarios th, .table-usuarios td {
        border: 1px solid var(--color-accent-soft);
        padding: 12px 15px;
        text-align: left;
        font-size: 0.9rem;
    }
    .table-usuarios th {
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
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">Gestión de Usuarios</h1>

    <a href="<?= base_url('usuarios/nuevo') ?>" class="btn-nuevo">➕ Agregar Nuevo Usuario</a>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="background-color: #D4EDDA; color: #155724; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="background-color: #F8D7DA; color: #721C24; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <table class="table-usuarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Rol</th>
                <th>Correo</th>
                <th>F. Nacimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay usuarios registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= esc($usuario['nombre']) . ' ' . esc($usuario['apellido']) ?></td>
                        <td><?= esc($usuario['nom_tipo']) ?></td>
                        <td><?= esc($usuario['correo']) ?></td>
                        <td><?= date('d/m/Y', strtotime($usuario['fecha_nacimiento'])) ?></td>
                        <td>
                            <a href="<?= base_url('usuarios/editar/' . $usuario['id']) ?>" class="btn-action btn-editar">Editar</a>
                            
                            <?php if ($usuario['id'] != session()->get('id')): // No permite eliminar el usuario activo ?>
                            <a href="<?= base_url('usuarios/eliminar/' . $usuario['id']) ?>" class="btn-action btn-eliminar" onclick="return confirm('¿Está seguro de que desea eliminar a <?= esc($usuario['nombre']) ?>?');">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>