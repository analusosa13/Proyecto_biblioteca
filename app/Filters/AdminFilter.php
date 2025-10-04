<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Revisa si el usuario es un administrador logueado antes de ejecutar la ruta.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si no hay sesión o el usuario no es de tipo 1 (Administrador)
        if (!session()->get('logged_in') || session()->get('id_tipo') != 1) {
            // Redirige al login o a la página de inicio
            return redirect()->to(base_url('/'));
        }
    }

    /**
     * No hace nada después de la ejecución de la ruta.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere ninguna acción posterior a la ruta.
    }
}