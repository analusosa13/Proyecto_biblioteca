<?php 
$is_edit = isset($libro);
$action = $is_edit ? base_url('libros/actualizar/' . $libro['id']) : base_url('libros/guardar');
?>
<style>
    /* ... (Mismos estilos del formulario anterior) ... */
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
        <?= $is_edit ? 'Editar Libro: ' . esc($libro['titulo']) : 'Registrar Nuevo Libro' ?>
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
            <label for="titulo">Título del Libro:</label>
            <input type="text" id="titulo" name="titulo" value="<?= old('titulo', $libro['titulo'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?= old('autor', $libro['autor'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="editorial">Editorial (Opcional):</label>
            <input type="text" id="editorial" name="editorial" value="<?= old('editorial', $libro['editorial'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="id_categoria">Categoría:</label>
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php 
                $selected_cat = old('id_categoria', $libro['id_categoria'] ?? null);
                foreach ($categorias as $categoria): 
                ?>
                    <option value="<?= $categoria['id'] ?>" <?= ($selected_cat == $categoria['id']) ? 'selected' : '' ?>>
                        <?= esc($categoria['nom_categoria']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad (Stock):</label>
            <input type="number" id="cantidad" name="cantidad" value="<?= old('cantidad', $libro['cantidad'] ?? '') ?>" required>
        </div>
        
        <?php if ($is_edit): ?>
        <div class="form-group">
            <label for="estado">Estado del Libro:</label>
            <select id="estado" name="estado" required>
                <?php $selected_estado = old('estado', $libro['estado'] ?? 'Disponible'); ?>
                <option value="Disponible" <?= ($selected_estado == 'Disponible') ? 'selected' : '' ?>>Disponible</option>
                <option value="Dañado" <?= ($selected_estado == 'Dañado') ? 'selected' : '' ?>>Dañado</option>
                <option value="En reparación" <?= ($selected_estado == 'En reparación') ? 'selected' : '' ?>>En reparación</option>
            </select>
        </div>
        <?php endif; ?>

        <button type="submit" class="btn-submit">
            <?= $is_edit ? 'Actualizar Libro' : 'Guardar Libro' ?>
        </button>
        <a href="<?= base_url('libros') ?>" class="btn-submit" style="background-color: var(--color-text-subtle);">Cancelar</a>
    </form>
</div>