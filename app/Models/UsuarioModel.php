<?php
// Archivo: app/Models/UsuarioModel.php (UNIFICADO)
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    
    // Aseguramos que 'id_tipo' sea un campo permitido
    protected $allowedFields = ['id_tipo', 'nombre', 'apellido', 'correo', 'password', 'fecha_nacimiento'];

    // Para la inserción de nuevos usuarios en el CRUD:
    protected $beforeInsert = ['hashPassword'];
    
    // Para la actualización de usuarios:
    protected $beforeUpdate = ['hashPasswordIfChanged'];

    /**
     * Hook para hashear la contraseña antes de guardar (CREATE).
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            // Utilizamos MD5, asumiendo que es el requisito para la DB.
            $data['data']['password'] = MD5($data['data']['password']); 
        }
        return $data;
    }
    
    /**
     * Hook para hashear la contraseña solo si se cambió durante la edición (UPDATE).
     */
    protected function hashPasswordIfChanged(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            // Utilizamos MD5 para mantener la consistencia con la función de verificación.
            $data['data']['password'] = MD5($data['data']['password']); 
        } else {
            // Si la contraseña está vacía en el update, la eliminamos de los datos a actualizar
            // para que no se sobreescriba con un valor nulo.
            unset($data['data']['password']);
        }
        return $data;
    }

    // ==========================================================
    // === FUNCIONES PARA EL CRUD (Listado)
    // ==========================================================

    /**
     * Obtiene todos los usuarios con el nombre de su tipo de usuario (rol).
     * (Necesaria para la vista de listado del CRUD)
     * @return array
     */
    public function obtenerUsuariosConTipo()
    {
        return $this->select('usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.correo, usuarios.fecha_nacimiento, tipos.nom_tipo')
            ->join('tipos', 'tipos.id = usuarios.id_tipo')
            ->findAll();
    }
    
    // ==========================================================
    // === FUNCIONES DE AUTENTICACIÓN (Tus funciones originales)
    // ==========================================================

    /**
     * Verifica la existencia del usuario usando 'correo' y el 'password' cifrado en MD5.
     * @param string $correo El correo ingresado por el usuario.
     * @param string $password La contraseña sin cifrar ingresada.
     * @return array|null Los datos del usuario si las credenciales son correctas, o null.
     */
    public function verificarUsuario($correo, $password)
    {
        // Importante: Se traen todos los campos para la sesión, incluyendo id_tipo, nombre y apellido.
        return $this->where('correo', $correo)
            ->where('password', md5($password))
            ->first();
    }

    /**
     * Obtiene los datos de un tipo de usuario específico
     * Esta función la agregamos para poder obtener el nombre del tipo (Administrador o Alumno)
     */
    public function getTipoUsuario($id_tipo)
    {
        $db = \Config\Database::connect();
        return $db->table('tipos')->where('id', $id_tipo)->get()->getRowArray();
    }

    // Archivo: app/Models/UsuarioModel.php
// ... (código existente)

    /**
     * Obtiene la lista de todos los usuarios de tipo Alumno (id_tipo = 2).
     * @return array
     */
    public function obtenerAlumnos()
    {
        return $this->where('id_tipo', 2)->findAll();
    }

}