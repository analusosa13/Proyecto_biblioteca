<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Café con Letras</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #f3e5d5, #d7bfae);
            background-image: url('https://i.pinimg.com/1200x/ea/ee/8f/eaee8ffdb5cc1deb80d7daef43ec95b0.jpg');
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff8f0;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            width: 320px;
            text-align: center;
        }
        h2 {
            font-family: 'Georgia', serif;
            color: #6b3e26;
            margin-bottom: 25px;
            font-size: 28px;
        }
        input[type="email"], input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #c9a68c;
            border-radius: 8px;
            background-color: #fdf5ef;
            font-size: 16px;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #a35f3d;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color: #a35f3d;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #804833;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #8b5e3c;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
            color: #6b3e26;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Café con Letras</h2>
        <form action="login.php" method="POST">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" placeholder="Ingrese su correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>

            <button type="submit">Ingresar</button>
        </form>
        <div class="footer">
            Librería/Cafetería Cultural
        </div>
    </div>
</body>
</html>