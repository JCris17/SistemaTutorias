<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutoria extends Model
{
    use HasFactory;
    
    protected $table = 'tutorias';
    protected $fillable = [
        'id_estudiante',
        'id_tutor',
        'tema',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'observaciones',
        'estado',
        'modalidad',
        'ubicacion',
        'duracion',
        'materia',
        'cupo_maximo'
    ];

    // Relación con el estudiante (para compatibilidad con el sistema anterior)
    public function estudiante() {
        return $this->belongsTo(User::class, 'id_estudiante');
    }

    // Relación con el tutor
    public function tutor() {
        return $this->belongsTo(User::class, 'id_tutor');
    }
public function asistencias()
{
    return $this->hasMany(Asistencia::class, 'id_tutoria');
}

public function estudiantes()
{
    return $this->belongsToMany(User::class, 'tutoria_estudiante', 'tutoria_id', 'estudiante_id')
                ->withPivot('estado', 'observaciones', 'created_at', 'updated_at')
                ->withTimestamps();
}
   /*  // Relación muchos-a-muchos con estudiantes (CORREGIDA)
    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'tutoria_estudiante', 'tutoria_id', 'estudiante_id')
                    ->withPivot('estado', 'observaciones', 'created_at', 'updated_at')
                    ->withTimestamps();
    }

    // Scope para tutorías activas
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    // Scope para tutorías pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    // Scope para tutorías futuras
    public function scopeFuturas($query)
    {
        return $query->where('fecha', '>=', now());
    }

    // Verificar si un estudiante específico está inscrito
    public function estaInscrito($estudianteId)
    {
        return $this->estudiantes()->where('estudiante_id', $estudianteId)->exists();
    }

    // Obtener el estado de inscripción de un estudiante específico
    public function estadoInscripcion($estudianteId)
    {
        $inscripcion = $this->estudiantes()->where('estudiante_id', $estudianteId)->first();
        return $inscripcion ? $inscripcion->pivot->estado : null;
    } */
}