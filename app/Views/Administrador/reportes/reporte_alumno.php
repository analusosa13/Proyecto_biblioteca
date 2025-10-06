<?php if (empty($datos)): ?>
    <p style="text-align: center;">Este alumno no tiene registros de préstamos/devoluciones.</p>
<?php else: ?>
    <table class="report-table">
        <thead>
            <tr>
                <th>ID P.</th>
                <th>Libro</th>
                <th>F. Préstamo</th>
                <th>F. Devolución</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $prestamo): ?>
                <tr>
                    <td><?= $prestamo['id'] ?></td>
                    <td><?= esc($prestamo['titulo_libro']) ?></td>
                    <td><?= date('d/m/Y', strtotime($prestamo['fecha_prestamo'])) ?></td>
                    <td><?= $prestamo['fecha_devolucion'] ? date('d/m/Y', strtotime($prestamo['fecha_devolucion'])) : '---' ?></td>
                    <td><span class="estado-<?= strtolower($prestamo['estado']) ?>"><?= esc($prestamo['estado']) ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>