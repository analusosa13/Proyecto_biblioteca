<?php 
$is_edit = isset($usuario);
$action = $is_edit ? base_url('usuarios/actualizar/' . $usuario['id']) : base_url('usuarios/guardar');
?>
<style>
    /* Estilos base del formulario (iguales al de libros) */
    .card-form {
        background-color: var(--color-secondary-bg);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: var(--color-text-dark);
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--color-accent-soft);
        border-radius: 4px;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .form-group input:focus, .form-group select:focus {
        border-color: var(--color-accent-medium);
        outline: none;
    }
    .btn-submit {
        background-color: var(--color-accent-medium);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .btn-submit:hover {
        background-color: var(--color-accent-strong);
    }
    .alert-error {
        background-color: #F8D7DA;
        color: #721C24;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
</style>

<div class="card-form">
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">
        <?= $is_edit ? 'Editar Usuario: ' . esc($usuario['nombre']) : 'Registrar Nuevo Usuario' ?>
    </h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert-error">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= esc($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= $action ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="id_tipo">Rol/Tipo de Usuario:</label>
            <select id="id_tipo" name="id_tipo" required>
                <option value="">Seleccione un rol</option>
                <?php 
                $selected_tipo = old('id_tipo', $usuario['id_tipo'] ?? null);
                foreach ($tipos as $tipo): 
                ?>
                    <option value="<?= $tipo['id'] ?>" <?= ($selected_tipo == $tipo['id']) ? 'selected' : '' ?>>
                        <?= esc($tipo['nom_tipo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= old('nombre', $usuario['nombre'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?= old('apellido', $usuario['apellido'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?= old('correo', $usuario['correo'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= old('fecha_nacimiento', $usuario['fecha_nacimiento'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="password"><?= $is_edit ? 'Nueva Contraseña (Dejar vacío para no cambiar):' : 'Contraseña:' ?></label>
            <input type="password" id="password" name="password" <?= $is_edit ? '' : 'required' ?>>
        </div>

        <button type="submit" class="btn-submit">
            <?= $is_edit ? 'Actualizar Usuario' : 'Guardar Usuario' ?>
        </button>
        <a href="<?= base_url('usuarios') ?>" class="btn-submit" style="background-color: var(--color-text-subtle);">Cancelar</a>
    </form>
</div>