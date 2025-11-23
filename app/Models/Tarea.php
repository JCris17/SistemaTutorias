<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    protected $fillable = [
        'id_estudiante', 'id_tutor', 'titulo', 'descripcion', 
        'materia', 'fecha_entrega', 'completada', 'observaciones'
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'completada' => 'boolean'
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