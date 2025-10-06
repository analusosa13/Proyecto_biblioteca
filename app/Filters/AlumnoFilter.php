<?php namespace App\Filters;
// app/Filters/AlumnoFilter.php

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AlumnoFilter implements FilterInterface
{
    /**
     * Verifica si el usuario está logueado como Alumno (id_tipo = 2).
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Verificar si la sesión está iniciada
        if (!session()->get('logged_in')) {
            // CORRECCIÓN: Redirige a la ruta raíz '/' para evitar el 404.
            return redirect()->to(base_url('/'))->with('error', 'Debes iniciar sesión para acceder al portal de alumnos.');
        }
        
        // 2. Verificar el tipo de usuario (usando id_tipo = 2)
        if (session()->get('id_tipo') != 2) { 
            // Si está logueado pero no es alumno, lo expulsa.
            session()->destroy();
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado: Tu cuenta no es de Alumno.');
        }
    }

    /**
     * No hace nada después de la ejecución de la ruta.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere ninguna acción después de la ejecución del controlador.
    }
}