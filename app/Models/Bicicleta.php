<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Trayecto;

class Bicicleta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['codigo', 'estacion_id', 'estado', 'bateria', 'ultimo_uso', 'marca', 'modelo'];

    protected $attributes = [
        'estado' => 'disponible',
        'bateria' => 100,
    ];

    protected function casts(): array
    {
        return [
            'bateria' => 'integer',
            'ultimo_uso' => 'datetime',
        ];
    }

    /**
     * Batería real calculada en tiempo real.
     * En estación: se carga (0→100% en 210 min = 3.5h)
     * En uso (trayecto activo): se descarga desde la batería que tenía al salir
     * En mantenimiento: 0%
     */
    public function getBateriaRealAttribute(): int
    {
        $base = $this->bateria; // batería guardada en BD (la que tenía al llegar/salir)

        if ($this->estado === 'en-mantenimiento') {
            return 0;
        }

        // Si está en uso → buscar el trayecto activo y calcular descarga
        if ($this->estado === 'no-disponible') {
            $trayectoActivo = Trayecto::where('bicicleta_id', $this->id)
                ->whereNull('ended_at')
                ->first();

            if ($trayectoActivo && $trayectoActivo->started_at->lte(now())) {
                $minutosEnUso = (int) abs($trayectoActivo->started_at->diffInMinutes(now()));
                // 100% dura 120 min
                $cargaPerdida = (int) round($minutosEnUso * (100 / 120));
                return max(0, min(100, $base - $cargaPerdida));
            }
            return max(0, min(100, $base));
        }

        // Si está aparcada en estación → se carga desde ultimo_uso
        if ($this->estacion_id && $this->estado === 'disponible' && $this->ultimo_uso) {
            // Solo cargar si ultimo_uso es en el pasado
            if ($this->ultimo_uso->lte(now())) {
                $minutosAparcada = (int) abs($this->ultimo_uso->diffInMinutes(now()));
                // 100% en 210 min = 3.5h
                $cargaGanada = (int) round($minutosAparcada * (100 / 210));
                return min(100, max(0, $base + $cargaGanada));
            }
            // Si ultimo_uso es futuro (desfase horario), devolver la base con tope 100
            return min(100, max(0, $base));
        }

        return min(100, max(0, $base));
    }

    /**
     * Tiempo estimado de uso restante (100% = 120 min)
     */
    public function getMinutosRestantesAttribute(): int
    {
        return (int) round($this->bateria_real * 1.2); // 100% = 120 min
    }

    /**
     * Texto legible del tiempo restante
     */
    public function getTiempoRestanteAttribute(): string
    {
        $min = $this->minutos_restantes;
        if ($min >= 60) {
            $h = floor($min / 60);
            $m = $min % 60;
            return $m > 0 ? "{$h}h {$m}min" : "{$h}h";
        }
        return "{$min} min";
    }

    /**
     * La bicicleta pertenece a una estación (nullable si está en tránsito)
     */
    public function estacion(): BelongsTo
    {
        return $this->belongsTo(Estacion::class);
    }

    /**
     * M:N con User a través de trayectos
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trayectos')
            ->as('trayecto')
            ->withPivot(['estacion_inicio_id', 'estacion_fin_id', 'started_at', 'ended_at']);
    }

    /**
     * Relación directa con Trayecto
     */
    public function trayectos(): HasMany
    {
        return $this->hasMany(Trayecto::class);
    }

    /**
     * Comprobar si la bicicleta está disponible para alquilar
     */
    public function estaDisponible(): bool
    {
        return $this->estado === 'disponible';
    }
}


