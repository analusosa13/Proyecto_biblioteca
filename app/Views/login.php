<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Café con Letras</title>
    <style>
        /* Usamos la fuente 'Inter' para mejor compatibilidad y estética moderna, 
           pero manteniendo los estilos temáticos de café/libros. */
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #f3e5d5, #d7bfae);
            /* Usamos un placeholder para asegurar la carga en el entorno, 
               pero manteniendo la estética de la librería/cafetería */
            background-image: url('https://placehold.co/1200x800/d7bfae/fff?text=Libreria+y+Cafe');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px; /* Padding para móvil */
        }
        .login-container {
            background-color: #fff8f0;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            width: 100%; /* Adaptable */
            max-width: 320px; /* Máximo ancho */
            text-align: center;
            box-sizing: border-box; /* Incluir padding en el width */
        }
        h2 {
            font-family: 'Georgia', serif;
            color: #6b3e26;
            margin-bottom: 25px;
            font-size: 28px;
        }
        /* Estilo para los mensajes de error (Flash data) */
        .alert-error {
            background-color: #fce4e4; 
            color: #c00000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #f9bdbd;
            font-size: 14px;
            font-weight: 500;
        }
        input[type="email"], input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #c9a68c;
            border-radius: 8px;
            background-color: #fdf5ef;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #a35f3d;
            outline: none;
            box-shadow: 0 0 5px rgba(163, 95, 61, 0.4);
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #a35f3d;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            box-shadow: 0 4px 10px rgba(163, 95, 61, 0.3);
        }
        button:hover {
            background-color: #804833;
            transform: translateY(-1px);
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #8b5e3c;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
            color: #6b3e26;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Café con Letras</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <!-- Mostrar mensaje de error si existe -->
            <div class="alert-error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Ruta corregida para CodeIgniter 4 -->
        <form action="<?= base_url('login/autenticar') ?>" method="POST">
            
            <label for="correo">Correo electrónico (Usuario):</label>
            <!-- Importante: name="correo" -->
            <input type="email" id="correo" name="correo" placeholder="Ingrese su correo" required>

            <label for="contrasena">Contraseña:</label>
            <!-- Importante: name="contrasena" -->
            <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>

            <button type="submit">Ingresar</button>
        </form>
        <div class="footer">
            Librería/Cafetería Cultural
        </div>
    </div>
</body>
</html>
