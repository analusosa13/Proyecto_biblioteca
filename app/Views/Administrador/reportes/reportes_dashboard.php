<style>
    .card-reporte {
        background-color: var(--color-secondary-bg);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    .form-reporte .form-group {
        margin-bottom: 15px;
    }
    .form-reporte .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: var(--color-text-dark);
    }
    .form-reporte .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--color-accent-soft);
        border-radius: 4px;
        box-sizing: border-box;
    }
    .btn-generate {
        background-color: var(--color-accent-medium);
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        margin-right: 10px;
        text-decoration: none;
    }
    .btn-pdf { background-color: #A33D3D; } /* Rojo */
    .btn-print { background-color: #3C8DBC; } /* Azul */
    .btn-view { background-color: var(--color-accent-strong); }
    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
</style>

<div class="card-reporte">
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">
        Generación de Reportes 📊
    </h1>

    <div class="report-grid">
        <div class="card-reporte">
            <h2>Préstamos por Alumno</h2>
            <form action="<?= base_url('reportes/alumno') ?>" method="get" class="form-reporte">
                <div class="form-group">
                    <label for="alumno_id">Seleccionar Alumno:</label>
                    <select id="alumno_id" name="usuario_id" required>
                        <option value="">-- Seleccione un alumno --</option>
                        <?php foreach ($alumnos as $alumno): ?>
                            <option value="<?= $alumno['id'] ?>">
                                <?= esc($alumno['nombre'] . ' ' . $alumno['apellido'] . ' (' . $alumno['correo'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-generate btn-view">Ver</button>
                <button type="submit" name="pdf" value="true" class="btn-generate btn-pdf">PDF</button>
                <button type="submit" name="print" value="true" class="btn-generate btn-print">Imprimir</button>
            </form>
        </div>

        <div class="card-reporte">
            <h2>Historial por Libro</h2>
            <form action="<?= base_url('reportes/libro') ?>" method="get" class="form-reporte">
                <div class="form-group">
                    <label for="libro_id">Seleccionar Libro:</label>
                    <select id="libro_id" name="libro_id" required>
                        <option value="">-- Seleccione un libro --</option>
                        <?php foreach ($libros as $libro): ?>
                            <option value="<?= $libro['id'] ?>">
                                <?= esc($libro['titulo'] . ' (Stock: ' . $libro['cantidad'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-generate btn-view">Ver</button>
                <button type="submit" name="pdf" value="true" class="btn-generate btn-pdf">PDF</button>
                <button type="submit" name="print" value="true" class="btn-generate btn-print">Imprimir</button>
            </form>
        </div>

        <div class="card-reporte">
            <h2>Libros Disponibles</h2>
            <p>Listado de libros con stock > 0 y estado 'Disponible'.</p>
            <a href="<?= base_url('reportes/disponibles') ?>" class="btn-generate btn-view">Ver</a>
            <a href="<?= base_url('reportes/disponibles?pdf=true') ?>" class="btn-generate btn-pdf">PDF</a>
            <a href="<?= base_url('reportes/disponibles?print=true') ?>" class="btn-generate btn-print">Imprimir</a>
        </div>

        <div class="card-reporte">
            <h2>Préstamos Activos</h2>
            <p>Listado de todos los préstamos que están 'En proceso'.</p>
            <a href="<?= base_url('reportes/activos') ?>" class="btn-generate btn-view">Ver</a>
            <a href="<?= base_url('reportes/activos?pdf=true') ?>" class="btn-generate btn-pdf">PDF</a>
            <a href="<?= base_url('reportes/activos?print=true') ?>" class="btn-generate btn-print">Imprimir</a>
        </div>
    </div>
</div>