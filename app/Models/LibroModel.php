<?php
// Archivo: app/Models/LibroModel.php
namespace App\Models;
use CodeIgniter\Model;

class LibroModel extends Model
{
    // === CAMBIO: Nombre de la tabla a 'libros' ===
    protected $table = 'libros'; 
    protected $primaryKey = 'id';
    
    // === CAMBIO: Campos permitidos según el nuevo esquema ===
    protected $allowedFields = ['id_categoria', 'titulo', 'autor', 'editorial', 'cantidad', 'estado'];
    
    /**
     * Obtiene todos los libros con el nombre de su categoría.
     * @return array
     */
    public function obtenerLibrosConCategoria()
    {
        // === CAMBIO: SELECT y JOIN usan la tabla 'libros' y sus nuevos campos ===
        return $this->select('libros.*, categorias.nom_categoria')
            ->join('categorias', 'categorias.id = libros.id_categoria')
            ->findAll();
    }

    /**
     * Obtiene un libro por ID, incluyendo el nombre de su categoría.
     * @param int $id ID del libro.
     * @return array|null
     */
    public function obtenerLibroConCategoriaPorId($id)
    {
        return $this->select('libros.*, categorias.nom_categoria')
            ->join('categorias', 'categorias.id = libros.id_categoria')
            ->where('libros.id', $id)
            ->first();
    }

    // Archivo: app/Models/LibroModel.php
// ... (código existente)

    /**
     * Obtiene solo los libros que tienen stock > 0 y están 'Disponible', con el nombre de la categoría.
     * @return array
     */
    public function obtenerLibrosDisponiblesConCategoria()
    {
        return $this->select('libros.*, categorias.nom_categoria')
            ->join('categorias', 'categorias.id = libros.id_categoria')
            ->where('libros.cantidad >', 0)
            ->where('libros.estado', 'Disponible')
            ->orderBy('libros.titulo', 'ASC')
            ->findAll();
    }

}