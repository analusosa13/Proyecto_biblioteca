<style>
    .card-list {
        background-color: var(--color-secondary-bg);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    /* El botón "Registrar Nuevo Préstamo" se quita ya que el alumno solo ve su historial */
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
    /* Clases de estado */
    .estado-en-proceso { background-color: #FFF3CD; color: #856404; padding: 4px; border-radius: 3px; font-weight: bold; }
    .estado-devuelto { background-color: #D4EDDA; color: #155724; padding: 4px; border-radius: 3px; font-weight: bold; }
    /* Clase de estado VENCIDO, que necesitarías calcular en el controlador si lo deseas */
    .estado-vencido { background-color: #F8D7DA; color: #721C24; padding: 4px; border-radius: 3px; font-weight: bold; }
</style>

<div class="card-list">
    <h1 style="color: var(--color-accent-strong); border-bottom: 2px solid var(--color-accent-soft); padding-bottom: 10px;">📚 Mi Historial de Préstamos</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="background-color: #D4EDDA; color: #155724; padding: 10px; border-radius: 4px;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    
    <table class="table-prestamos">
        <thead>
            <tr>
                <th>ID Préstamo</th>
                <th>Libro Prestado</th>
                <th>F. Préstamo</th>
                <th>F. Devolución Estimada</th>
                <th>F. Devolución Real</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($prestamos)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Aún no has realizado ningún préstamo.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($prestamos as $prestamo): ?>
                    <?php
                        // Determinación del estado y color
                        $estado = esc($prestamo['estado']);
                        $clase_estado = 'estado-' . strtolower(str_replace(' ', '-', $estado));

                        // Cálculo de la Fecha de Devolución Estimada (Ajusta la lógica si es diferente)
                        // Aquí asumimos una fecha de 7 días, pero DEBES usar la lógica de tu sistema.
                        $fecha_estimada = date('d/m/Y', strtotime($prestamo['fecha_prestamo'] . ' + 7 days')); 

                        // Si el préstamo está 'En proceso' y la fecha estimada ya pasó, podrías marcarlo como 'Vencido'
                        $fecha_hoy = new \DateTime();
                        $fecha_limite = new \DateTime($prestamo['fecha_prestamo']);
                        $fecha_limite->modify('+7 days'); // O el plazo que uses
                        
                        if ($estado == 'En proceso' && $fecha_hoy > $fecha_limite) {
                            $estado = 'Vencido';
                            $clase_estado = 'estado-vencido';
                        }
                    ?>
                    <tr>
                        <td><?= $prestamo['id'] ?></td>
                        <td><?= esc($prestamo['titulo_libro']) ?></td>
                        <td><?= date('d/m/Y', strtotime($prestamo['fecha_prestamo'])) ?></td>
                        <td><?= $fecha_estimada ?></td> 
                        <td><?= $prestamo['fecha_devolucion'] ? date('d/m/Y', strtotime($prestamo['fecha_devolucion'])) : '---' ?></td>
                        <td><span class="<?= $clase_estado ?>"><?= esc($estado) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>