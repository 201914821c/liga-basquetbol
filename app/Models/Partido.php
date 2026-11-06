<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;

    protected $table = 'partidos';

    protected $fillable = [
        'equipo_local_id',
        'equipo_visitante_id',
        'fecha',
        'lugar',
        'estado',
        'puntos_local',
        'puntos_visitante',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'puntos_local' => 'integer',
            'puntos_visitante' => 'integer',
        ];
    }

    public function equipoLocal()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    public function equipoVisitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    public function estaFinalizado(): bool
    {
        return $this->estado === 'finalizado';
    }
}
