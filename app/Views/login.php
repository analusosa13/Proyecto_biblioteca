<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jardín de Lecturas — Biblioteca Escolar</title>
    <style>
        /* 🌼 Paleta de colores: tonos suaves, frescos y naturales */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom, #F0FFF4, #DFF6E4); /* Verde muy suave degradado */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            color: #2E3A23; /* Verde oscuro para el texto */
        }

        /* Encabezado */
        .header-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #88B04B; /* Verde hoja más vivo */
            color: #FFFFFF;
            padding: 10px 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 10;
        }

        /* Contenedor login */
        .login-container {
            background-color: #FFFFFF; /* Blanco para resaltar */
            padding: 50px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: left;
            box-sizing: border-box;
            border: 1px solid #CDE4B7; /* Verde suave para el borde */
        }

        /* Formulario */
        h2 {
            font-weight: 600;
            color: #4A6B2F; /* Verde más oscuro para título */
            margin-bottom: 25px;
            font-size: 26px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 1px solid #CDE4B7;
            padding-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 14px;
            color: #2E3A23;
            font-weight: 500;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #A8D5BA; /* Verde pastel */
            border-radius: 6px;
            background-color: #F8FFF6; /* Fondo muy suave */
            font-size: 16px;
            color: #2E3A23;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #88B04B;
            outline: none;
            box-shadow: 0 0 0 2px rgba(136, 176, 75, 0.3);
        }

        /* Botón */
        button {
            width: 100%;
            padding: 14px 20px;
            margin-top: 25px;
            background-color: #88B04B; /* Verde hoja */
            color: #FFFFFF;
            border: 1px solid #6B8E23;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button:hover {
            background-color: #6B8E23; /* Verde más oscuro */
            color: #FFFFFF;
        }

        /* Mensaje de error */
        .alert-error {
            background-color: #FFECEC;
            color: #CC0000;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
            font-size: 14px;
            text-align: center;
        }

        /* Media Query para móviles */
        @media (max-width: 500px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header-bar">
        🌿 Jardín de Lecturas — Biblioteca Escolar
    </div>
    
    <div class="login-container">
        <h2><b>LOGIN</b></h2>

        <div class="right-panel">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-error">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/autenticar') ?>" method="POST">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" placeholder="Ingrese su correo" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>

                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>
</body>
</html>
