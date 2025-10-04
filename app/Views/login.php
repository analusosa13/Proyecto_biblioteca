<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café con Letras — Sistema Bibliotecario</title>
    <style>
        /* Paleta de colores ajustada a tonos más cálidos y pastel (basado en la imagen):
           Fondo principal: #F8F5EF (Beige muy claro)
           Contenedor: #FFFFFF o #FEFEFE
           Énfasis (Texto/Bordes/Botón): #C6A89C (Rosa/Café suave) y #A35F3D (Café oscuro para contraste)
        */
        body {
            font-family: 'Inter', sans-serif; /* Mantenemos Inter como fuente estándar */
            background-color:  #C6A89C; /* Fondo principal muy claro y cálido */
            background-image: linear-gradient(to bottom,  #C6A89C,  #C6A89C); /* Degradado sutil */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            color: #4A4A4A; /* Color de texto general suave */
        }
        /* -- Estilo de Encabezado (Simulando la barra de navegación) -- */
        .header-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #F2EFE9; /* Tono más claro para la barra */
            border-bottom: 1px solid #E0DCD7;
            padding: 10px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            z-index: 10;
        }
        .header-bar .logo {
            font-weight: 600;
            color: #A35F3D; /* Mantenemos un toque de color café fuerte para la marca */
        }
        .header-bar .menu-item {
            color: #8B8780;
        }

        /* -- Contenedor de Login Principal -- */
        .login-container {
            background-color: #FEFEFE; /* Fondo del contenedor blanco o casi blanco */
            padding: 60px 50px;
            border-radius: 8px; 
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 600px; 
            text-align: left;
            box-sizing: border-box;
            border: 1px solid #EBE7E2;
        }
        
        /* Simulación del cuadro de avatar/marco izquierdo (Solo estilo de borde) */
        .login-content {
            display: flex;
            gap: 40px;
        }
        .left-panel {
            flex: 1;
            border: 1px solid #C6A89C; /* Tono de borde más pastel/suave */
            padding: 20px;
            min-height: 250px;
            font-size: 14px;
            line-height: 1.5;
            color: #C6A89C;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .right-panel {
            flex: 1;
        }
        
        /* -- Estilos de Formulario -- */
        h2 {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: #4A4A4A; /* Tono de gris oscuro/café suave */
            margin-bottom: 30px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 1px solid #EBE7E2;
            padding-bottom: 15px;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 14px;
            color: #4A4A4A;
            font-weight: 500;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #C6A89C; /* Borde más suave */
            border-radius: 4px;
            background-color: #FEFEFE;
            font-size: 16px;
            color: #4A4A4A;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #A35F3D;
            outline: none;
            box-shadow: 0 0 0 1px #A35F3D;
        }
        
        /* -- Estilo de Botón -- */
        button {
            width: 100%;
            padding: 12px 20px;
            margin-top: 25px;
            background-color: #E6D8D2; /* Tono de botón pastel/rosado */
            color: #A35F3D; /* Texto en tono café fuerte para contraste */
            border: 1px solid #C6A89C;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        button:hover {
            background-color: #D6C2B0;
            color: #6b3e26;
        }
        
        /* -- Mensaje de Error -- */
        .alert-error {
            background-color: #ffe8e8; 
            color: #CC0000;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
            font-size: 14px;
            text-align: center;
        }

        /* Ocultar el pie de página de la librería para mantener el diseño simple */
        .footer {
            display: none;
        }
        
        /* -- Media Query para móviles -- */
        @media (max-width: 650px) {
            .login-content {
                flex-direction: column;
            }
            .login-container {
                padding: 30px 20px;
            }
            .left-panel {
                display: none; /* Ocultamos el panel izquierdo en móvil */
            }
        }
    </style>
</head>
<body>
    <!-- Simulación del Encabezado de Navegación -->
    <div class="header-bar">
        <div class="logo">☕ Café con Letras — Sistema Bibliotecario</div>
        
    </div>
    
    <div class="login-container">
        <h2><b>LOGIN</h2>

        <div class="login-content">
            <!-- Panel Derecho: Formulario de Login -->
            <div class="right-panel">
                <?php if (session()->getFlashdata('error')): ?>
                    <!-- Mostrar mensaje de error si existe -->
                    <div class="alert-error">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <!-- Ruta corregida para CodeIgniter 4 -->
                <form action="<?= base_url('login/autenticar') ?>" method="POST">
                    
                    <!-- Campo de Correo (Usuario) -->
                    <label for="correo">Correo</label>
                    <input type="email" id="correo" name="correo" placeholder="Ingrese su correo" required>

                    <!-- Campo de Contraseña -->
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>

                    <button type="submit">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
