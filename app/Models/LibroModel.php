<?php
namespace App\Models;
use CodeIgniter\Model;

class LibroModel extends Model
{
    // === Configuración de la tabla ===
    protected $table = 'libros'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_categoria', 'titulo', 'autor', 'editorial', 'cantidad', 'estado'];
    
    /**
     * Obtiene libros con el nombre de su categoría, aplicando filtros de búsqueda.
     * Es crucial para el Catálogo.
     * @param string|null $searchTerm Término para filtrar.
     * @return array
     */
    public function obtenerLibrosConCategoria(string $searchTerm = null) // AHORA RECIBE EL PARÁMETRO
    {
        $builder = $this->db->table('libros');
        $builder->select('libros.*, categorias.nom_categoria');
        $builder->join('categorias', 'categorias.id = libros.id_categoria');
        
        // Lógica para el Catálogo (Solo disponibles)
        $builder->where('libros.cantidad >', 0);
        $builder->where('libros.estado', 'Disponible');

        // Aplicar búsqueda si se proporciona un término
        if ($searchTerm) {
            $builder->groupStart()
                    // Busca coincidencias en Titulo, Autor, Editorial y Categoría
                    ->like('libros.titulo', $searchTerm)
                    ->orLike('libros.autor', $searchTerm)
                    ->orLike('libros.editorial', $searchTerm)
                    ->orLike('categorias.nom_categoria', $searchTerm)
                    ->groupEnd();
        }
        
        $builder->orderBy('libros.titulo', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene todos los libros sin filtros de stock (Función original, mantenida para Admin).
     */
    public function obtenerTodosLosLibrosConCategoria()
    {
        // Esta función no recibe parámetro de búsqueda, por lo que trae todos los registros unidos.
        return $this->select('libros.*, categorias.nom_categoria')
            ->join('categorias', 'categorias.id = libros.id_categoria')
            ->findAll();
    }
    
    /**
     * Obtiene un libro por ID, incluyendo el nombre de su categoría. (Función original, mantenida)
     */
    public function obtenerLibroConCategoriaPorId($id)
    {
        return $this->select('libros.*, categorias.nom_categoria')
            ->join('categorias', 'categorias.id = libros.id_categoria')
            ->where('libros.id', $id)
            ->first();
    }
    
    // La función obtenerLibrosDisponiblesConCategoria ya no es necesaria, 
    // pues obtenerLibrosConCategoria() hace ese filtro por defecto si no hay búsqueda.
}