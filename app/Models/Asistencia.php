<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'id_estudiante',
        'id_tutoria', 
        'asistio',
        'observaciones',
        'fecha_asistencia'
    ];

    protected $casts = [
        'asistio' => 'boolean',
        'fecha_asistencia' => 'datetime'
    ];

    // Relación con el estudiante
    public function estudiante()
    {
        return $this->belongsTo(User::class, 'id_estudiante');
    }

    // Relación con la tutoría
    public function tutoria()
    {
        return $this->belongsTo(Tutoria::class, 'id_tutoria');
    }
}