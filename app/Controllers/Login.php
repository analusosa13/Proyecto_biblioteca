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
            // Utilizamos la lógica de redirección por rol que implementaremos a continuación
            $this->redirigirPorRol();
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
            // === MODIFICACIÓN CLAVE: Guardamos más datos del usuario en la sesión ===
            session()->set([
                'id_usuario' => $datosUsuario['id'],
                'nombre' => $datosUsuario['nombre'],
                'apellido' => $datosUsuario['apellido'],
                'correo' => $datosUsuario['correo'],
                'id_tipo' => $datosUsuario['id_tipo'], // Necesario para la redirección
                'logged_in' => true
            ]);

            // Redirige según el tipo de usuario (1: Administrador, 2: Alumno)
            return $this->redirigirPorRol();

        } else {
            // Redirección con mensaje de error (Flash data)
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
            return redirect()->to('/panel/admin');
        } elseif ($id_tipo == 2) { // Alumno
            return redirect()->to('/panel/alumno');
        }
        // Si no es ninguno, destruye la sesión por seguridad y vuelve al login.
        session()->destroy();
        return redirect()->to('/');
    }

    /**
     * Muestra la vista del panel del ADMINISTRADOR.
     */
    // En app/Controllers/Login.php

// ... (resto del código del controlador)

    /**
     * Muestra la vista del panel del ADMINISTRADOR usando la plantilla.
     */
    public function panelAdmin()
    {
        // Solo permite acceso si está logueado y es Administrador (id_tipo 1)
        if (!session()->get('logged_in') || session()->get('id_tipo') != 1) {
            return redirect()->to('/');
        }

        // === CAMBIO CLAVE: Carga la vista del panel y la pasa a la plantilla ===
        $data = [
            'titulo' => 'Dashboard',
            'menu_activo' => 'dashboard', // Para resaltar el elemento en el sidebar
            'contenido' => view('Administrador/panel') // Carga el contenido del dashboard
        ];

        // Carga la plantilla y le inyecta la vista de contenido
        return view('Plantillas/plantilla_admin', $data);
    }
    
// ... (resto del código del controlador)

    /**
     * Muestra la vista del panel del ALUMNO.
     */
    public function panelAlumno()
    {
        // Verificamos si el usuario está logueado Y si es alumno (id_tipo 2)
        if (!session()->get('logged_in') || session()->get('id_tipo') != 2) {
            return redirect()->to('/');
        }
        // La vista está en /app/Views/Alumno/panel.php
        return view('Alumno/panel');
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