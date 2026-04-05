<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Trayecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bicicleta_id',
        'estacion_inicio_id',
        'estacion_fin_id',
        'started_at',
        'ended_at',
        'favorito',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'favorito' => 'boolean',
        ];
    }

    // ─── Relaciones ───

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bicicleta(): BelongsTo
    {
        return $this->belongsTo(Bicicleta::class);
    }

    public function estacionInicio(): BelongsTo
    {
        return $this->belongsTo(Estacion::class, 'estacion_inicio_id');
    }

    public function estacionFin(): BelongsTo
    {
        return $this->belongsTo(Estacion::class, 'estacion_fin_id');
    }

    // ─── Scopes ───

    /**
     * Trayectos activos (sin finalizar)
     */
    public function scopeActivos(Builder $query): Builder
    {
        return $query->whereNull('ended_at');
    }

    /**
     * Trayectos finalizados
     */
    public function scopeFinalizados(Builder $query): Builder
    {
        return $query->whereNotNull('ended_at');
    }
}
