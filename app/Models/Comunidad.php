<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    use HasFactory;

    protected $table = 'CCAA';

    protected $fillable = [
        'Nombre', 
        'idCCAA',
    ];

    public function provincias()
    {
        return $this->hasMany(Provincia::class);
    }
}
