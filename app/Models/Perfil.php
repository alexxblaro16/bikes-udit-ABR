<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perfil extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'perfiles';

    protected $fillable = ['user_id', 'matricula', 'telefono', 'direccion', 'fecha_nacimiento', 'nacionalidad', 'foto'];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }

    /**
     * Edad calculada
     */
    public function getEdadAttribute(): ?int
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }

    /**
     * 1:1 inversa con User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
