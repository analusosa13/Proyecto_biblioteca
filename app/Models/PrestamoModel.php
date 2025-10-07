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

    // Dentro de la clase PrestamoModel...

/**
 * Obtiene todos los préstamos que ya han sido devueltos.
 * @return array
 */
public function obtenerDevoluciones()
{
    return $this->select('prestamos.*, 
                          usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario,
                          libros.titulo AS titulo_libro')
        ->join('usuarios', 'usuarios.id = prestamos.usuario_id')
        ->join('libros', 'libros.id = prestamos.libro_id')
        // === FILTRO CLAVE ===
        ->where('prestamos.estado', 'Devuelto')
        ->findAll();
}

/**
 * Obtiene todos los préstamos que están 'En proceso' (activos).
 * (Útil para el formulario de devoluciones)
 * @return array
 */
public function obtenerPrestamosActivos()
{
    return $this->select('prestamos.*, 
                          usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario,
                          libros.titulo AS titulo_libro')
        ->join('usuarios', 'usuarios.id = prestamos.usuario_id')
        ->join('libros', 'libros.id = prestamos.libro_id')
        ->where('prestamos.estado', 'En proceso')
        ->findAll();
}

// Archivo: app/Models/PrestamoModel.php
// ... (código existente)

    /**
     * Obtiene el historial completo de préstamos (activos y devueltos) para un usuario específico.
     * @param int $usuario_id ID del alumno.
     * @return array
     */
    public function obtenerPrestamosPorAlumno($usuario_id)
    {
        return $this->select('prestamos.*, libros.titulo AS titulo_libro')
            ->join('libros', 'libros.id = prestamos.libro_id')
            ->where('prestamos.usuario_id', $usuario_id)
            ->orderBy('prestamos.fecha_prestamo', 'DESC')
            ->findAll();
    }

    /**
     * Obtiene todos los préstamos activos ('En proceso') con detalles.
     * @return array
     */
    public function obtenerPrestamosActivosDetallados()
    {
        return $this->select('prestamos.*, 
                              usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario,
                              libros.titulo AS titulo_libro')
            ->join('usuarios', 'usuarios.id = prestamos.usuario_id')
            ->join('libros', 'libros.id = prestamos.libro_id')
            ->where('prestamos.estado', 'En proceso')
            ->findAll();
    }

}