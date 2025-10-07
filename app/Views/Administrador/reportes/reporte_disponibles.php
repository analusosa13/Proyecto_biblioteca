<?php if (empty($datos)): ?>
    <p style="text-align: center;">No hay libros disponibles en este momento.</p>
<?php else: ?>
    <table class="report-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoría</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $libro): ?>
                <tr>
                    <td><?= $libro['id'] ?></td>
                    <td><?= esc($libro['titulo']) ?></td>
                    <td><?= esc($libro['autor']) ?></td>
                    <td><?= esc($libro['nom_categoria']) ?></td>
                    <td><?= $libro['cantidad'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>