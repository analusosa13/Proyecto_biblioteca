<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Login extends BaseController
{
    /**
     * Muestra la vista de login.
     */
    public function index()
    {
        // Si el usuario ya está logueado, se redirige directamente al panel
        if (session()->get('logged_in')) {
            return redirect()->to('/panel');
        }
        return view('login');
    }

    /**
     * Procesa la autenticación del usuario.
     */
    public function autenticar()
    {
        // Capturamos los datos enviados por el formulario usando los nombres correctos
        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('contrasena');

        $usuarioModel = new UsuarioModel();
        
        // El modelo espera el correo y la contraseña sin cifrar
        $datosUsuario = $usuarioModel->verificarUsuario($correo, $password);

        if ($datosUsuario) {
            // Establecemos la sesión. Usamos el correo como identificador 'usuario'
            session()->set([
                'usuario' => $datosUsuario['correo'], // Guardamos el correo en la sesión
                'logged_in' => true
            ]);
            return redirect()->to('/panel');
        } else {
            // Redirección con mensaje de error (Flash data)
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos.');
        }
    }

    /**
     * Muestra la vista del panel, protegida por la sesión.
     */
    public function panel()
    {
        // Verificamos si el usuario está logueado antes de mostrar el panel
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }
        return view('panel');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function salir()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
