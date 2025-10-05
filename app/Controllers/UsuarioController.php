<?php
// Archivo: app/Controllers/UsuarioController.php
namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Models\TipoModel;
use CodeIgniter\Controller;

class UsuarioController extends BaseController
{
    protected $usuarioModel;
    protected $tipoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->tipoModel = new TipoModel();
    }

    /**
     * READ: Muestra la lista de usuarios.
     */
    public function index()
    {
        $data = [
            'titulo' => 'Gestión de Usuarios',
            'menu_activo' => 'usuarios',
            'usuarios' => $this->usuarioModel->obtenerUsuariosConTipo()
        ];
        
        // La vista debe estar en Administrador/usuarios/usuarios.php
        $data['contenido'] = view('Administrador/usuarios/usuarios', $data);
        return view('Plantillas/plantilla_admin', $data);
    }
    
    /**
     * CREATE (Vista): Muestra el formulario para crear un nuevo usuario.
     */
    public function nuevo()
    {
        $data = [
            'titulo' => 'Nuevo Usuario',
            'menu_activo' => 'usuarios',
            'tipos' => $this->tipoModel->findAll() // Carga los tipos (Administrador, Alumno)
        ];
        
        $data['contenido'] = view('Administrador/usuarios/form_usuario', $data);
        return view('Plantillas/plantilla_admin', $data);
    }

    /**
     * CREATE (Acción): Guarda el nuevo usuario en la DB.
     */
    public function guardar()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/usuarios');
        }

        $reglas = [
            'id_tipo'           => 'required|integer',
            'nombre'            => 'required|min_length[2]|max_length[150]',
            'apellido'          => 'required|min_length[2]|max_length[150]',
            'fecha_nacimiento'  => 'required|valid_date',
            'correo'            => 'required|valid_email|is_unique[usuarios.correo]',
            'password'          => 'required|min_length[5]',
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->usuarioModel->save([
            'id_tipo'          => $this->request->getPost('id_tipo'),
            'nombre'           => $this->request->getPost('nombre'),
            'apellido'         => $this->request->getPost('apellido'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'correo'           => $this->request->getPost('correo'),
            'password'         => $this->request->getPost('password'), // Se hashea en el modelo
        ]);

        return redirect()->to('/usuarios')->with('success', 'Usuario registrado exitosamente.');
    }

    /**
     * UPDATE (Vista): Muestra el formulario para editar un usuario.
     */
    public function editar($id)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado.');
        }

        $data = [
            'titulo' => 'Editar Usuario',
            'menu_activo' => 'usuarios',
            'usuario' => $usuario,
            'tipos' => $this->tipoModel->findAll()
        ];
        
        $data['contenido'] = view('Administrador/usuarios/form_usuario', $data);
        return view('Plantillas/plantilla_admin', $data);
    }

    /**
     * UPDATE (Acción): Actualiza los datos del usuario.
     */
    public function actualizar($id)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/usuarios');
        }
        
        // Regla de correo verifica que sea único, excluyendo el correo actual del usuario
        $usuario_actual = $this->usuarioModel->find($id);
        $correo_rule = 'required|valid_email|is_unique[usuarios.correo,id,' . $id . ']';
        $password_rule = $this->request->getPost('password') ? 'min_length[5]' : 'permit_empty';

        $reglas = [
            'id_tipo'           => 'required|integer',
            'nombre'            => 'required|min_length[2]|max_length[150]',
            'apellido'          => 'required|min_length[2]|max_length[150]',
            'fecha_nacimiento'  => 'required|valid_date',
            'correo'            => $correo_rule,
            'password'          => $password_rule,
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_tipo'          => $this->request->getPost('id_tipo'),
            'nombre'           => $this->request->getPost('nombre'),
            'apellido'         => $this->request->getPost('apellido'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'correo'           => $this->request->getPost('correo'),
        ];
        
        // Solo actualiza la contraseña si se proporcionó un nuevo valor
        if ($this->request->getPost('password')) {
            $data['password'] = MD5($this->request->getPost('password'));
        }

        $this->usuarioModel->update($id, $data);

        return redirect()->to('/usuarios')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * DELETE: Elimina un usuario.
     */
    public function eliminar($id)
    {
        // Se recomienda verificar si el usuario tiene préstamos activos antes de borrarlo.
        
        // Opcional: Proteger al administrador principal de ser eliminado (ej. ID 1)
        if ($id == session()->get('id')) {
            return redirect()->to('/usuarios')->with('error', 'No puedes eliminar tu propia cuenta de administrador mientras está activa.');
        }

        $this->usuarioModel->delete($id);
        
        return redirect()->to('/usuarios')->with('success', 'Usuario eliminado exitosamente.');
    }
}