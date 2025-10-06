<?php
// Archivo: app/Controllers/DevolucionController.php
namespace App\Controllers;
use App\Models\PrestamoModel;
use App\Models\LibroModel;
use CodeIgniter\Controller;

class DevolucionController extends BaseController
{
    protected $prestamoModel;
    protected $libroModel;

    public function __construct()
    {
        $this->prestamoModel = new PrestamoModel();
        $this->libroModel = new LibroModel();
    }

    /**
     * READ: Muestra el historial de devoluciones (préstamos con estado 'Devuelto').
     */
    public function index()
    {
        $data = [
            'titulo' => 'Historial de Devoluciones',
            'menu_activo' => 'devoluciones',
            // Usa el nuevo método para filtrar solo las devoluciones
            'devoluciones' => $this->prestamoModel->obtenerDevoluciones()
        ];
        
        $data['contenido'] = view('Administrador/devoluciones/devoluciones', $data);
        return view('Plantillas/plantilla_admin', $data);
    }
    
    /**
     * CREATE (Vista): Muestra la lista de préstamos activos para registrar una devolución.
     */
    public function nuevo()
    {
        $data = [
            'titulo' => 'Registrar Devolución',
            'menu_activo' => 'devoluciones',
            // Obtiene solo los préstamos 'En proceso'
            'prestamos_activos' => $this->prestamoModel->obtenerPrestamosActivos() 
        ];
        
        $data['contenido'] = view('Administrador/devoluciones/form_devolucion', $data);
        return view('Plantillas/plantilla_admin', $data);
    }

    /**
     * UPDATE (Acción): Procesa la devolución de un préstamo activo.
     * Es la misma lógica que tenías en PrestamoController::devolver.
     */
    public function devolver($id)
    {
        $prestamo = $this->prestamoModel->find($id);

        if (!$prestamo || $prestamo['estado'] === 'Devuelto') {
            return redirect()->to('/devoluciones/nuevo')->with('error', 'Préstamo no válido o ya estaba devuelto.');
        }

        // 1. Marcar el Préstamo como Devuelto
        $this->prestamoModel->update($id, [
            'fecha_devolucion' => date('Y-m-d'), // Fecha de hoy
            'estado' => 'Devuelto',
        ]);
        
        // 2. Actualizar el Stock del Libro (sumar 1)
        $libro = $this->libroModel->find($prestamo['libro_id']);
        if ($libro) {
            $nueva_cantidad = $libro['cantidad'] + 1;
            $this->libroModel->update($prestamo['libro_id'], ['cantidad' => $nueva_cantidad]);
        }
        
        return redirect()->to('/devoluciones')->with('success', 'Devolución registrada exitosamente. Stock actualizado.');
    }
    
    /**
     * DELETE: Elimina un registro de devolución (historial).
     */
    public function eliminar($id)
    {
        $prestamo = $this->prestamoModel->find($id);

        if (!$prestamo || $prestamo['estado'] !== 'Devuelto') {
            return redirect()->to('/devoluciones')->with('error', 'Solo se pueden eliminar registros de devoluciones completadas.');
        }
        
        $this->prestamoModel->delete($id);
        
        return redirect()->to('/devoluciones')->with('success', 'Registro de devolución eliminado del historial.');
    }
}