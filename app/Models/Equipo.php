<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';

    protected $fillable = [
        'nombre',
        'escudo',
        'ciudad',
        'entrenador',
        'anio_fundacion',
    ];

    public function getEscudoUrlAttribute(): string
    {
        if ($this->escudo && is_file(public_path('escudos/'.$this->escudo))) {
            return asset('escudos/'.$this->escudo);
        }

        return asset('img/logo.svg');
    }

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }

    public function partidosLocal()
    {
        return $this->hasMany(Partido::class, 'equipo_local_id');
    }

    public function partidosVisitante()
    {
        return $this->hasMany(Partido::class, 'equipo_visitante_id');
    }
}
