<?php
// Archivo: app/Controllers/PrestamoController.php
namespace App\Controllers;
use App\Models\PrestamoModel;
use App\Models\UsuarioModel;
use App\Models\LibroModel;
use CodeIgniter\Controller;

class PrestamoController extends BaseController
{
    protected $prestamoModel;
    protected $usuarioModel;
    protected $libroModel;

    public function __construct()
    {
        $this->prestamoModel = new PrestamoModel();
        // Reutilizamos modelos existentes para dropdowns y stock
        $this->usuarioModel = new UsuarioModel(); 
        $this->libroModel = new LibroModel();
        
        // Asume que el filtro 'admin' está protegiendo este acceso
    }

    /**
     * READ: Muestra la lista de préstamos.
     */
    public function index()
    {
        $data = [
            'titulo' => 'Gestión de Préstamos',
            'menu_activo' => 'prestamos',
            'prestamos' => $this->prestamoModel->obtenerPrestamosDetallados()
        ];
        
        $data['contenido'] = view('Administrador/prestamos/prestamos', $data);
        return view('Plantillas/plantilla_admin', $data);
    }
    
    /**
     * CREATE (Vista): Muestra el formulario para registrar un nuevo préstamo.
     */
    public function nuevo()
    {
        $data = [
            'titulo' => 'Registrar Nuevo Préstamo',
            'menu_activo' => 'prestamos',
            // Solo listar usuarios de tipo Alumno (id_tipo = 2) para préstamos
            'usuarios_alumnos' => $this->usuarioModel->where('id_tipo', 2)->findAll(), 
            // Libros disponibles
            'libros_disponibles' => $this->libroModel->where('cantidad >', 0)->where('estado', 'Disponible')->findAll()
        ];
        
        $data['contenido'] = view('Administrador/prestamos/form_prestamo', $data);
        return view('Plantillas/plantilla_admin', $data);
    }

    /**
     * CREATE (Acción): Registra un nuevo préstamo y actualiza el stock.
     */
    public function guardar()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/prestamos');
        }

        $reglas = [
            'usuario_id'     => 'required|integer',
            'libro_id'       => 'required|integer',
            'fecha_prestamo' => 'required|valid_date',
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $libro_id = $this->request->getPost('libro_id');
        $libro = $this->libroModel->find($libro_id);
        
        if (!$libro || $libro['cantidad'] <= 0 || $libro['estado'] != 'Disponible') {
            return redirect()->back()->with('error', 'El libro seleccionado no está disponible en stock para préstamo.')->withInput();
        }

        // 1. Guardar el Préstamo
        $this->prestamoModel->save([
            'usuario_id'     => $this->request->getPost('usuario_id'),
            'libro_id'       => $libro_id,
            'fecha_prestamo' => $this->request->getPost('fecha_prestamo'),
            'fecha_devolucion' => null, // Inicialmente nulo
            'estado'         => 'En proceso',
        ]);

        // 2. Actualizar el Stock del Libro (restar 1)
        $nueva_cantidad = $libro['cantidad'] - 1;
        $this->libroModel->update($libro_id, ['cantidad' => $nueva_cantidad]);

        return redirect()->to('/prestamos')->with('success', 'Préstamo registrado exitosamente y stock actualizado.');
    }
    
    /**
     * UPDATE (Acción): Marca un préstamo como devuelto y actualiza el stock.
     */
    public function devolver($id)
    {
        $prestamo = $this->prestamoModel->find($id);

        if (!$prestamo || $prestamo['estado'] === 'Devuelto') {
            return redirect()->to('/prestamos')->with('error', 'Préstamo no encontrado o ya estaba devuelto.');
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
        
        return redirect()->to('/prestamos')->with('success', 'Libro devuelto exitosamente y stock actualizado.');
    }
    
    /**
     * DELETE: Elimina un registro de préstamo.
     * Esta función solo se usa para registros erróneos o muy viejos,
     * y NO debe usarse si el estado está "En proceso" sin devolver stock.
     */
    public function eliminar($id)
    {
        $prestamo = $this->prestamoModel->find($id);

        if ($prestamo['estado'] === 'En proceso') {
             return redirect()->to('/prestamos')->with('error', 'No se puede eliminar un préstamo en proceso. Debe marcarse como devuelto primero.');
        }
        
        $this->prestamoModel->delete($id);
        
        return redirect()->to('/prestamos')->with('success', 'Registro de préstamo eliminado.');
    }
}