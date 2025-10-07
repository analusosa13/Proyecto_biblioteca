<!DOCTYPE html>
<html>
<head>
    <title>Reporte: <?= esc($titulo) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; font-size: 10pt; }
        .report-header { text-align: center; margin-bottom: 20px; }
        .report-header h1 { font-size: 18pt; color: #5D4037; margin: 5px 0; }
        .report-header h2 { font-size: 12pt; color: #795548; margin: 5px 0; }
        .report-header p { font-size: 9pt; color: #666; }
        /* Estilos de tabla para impresión/PDF */
        .report-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .report-table th, .report-table td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 9pt; }
        .report-table th { background-color: #E0E0E0; color: #333; }
        .estado-proceso { color: #FFA000; font-weight: bold; }
        .estado-devuelto { color: #388E3C; font-weight: bold; }

        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; font-size: 9pt; }
        }
    </style>
</head>
<body <?= $is_print ?? false ? 'onload="window.print()"' : '' ?>>
    <?= $contenido ?>
</body>
</html>