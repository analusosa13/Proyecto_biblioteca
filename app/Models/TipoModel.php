<?php
// Archivo: app/Models/TipoModel.php
namespace App\Models;
use CodeIgniter\Model;

class TipoModel extends Model
{
    protected $table = 'tipos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom_tipo'];
}