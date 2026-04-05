<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;

class BicicletaController extends Controller
{
    /**
     * Detalle de una bicicleta: estado, estación actual e historial de trayectos.
     */
    public function show(string $id)
    {
        $bicicleta = Bicicleta::with([
            'estacion',
            'trayectos.user',
            'trayectos.estacionInicio',
            'trayectos.estacionFin',
        ])->findOrFail($id);

        return view('bicicletas.show', compact('bicicleta'));
    }
}

