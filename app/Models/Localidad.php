<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $table = 'MUNICIPIOS';

    protected $fillable = [
        'Municipio',
        'idProvincia',
        'idMunicipio'
    ];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
