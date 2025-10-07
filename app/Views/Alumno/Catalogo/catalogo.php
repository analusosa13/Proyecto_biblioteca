<?php 
// app/Views/Alumno/Catalogo/catalogo.php
?>

<style>
    /* Estilos de la tarjeta contenedora y la tabla (Copiados de tu ejemplo) */
    .card-list {
        background-color: var(--color-secondary-bg);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
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
    
    /* Estilos del Buscador */
    .search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        padding-top: 10px;
    }
    .search-form input[type="search"] {
        flex-grow: 1;
        padding: 10px 15px;
        border: 1px solid var(--color-accent-medium);
        border-radius: 4px;
        font-size: 1rem;
    }
    .search-form button {
        background-color: var(--color-accent-strong);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
        font-weight: 600;
    }
    .search-form button:hover {
        background-color: #8c4a2a; /* Tono de hover de admin */
    }
</style>

<div class="card-list">
    
    <form method="get" class="search-form">
        <input type="search" name="search" placeholder="Buscar por Título, Autor, Editorial o Categoría..." value="<?= esc($searchTerm ?? '') ?>">
        <button type="submit"><i class="fas fa-search"></i> Buscar</button>
        <?php if (!empty($searchTerm)): ?>
            <a href="<?= base_url('alumno/catalogo') ?>" class="search-form button" style="background-color: var(--color-accent-medium); color: var(--color-text-dark); line-height: 1;">Limpiar</a>
        <?php endif; ?>
    </form>

    <table class="table-libros">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Categoría</th>
                <th>Disponibles</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($libros)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No se encontraron libros que coincidan con la búsqueda.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?= esc($libro['titulo']) ?></td>
                        <td><?= esc($libro['autor']) ?></td>
                        <td><?= esc($libro['editorial']) ?></td>
                        <td><?= esc($libro['nom_categoria']) ?></td>
                        <td>
                            <span style="font-weight: bold; color: <?= $libro['cantidad'] > 5 ? 'green' : ($libro['cantidad'] > 0 ? '#A35F3D' : 'red') ?>">
                                <?= $libro['cantidad'] ?>
                            </span>
                        </td>
                        <td>
                            <span style="color: <?= $libro['cantidad'] > 0 ? '#155724' : '#721C24' ?>; font-weight: 600;">
                                <?= $libro['cantidad'] > 0 ? 'Disponible' : 'Agotado' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>