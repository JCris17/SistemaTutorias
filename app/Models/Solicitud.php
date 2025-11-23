<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitudes';
    protected $fillable = [
        'id_estudiante', 'id_tutor', 'tipo', 'materia', 
        'descripcion', 'urgencia', 'estado', 'respuesta'
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