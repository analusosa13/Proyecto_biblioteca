<?php
// Archivo: app/Controllers/BibliotecarioController.php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PrestamoModel;

class BibliotecarioController extends BaseController
{
    /**
     * Muestra el Dashboard principal del bibliotecario (Bibliotecario/panel.php).
     */
    public function dashboard()
    {
        $data = [
            'titulo' => 'Panel de Operaciones',
            'menu_activo' => 'dashboard'
        ];
        
        $data['contenido'] = view('Bibliotecario/panel', $data); 
        
        return view('Plantillas/plantilla_bibliotecario', $data); 
    }
    
    /**
     * Redirecciona al grupo de rutas de gestión de Préstamos (/prestamos).
     * Esto permite compartir el PrestamoController y sus vistas con el Administrador.
     */
    public function redirigirAPrestamos()
    {
        return redirect()->to(base_url('prestamos'));
    }

    /**
     * Redirecciona al grupo de rutas de gestión de Devoluciones (/devoluciones).
     * Esto permite compartir el DevolucionController y sus vistas con el Administrador.
     */
    public function redirigirADevoluciones()
    {
        return redirect()->to(base_url('devoluciones'));
    }
}