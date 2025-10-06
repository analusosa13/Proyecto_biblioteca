<?php if (empty($datos)): ?>
    <p style="text-align: center;">No hay préstamos activos pendientes de devolución.</p>
<?php else: ?>
    <table class="report-table">
        <thead>
            <tr>
                <th>ID P.</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>F. Préstamo</th>
                <th>Días Activo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $prestamo): ?>
                <?php
                    // Cálculo de días activos (solo para la vista)
                    $date1 = new \DateTime($prestamo['fecha_prestamo']);
                    $date2 = new \DateTime(date('Y-m-d'));
                    $dias_activo = $date1->diff($date2)->days;
                ?>
                <tr>
                    <td><?= $prestamo['id'] ?></td>
                    <td><?= esc($prestamo['nombre_usuario'] . ' ' . $prestamo['apellido_usuario']) ?></td>
                    <td><?= esc($prestamo['titulo_libro']) ?></td>
                    <td><?= date('d/m/Y', strtotime($prestamo['fecha_prestamo'])) ?></td>
                    <td><?= $dias_activo ?> días</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>