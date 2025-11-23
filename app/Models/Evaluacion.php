<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    protected $table = 'evaluaciones';
    protected $fillable = [
        'id_estudiante', 'id_tutor', 'materia', 'tipo_evaluacion', 
        'calificacion', 'comentarios', 'fecha_evaluacion'
    ];

    protected $casts = [
        'calificacion' => 'decimal:1',
        'fecha_evaluacion' => 'date'
    ];

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'id_estudiante');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'id_tutor');
    }
}