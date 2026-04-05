<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use Illuminate\Support\Facades\Cache;

class EstacionController extends Controller
{
    /**
     * Listar todas las estaciones con sus bicicletas.
     * Implementa caché de 60 segundos.
     */
    public function index()
    {
        // Caché de 60 segundos en el listado de estaciones
        $estaciones = Cache::remember('estaciones', 60, function () {
            return Estacion::with('bicicletas')->get();
        });

        return view('estaciones.index', compact('estaciones'));
    }

    /**
     * Detalle de una estación con sus bicicletas agrupadas por estado.
     */
    public function show(string $id)
    {
        $estacion = Estacion::with('bicicletas')->findOrFail($id);

        return view('estaciones.show', compact('estacion'));
    }
}
// Configuración inicial del proyecto
