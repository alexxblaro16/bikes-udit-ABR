<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relaciones M:N con nombre personalizado (reservas) y con acceso a campos de la tabla intermedia (pivot)
     */
    public function books()
    {
        return $this->belongsToMany(Book::class)
        ->as('reservas')
        ->withPivot(['reserved_at', 'returned_at']);
    }

    /**
     * Funciones basadas en relaciones filtradas por un campo de la tabla intermedia (pivot)
     */
    public function reservasActivas() {
        return $this->books()->wherePivotNull('returned_at');
    }

    public function reservasDevueltas() {
        return $this->books()->wherePivotNotNull('returned_at');
    }

    // ─── Relaciones sistema de bicicletas ───

    /**
     * 1:1 con Perfil
     */
    public function perfil(): HasOne
    {
        return $this->hasOne(Perfil::class);
    }

    /**
     * M:N con Bicicleta a través de trayectos (tabla pivot)
     */
    public function bicicletas(): BelongsToMany
    {
        return $this->belongsToMany(Bicicleta::class, 'trayectos')
            ->as('trayecto')
            ->withPivot(['estacion_inicio_id', 'estacion_fin_id', 'started_at', 'ended_at']);
    }

    /**
     * Relación directa con el modelo Trayecto
     */
    public function trayectos(): HasMany
    {
        return $this->hasMany(Trayecto::class);
    }

    /**
     * Trayectos activos (sin finalizar)
     */
    public function trayectosActivos()
    {
        return $this->bicicletas()->wherePivotNull('ended_at');
    }

    /**
     * Trayectos finalizados
     */
    public function trayectosFinalizados()
    {
        return $this->bicicletas()->wherePivotNotNull('ended_at');
    }
}
