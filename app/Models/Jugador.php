<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    protected $table = 'jugadores';

    protected $fillable = [
        'equipo_id',
        'nombre',
        'apellido',
        'dorsal',
        'posicion',
        'altura',
        'fecha_nacimiento',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'altura' => 'decimal:2',
            'fecha_nacimiento' => 'date',
            'activo' => 'boolean',
        ];
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre.' '.$this->apellido;
    }
}
