<?php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    // Aseguramos que 'id_tipo' sea un campo permitido para si lo necesitas en otras operaciones
    protected $allowedFields = ['id_tipo', 'nombre', 'apellido', 'correo', 'password', 'fecha_nacimiento'];

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
}