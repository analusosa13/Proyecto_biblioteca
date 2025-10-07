<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e8f0f9;
            color: #2c3e50;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2980b9;
            margin-bottom: 20px;
            font-size: 32px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
            font-weight: bold;
        }
        a:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido(a), <?= esc(session('usuario')) ?></h1>
        <p>Has ingresado exitosamente al Panel de Control de la Biblioteca.</p>
        <a href="<?= base_url('login/salir') ?>">Cerrar sesión</a>
    </div>
</body>
</html>