<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estaciones';

    protected $fillable = ['nombre', 'ubicacion', 'capacidad', 'latitud', 'longitud'];

    protected function casts(): array
    {
        return [
            'capacidad' => 'integer',
            'latitud' => 'decimal:7',
            'longitud' => 'decimal:7',
        ];
    }

    /**
     * 1:N — Una estación tiene muchas bicicletas
     */
    public function bicicletas(): HasMany
    {
        return $this->hasMany(Bicicleta::class);
    }

    /**
     * Bicicletas disponibles en esta estación
     */
    public function bicicletasDisponibles(): HasMany
    {
        return $this->bicicletas()->where('estado', 'disponible');
    }

    /**
     * Trayectos que salieron de esta estación
     */
    public function trayectosSalida(): HasMany
    {
        return $this->hasMany(Trayecto::class, 'estacion_inicio_id');
    }

    /**
     * Trayectos que llegaron a esta estación
     */
    public function trayectosLlegada(): HasMany
    {
        return $this->hasMany(Trayecto::class, 'estacion_fin_id');
    }
}
