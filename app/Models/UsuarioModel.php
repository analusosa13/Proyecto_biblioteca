<?php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    // Se incluyen los campos de la tabla para las operaciones CRUD si fueran necesarias
    protected $allowedFields = ['nombre', 'apellido', 'correo', 'password'];

    /**
     * Verifica la existencia del usuario usando 'correo' y el 'password' cifrado en MD5.
     * @param string $correo El correo ingresado por el usuario.
     * @param string $password La contraseña sin cifrar ingresada.
     * @return array|null Los datos del usuario si las credenciales son correctas, o null.
     */
    public function verificarUsuario($correo, $password)
    {
        // Se busca por la columna 'correo' y se cifra la contraseña ingresada
        // para compararla con el hash MD5 almacenado en la base de datos.
        return $this->where('correo', $correo)
            ->where('password', md5($password))
            ->first();
    }
}
