<?php
// Archivo: app/Models/PrestamoModel.php
namespace App\Models;
use CodeIgniter\Model;

class PrestamoModel extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['usuario_id', 'libro_id', 'fecha_prestamo', 'fecha_devolucion', 'estado'];
    
    /**
     * Obtiene todos los préstamos con el nombre completo del usuario y el título del libro.
     * @return array
     */
    public function obtenerPrestamosDetallados()
    {
        return $this->select('prestamos.*, 
                              usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario,
                              libros.titulo AS titulo_libro')
            ->join('usuarios', 'usuarios.id = prestamos.usuario_id')
            ->join('libros', 'libros.id = prestamos.libro_id')
            ->findAll();
    }
    
    /**
     * Obtiene un préstamo detallado por ID.
     * @param int $id ID del préstamo.
     * @return array|null
     */
    public function obtenerPrestamoDetalladoPorId($id)
    {
        return $this->select('prestamos.*, 
                              usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario,
                              libros.titulo AS titulo_libro')
            ->join('usuarios', 'usuarios.id = prestamos.usuario_id')
            ->join('libros', 'libros.id = prestamos.libro_id')
            ->where('prestamos.id', $id)
            ->first();
    }
}