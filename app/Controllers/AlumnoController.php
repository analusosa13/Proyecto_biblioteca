<?php
// Archivo: app/Controllers/AlumnoController.php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LibroModel; 
use App\Models\PrestamoModel; // Se necesita para misPrestamos()

class AlumnoController extends BaseController
{
    /**
     * Muestra el Dashboard del alumno usando la plantilla base.
     */
    public function dashboard()
    {
        $data = [
            'titulo' => 'Dashboard del Alumno',
            'menu_activo' => 'dashboard'
        ];
        
        $data['contenido'] = view('Alumno/panel', $data); 
        
        return view('Plantillas/plantilla_alumno', $data); 
    }

    /**
     * Muestra la vista de Mis Préstamos.
     */
    public function misPrestamos()
    {
        $session = session();

        // 1. VERIFICACIÓN DE SESIÓN
        // Se usa 'id_usuario' (clave guardada por Login.php)
        if (!$session->has('id_usuario') || $session->get('id_tipo') != 2) {
             // Redirige a la ruta raíz '/' para evitar el 404.
             return redirect()->to(base_url('/'))->with('error', 'Debe iniciar sesión para ver sus préstamos.');
        }

        // 2. OBTENER ID DEL USUARIO
        $usuario_id = $session->get('id_usuario'); 
        
        // 3. OBTENER PRÉSTAMOS
        $prestamoModel = new PrestamoModel();
        $prestamos = $prestamoModel->obtenerPrestamosPorAlumno($usuario_id);

        $data = [
            'titulo' => 'Mi Historial de Préstamos',
            'menu_activo' => 'prestamos',
            'prestamos' => $prestamos,
        ];
        
        // 4. CARGAR LA VISTA DE CONTENIDO
        $data['contenido'] = view('Alumno/prestamos/prestamos', $data);
        
        // 5. CARGAR LA PLANTILLA PRINCIPAL
        return view('Plantillas/plantilla_alumno', $data);
    }
    
    /**
     * Muestra la vista del Catálogo de Libros con funcionalidad de búsqueda.
     */
    public function catalogo()
    {
        $libroModel = new LibroModel();
        
        $searchTerm = $this->request->getGet('search'); 
        $libros = $libroModel->obtenerLibrosConCategoria($searchTerm);

        $data = [
            'titulo' => 'Catálogo de Libros Disponibles',
            'menu_activo' => 'catalogo',
            'libros' => $libros, 
            'searchTerm' => $searchTerm 
        ];
        
        $data['contenido'] = view('Alumno/Catalogo/catalogo', $data); 
        
        return view('Plantillas/plantilla_alumno', $data);
    }
}