<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comunidad;
use App\Models\Provincia;
use App\Models\Localidad;

class LocationController extends Controller
{

    public function getProvincias($ComunidadId)
    {
        $provincias = Provincia::where('idCCAA', $ComunidadId)->get();
        return response()->json($provincias);
    }

    public function getLocalidades($ProvinciaId)
    {
        $localidades = Localidad::where('idProvincia', $ProvinciaId)->get();
        return response()->json($localidades);
    }
}
