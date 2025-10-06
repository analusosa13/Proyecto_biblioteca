<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminBibliotecarioFilter implements FilterInterface
{
    /**
     * Verifica si el usuario está logueado y es Administrador (1) o Bibliotecario (3).
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // 1. Verificar si la sesión está iniciada
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'))->with('error', 'Debes iniciar sesión para acceder a esta área.');
        }
        
        $id_tipo = $session->get('id_tipo');
        
        // 2. Verificar el tipo de usuario (debe ser 1 o 3)
        if ($id_tipo != 1 && $id_tipo != 3) { 
            session()->destroy();
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado: No tienes permisos de Administrador o Bibliotecario.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere acción.
    }
}