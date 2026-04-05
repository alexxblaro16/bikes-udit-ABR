<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bicicleta;
use App\Models\Estacion;
use App\Models\Trayecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrayectoController extends Controller
{
    /**
     * Listar todos los trayectos de un usuario y con qué bicicletas.
     */
    public function index(string $userId)
    {
        $user = User::with([
            'perfil',
            'trayectos.bicicleta',
            'trayectos.estacionInicio',
            'trayectos.estacionFin',
        ])->findOrFail($userId);

        $estaciones = Estacion::all();

        return view('trayectos.index', compact('user', 'estaciones'));
    }

    /**
     * Iniciar un trayecto: un usuario coge una bicicleta de una estación.
     *
     * Reglas de negocio:
     * 1. La bicicleta debe estar disponible
     * 2. La bicicleta no puede estar en un trayecto activo
     * 3. El usuario no puede tener más de un trayecto activo
     */
    public function iniciar(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bicicleta_id' => 'required|exists:bicicletas,id',
            'estacion_id' => 'required|exists:estaciones,id',
        ]);

        $bicicleta = Bicicleta::findOrFail($request->bicicleta_id);
        $userId = $request->user_id;

        // Regla 1: la bicicleta debe estar disponible
        if (!$bicicleta->estaDisponible()) {
            return back()->with('error', 'La bicicleta no está disponible. Estado actual: ' . $bicicleta->estado);
        }

        // Regla 2: la bicicleta no puede estar en un trayecto activo
        $biciEnUso = Trayecto::where('bicicleta_id', $bicicleta->id)->activos()->exists();
        if ($biciEnUso) {
            return back()->with('error', 'La bicicleta ya está en uso por otro usuario.');
        }

        // Regla 3: el usuario no puede tener más de un trayecto activo
        $usuarioConTrayecto = Trayecto::where('user_id', $userId)->activos()->exists();
        if ($usuarioConTrayecto) {
            return back()->with('error', 'Ya tienes un trayecto activo. Finalízalo antes de iniciar otro.');
        }

        // Todo correcto: crear trayecto e actualizar bicicleta
        Trayecto::create([
            'user_id' => $userId,
            'bicicleta_id' => $bicicleta->id,
            'estacion_inicio_id' => $request->estacion_id,
            'estacion_fin_id' => null,
            'started_at' => now(),
            'ended_at' => null,
        ]);

        // La bicicleta pasa a no-disponible y sale de la estación
        $bicicleta->update([
            'estado' => 'no-disponible',
            'estacion_id' => null,
        ]);

        // Invalidar caché de estaciones
        Cache::forget('estaciones');

        return redirect()->route('trayectos.index', $userId)
            ->with('success', 'Trayecto iniciado con la bicicleta ' . $bicicleta->codigo);
    }

    /**
     * Finalizar un trayecto: el usuario devuelve la bicicleta a una estación.
     */
    public function finalizar(string $trayectoId, Request $request)
    {
        $request->validate([
            'estacion_fin_id' => 'required|exists:estaciones,id',
        ]);

        $trayecto = Trayecto::activos()->findOrFail($trayectoId);

        // Finalizar el trayecto
        $trayecto->update([
            'estacion_fin_id' => $request->estacion_fin_id,
            'ended_at' => now(),
        ]);

        // La bicicleta vuelve a estar disponible en la estación de destino
        $trayecto->bicicleta->update([
            'estado' => 'disponible',
            'estacion_id' => $request->estacion_fin_id,
        ]);

        // Invalidar caché de estaciones
        Cache::forget('estaciones');

        return redirect()->route('trayectos.index', $trayecto->user_id)
            ->with('success', 'Trayecto finalizado. Bicicleta devuelta en la estación.');
    }

    /**
     * Marcar/desmarcar un trayecto como favorito.
     */
    public function toggleFavorito(string $trayectoId)
    {
        $trayecto = Trayecto::findOrFail($trayectoId);
        $trayecto->update(['favorito' => !$trayecto->favorito]);

        return redirect()->route('users.show', $trayecto->user_id);
    }
}

