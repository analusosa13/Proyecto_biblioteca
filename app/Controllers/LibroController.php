<?php
// Archivo: app/Controllers/LibroController.php
namespace App\Controllers;
use App\Models\LibroModel;
use App\Models\CategoriaModel;
use CodeIgniter\Controller;

class LibroController extends BaseController
{
    protected $libroModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->libroModel = new LibroModel();
        $this->categoriaModel = new CategoriaModel();
        
        // El filtro 'admin' se encarga de esto, pero mantenemos una verificación básica
        if (!session()->get('logged_in') || session()->get('id_tipo') != 1) {
            // return redirect()->to('/'); // Esta línea es manejada por el filtro 'admin'
        }
    }

    /**
     * READ: Muestra la lista de libros.
     */
    public function index()
    {
        $data = [
            'titulo' => 'Gestión de Libros',
            'menu_activo' => 'libros',
            'libros' => $this->libroModel->obtenerLibrosConCategoria()
        ];
        
        $data['contenido'] = view('Administrador/libros/libros', $data);
        return view('Plantillas/plantilla_admin', $data);
    }
    
    /**
     * CREATE (Vista): Muestra el formulario para crear un nuevo libro.
     */
    public function nuevo()
    {
        $data = [
            'titulo' => 'Nuevo Libro',
            'menu_activo' => 'libros',
            'categorias' => $this->categoriaModel->findAll()
        ];
        
        $data['contenido'] = view('Administrador/libros/form_libro', $data);
        return view('Plantillas/plantilla_admin', $data);
    }

    /**
     * CREATE (Acción): Guarda el nuevo libro en la DB.
     */
    public function guardar()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/libros');
        }

        // === CAMBIO: Reglas de validación actualizadas ===
        $reglas = [
            'id_categoria' => 'required|integer',
            'titulo'       => 'required|min_length[3]|max_length[255]',
            'autor'        => 'required|min_length[3]|max_length[150]',
            'editorial'    => 'max_length[150]', // Opcional, pero limitado
            'cantidad'     => 'required|integer',
            'estado'       => 'permit_empty|in_list[Disponible,Dañado,En reparación]',
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // === CAMBIO: Nombres de campos a guardar actualizados ===
        $this->libroModel->save([
            'id_categoria' => $this->request->getPost('id_categoria'),
            'titulo'       => $this->request->getPost('titulo'),
            'autor'        => $this->request->getPost('autor'),
            'editorial'    => $this->request->getPost('editorial'),
            'cantidad'     => $this->request->getPost('cantidad'),
            'estado'       => $this->request->getPost('estado') ?? 'Disponible', // Valor por defecto
        ]);

        return redirect()->to('/libros')->with('success', 'Libro guardado exitosamente.');
    }

    /**
     * UPDATE (Vista): Muestra el formulario para editar un libro.
     */
    public function editar($id)
    {
        $libro = $this->libroModel->find($id);

        if (!$libro) {
            return redirect()->to('/libros')->with('error', 'Libro no encontrado.');
        }

        $data = [
            'titulo' => 'Editar Libro',
            'menu_activo' => 'libros',
            'libro' => $libro,
            'categorias' => $this->categoriaModel->findAll()
        ];
        
        $data['contenido'] = view('Administrador/libros/form_libro', $data);
        return view('Plantillas/plantilla_admin', $data);
    }

    /**
     * UPDATE (Acción): Actualiza los datos del libro.
     */
    public function actualizar($id)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/libros');
        }

        // === CAMBIO: Reglas de validación actualizadas ===
        $reglas = [
            'id_categoria' => 'required|integer',
            'titulo'       => 'required|min_length[3]|max_length[255]',
            'autor'        => 'required|min_length[3]|max_length[150]',
            'editorial'    => 'max_length[150]',
            'cantidad'     => 'required|integer',
            'estado'       => 'required|in_list[Disponible,Dañado,En reparación]',
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // === CAMBIO: Nombres de campos a actualizar actualizados ===
        $this->libroModel->update($id, [
            'id_categoria' => $this->request->getPost('id_categoria'),
            'titulo'       => $this->request->getPost('titulo'),
            'autor'        => $this->request->getPost('autor'),
            'editorial'    => $this->request->getPost('editorial'),
            'cantidad'     => $this->request->getPost('cantidad'),
            'estado'       => $this->request->getPost('estado'),
        ]);

        return redirect()->to('/libros')->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * DELETE: Elimina un libro.
     */
    public function eliminar($id)
    {
        $this->libroModel->delete($id);
        
        return redirect()->to('/libros')->with('success', 'Libro eliminado exitosamente.');
    }
}