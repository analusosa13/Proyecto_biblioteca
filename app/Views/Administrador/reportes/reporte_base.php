<div class="report-header">
    <h1>REPORTE DE BIBLIOTECA: <?= esc($tipo_reporte) ?></h1>
    <h2><?= esc($subtitulo) ?></h2>
    <p>Generado el: <?= date('d/m/Y H:i:s') ?></p>
</div>

<?php 
// Solo mostramos botones de acción si no es modo PDF o Impresión (vista de navegador)
if (!($is_pdf ?? false) && !($is_print ?? false)): ?>
    <div class="no-print" style="margin-bottom: 20px; padding: 10px; background-color: #F5F5F5; border-radius: 4px;">
        <p>Opciones de descarga e impresión:</p>
        <?php 
        // Reconstruye la URL actual con los parámetros, pero sin 'pdf' o 'print'
        $query_params = $request->getGet(); 
        
        unset($query_params['pdf']);
        unset($query_params['print']);
        $base_url = current_url(true) . '?' . http_build_query($query_params);
        ?>
        <a href="<?= $base_url . '&pdf=true' ?>" style="padding: 5px 10px; background-color: #A33D3D; color: white; text-decoration: none; border-radius: 3px;">Descargar PDF</a>
        <a href="<?= $base_url . '&print=true' ?>" style="padding: 5px 10px; background-color: #3C8DBC; color: white; text-decoration: none; border-radius: 3px;">Imprimir</a>
    </div>
<?php endif; ?>

<?php 
// CORREGIDO: Llamamos a view() sin el segundo argumento ($data) 
// para que el archivo de contenido (e.g., reporte_alumno.php) herede las variables de esta vista.
echo view('Administrador/reportes/' . $vista_contenido); 
?>