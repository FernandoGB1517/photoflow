<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;

    protected $table = 'PROVINCIAS';

    protected $fillable = [
        'Provincia',
        'idCCAA',
        'idProvincia',
    ];

    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class);
    }

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }
}
