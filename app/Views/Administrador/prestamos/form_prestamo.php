<style>
    /* Estilos base del formulario (iguales a los CRUDs anteriores) */
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
        Registrar Nuevo Préstamo
    </h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert-error">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= esc($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('prestamos/guardar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="usuario_id">Alumno:</label>
            <select id="usuario_id" name="usuario_id" required>
                <option value="">Seleccione un Alumno</option>
                <?php 
                $selected_user = old('usuario_id');
                foreach ($usuarios_alumnos as $usuario): 
                ?>
                    <option value="<?= $usuario['id'] ?>" <?= ($selected_user == $usuario['id']) ? 'selected' : '' ?>>
                        <?= esc($usuario['nombre'] . ' ' . $usuario['apellido'] . ' (' . $usuario['correo'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="libro_id">Libro a Prestar (Solo disponibles):</label>
            <select id="libro_id" name="libro_id" required>
                <option value="">Seleccione un Libro</option>
                <?php 
                $selected_libro = old('libro_id');
                foreach ($libros_disponibles as $libro): 
                ?>
                    <option value="<?= $libro['id'] ?>" <?= ($selected_libro == $libro['id']) ? 'selected' : '' ?>>
                        <?= esc($libro['titulo']) ?> (Stock: <?= $libro['cantidad'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_prestamo">Fecha de Préstamo:</label>
            <input type="date" id="fecha_prestamo" name="fecha_prestamo" value="<?= old('fecha_prestamo', date('Y-m-d')) ?>" required>
        </div>

        <button type="submit" class="btn-submit">
            ✅ Confirmar Préstamo
        </button>
        <a href="<?= base_url('prestamos') ?>" class="btn-submit" style="background-color: var(--color-text-subtle);">Cancelar</a>
    </form>
</div>