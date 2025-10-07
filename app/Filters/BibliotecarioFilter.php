<?php namespace App\Filters;
// Archivo: app/Filters/BibliotecarioFilter.php

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class BibliotecarioFilter implements FilterInterface
{
    /**
     * Verifica si el usuario está logueado como Bibliotecario (id_tipo = 3).
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // 1. Verificar si la sesión está iniciada
        if (!$session->get('logged_in')) {
            // Si no está logueado, redirige a la ruta raíz (login).
            return redirect()->to(base_url('/'))->with('error', 'Debes iniciar sesión para acceder al portal de bibliotecarios.');
        }
        
        // 2. Verificar el tipo de usuario (debe ser id_tipo = 3)
        if ($session->get('id_tipo') != 3) { 
            // Si está logueado pero no es bibliotecario, lo expulsa.
            session()->destroy();
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado: Tu cuenta no es de Bibliotecario.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere ninguna acción.
    }
}