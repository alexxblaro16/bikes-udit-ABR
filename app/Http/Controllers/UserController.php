<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trayecto;

class UserController extends Controller
{
    /**
     * Listado de todos los usuarios del sistema.
     */
    public function index()
    {
        $users = User::with(['perfil', 'trayectos'])->get();

        return view('users.index', compact('users'));
    }

    /**
     * Perfil de un usuario con estadísticas.
     */
    public function show(string $id)
    {
        $user = User::with([
            'perfil',
            'trayectos.bicicleta',
            'trayectos.estacionInicio',
            'trayectos.estacionFin',
        ])->findOrFail($id);

        // Estadísticas
        $totalTrayectos = $user->trayectos->count();
        $trayectosFinalizados = $user->trayectos->whereNotNull('ended_at');
        $trayectoActivo = $user->trayectos->whereNull('ended_at')->first();

        // Km estimados (distancia media entre estaciones Madrid ~3-5km)
        $kmEstimados = 0;
        foreach ($trayectosFinalizados as $t) {
            if ($t->estacionInicio && $t->estacionFin) {
                $lat1 = $t->estacionInicio->latitud;
                $lon1 = $t->estacionInicio->longitud;
                $lat2 = $t->estacionFin->latitud;
                $lon2 = $t->estacionFin->longitud;
                if ($lat1 && $lon1 && $lat2 && $lon2) {
                    // Fórmula Haversine
                    $R = 6371;
                    $dLat = deg2rad($lat2 - $lat1);
                    $dLon = deg2rad($lon2 - $lon1);
                    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
                    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
                    $kmEstimados += $R * $c;
                }
            }
        }

        // Tiempo total en minutos
        $tiempoTotal = 0;
        foreach ($trayectosFinalizados as $t) {
            $tiempoTotal += $t->started_at->diffInMinutes($t->ended_at);
        }

        // CO2 ahorrado (estimación: 120g/km que se ahorra vs coche)
        $co2Ahorrado = round($kmEstimados * 0.12, 1);

        // Calorías quemadas (estimación: ~30 kcal/km en bici)
        $caloriasQuemadas = round($kmEstimados * 30);

        return view('users.show', compact(
            'user', 'totalTrayectos', 'trayectosFinalizados', 'trayectoActivo',
            'kmEstimados', 'tiempoTotal', 'co2Ahorrado', 'caloriasQuemadas'
        ));
    }
}
