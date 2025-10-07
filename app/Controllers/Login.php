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
        // Si el usuario ya está logueado, redirigimos a su panel correspondiente
        if (session()->get('logged_in')) {
            // NOTA: Debe retornar la redirección para que funcione correctamente
            return $this->redirigirPorRol();
        }
        return view('login');
    }

    /**
     * Procesa la autenticación del usuario.
     */
    public function autenticar()
    {
        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('contrasena');

        $usuarioModel = new UsuarioModel();
        
        $datosUsuario = $usuarioModel->verificarUsuario($correo, $password);

        if ($datosUsuario) {
            // Guarda la ID como 'id_usuario' (clave clave para la consistencia)
            session()->set([
                'id_usuario' => $datosUsuario['id'],
                'nombre' => $datosUsuario['nombre'],
                'apellido' => $datosUsuario['apellido'],
                'correo' => $datosUsuario['correo'],
                'id_tipo' => $datosUsuario['id_tipo'], 
                'logged_in' => true
            ]);

            return $this->redirigirPorRol();

        } else {
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos.');
        }
    }
    
    /**
     * Lógica para redirigir al panel correcto.
     */
    private function redirigirPorRol()
    {
        $id_tipo = session()->get('id_tipo');

        if ($id_tipo == 1) { // Administrador
            return redirect()->to('panel/admin'); 
        } elseif ($id_tipo == 2) { // Alumno
            return redirect()->to('alumno'); 
        } elseif ($id_tipo == 3) { // Bibliotecario <--- ¡NUEVA LÍNEA CLAVE!
            return redirect()->to('bibliotecario'); 
        }
        
        // Si el rol no coincide con ninguno, destruye la sesión y redirige al login
        session()->destroy();
        return redirect()->to('/');
    }

    public function panelAdmin()
    {
        if (!session()->get('logged_in') || session()->get('id_tipo') != 1) {
            return redirect()->to('/');
        }

        $data = [
            'titulo' => 'Dashboard',
            'menu_activo' => 'dashboard', 
            'contenido' => view('Administrador/panel') 
        ];

        return view('Plantillas/plantilla_admin', $data);
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
