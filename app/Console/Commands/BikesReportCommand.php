<?php

namespace App\Console\Commands;

use App\Models\Bicicleta;
use App\Models\Estacion;
use App\Models\Trayecto;
use App\Models\User;
use Illuminate\Console\Command;

class BikesReportCommand extends Command
{
    protected $signature = 'bikes:report';

    protected $description = 'Muestra un informe general del sistema de préstamo de bicicletas';

    public function handle()
    {
        $totalBicis = Bicicleta::count();
        $disponibles = Bicicleta::where('estado', 'disponible')->count();
        $noDisponibles = Bicicleta::where('estado', 'no-disponible')->count();
        $enMantenimiento = Bicicleta::where('estado', 'en-mantenimiento')->count();
        $trayectosActivos = Trayecto::activos()->count();
        $trayectosTotales = Trayecto::count();
        $totalEstaciones = Estacion::count();
        $totalUsuarios = User::count();
        $porcentajeDisponible = $totalBicis > 0
            ? round(($disponibles / $totalBicis) * 100, 1)
            : 0;

        $this->info('');
        $this->info('╔══════════════════════════════════════════╗');
        $this->info('║   INFORME DEL SISTEMA DE BICICLETAS      ║');
        $this->info('╚══════════════════════════════════════════╝');
        $this->info('');

        // Resumen general
        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total de usuarios', $totalUsuarios],
                ['Total de estaciones', $totalEstaciones],
                ['Total de bicicletas', $totalBicis],
                ['Bicicletas disponibles', $disponibles],
                ['Bicicletas en uso', $noDisponibles],
                ['Bicicletas en mantenimiento', $enMantenimiento],
                ['% de disponibilidad', $porcentajeDisponible . '%'],
                ['Trayectos activos', $trayectosActivos],
                ['Trayectos totales (histórico)', $trayectosTotales],
            ]
        );

        // Detalle de trayectos activos
        $activos = Trayecto::with(['user', 'bicicleta', 'estacionInicio'])
            ->activos()
            ->get();

        if ($activos->isNotEmpty()) {
            $this->info('');
            $this->info('Trayectos activos en este momento:');
            $this->table(
                ['Usuario', 'Bicicleta', 'Estación de salida', 'Inicio', 'Duración'],
                $activos->map(fn($t) => [
                    $t->user->name,
                    $t->bicicleta->codigo,
                    $t->estacionInicio->nombre,
                    $t->started_at->format('d/m/Y H:i'),
                    $t->started_at->diffForHumans(now(), true),
                ])
            );
        } else {
            $this->info('');
            $this->info('No hay trayectos activos en este momento.');
        }

        // Resumen por estación
        $this->info('');
        $this->info('Bicicletas por estación:');
        $estaciones = Estacion::withCount([
            'bicicletas',
            'bicicletas as disponibles_count' => function ($query) {
                $query->where('estado', 'disponible');
            },
        ])->get();

        $this->table(
            ['Estación', 'Bicis totales', 'Bicis disponibles', 'Capacidad'],
            $estaciones->map(fn($e) => [
                $e->nombre,
                $e->bicicletas_count,
                $e->disponibles_count,
                $e->capacidad,
            ])
        );

        $this->info('');
        $this->info('Informe generado el ' . now()->format('d/m/Y H:i:s'));

        return Command::SUCCESS;
    }
}

