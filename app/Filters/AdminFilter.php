<?php namespace App\Filters;
// app/Filters/AdminFilter.php

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Revisa si el usuario es un administrador logueado (id_tipo = 1).
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si no hay sesión, redirige al login.
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión para acceder al sistema.');
        }
        
        // Si hay sesión, pero no es de tipo 1 (Administrador), lo expulsa.
        if (session()->get('id_tipo') != 1) {
            session()->destroy();
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado: No tienes permisos de Administrador.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere ninguna acción posterior a la ruta.
    }
}