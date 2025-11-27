<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
=======
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3

    protected $fillable = [
        'name',
        'email', 
        'password',
        'role',
        'activo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'activo' => 'boolean',
    ];
<<<<<<< HEAD
    public function tutoriasComoTutor()
{
    return $this->hasMany(Tutoria::class, 'id_tutor');
}

public function tutoriasInscritas()
{
    return $this->belongsToMany(Tutoria::class, 'tutoria_estudiante', 'estudiante_id', 'tutoria_id')
                ->withPivot('estado', 'observaciones', 'created_at', 'updated_at')
                ->withTimestamps();
}

public function asistencias()
{
    return $this->hasMany(Asistencia::class, 'id_estudiante');
}
public function solicitudes()
{
    return $this->hasMany(Solicitud::class, 'id_estudiante');
}

public function solicitudesTutor()
{
    return $this->hasMany(Solicitud::class, 'id_tutor');
}
    /* public function estudiante() {
    return $this->belongsTo(User::class, 'id_estudiante');
}

    public function tutor() {
        return $this->belongsTo(User::class, 'id_tutor');
} */
    /* public function tutoriasComoTutor()
    {
        return $this->hasMany(Tutoria::class, 'id_tutor');
    }
    public function tutoriasInscritas()
    {
        return $this->belongsToMany(Tutoria::class, 'tutoria_estudiante', 'estudiante_id', 'tutoria_id')
                    ->withPivot('estado', 'observaciones', 'created_at', 'updated_at')
                    ->withTimestamps();
    } */
    // Verificar si es estudiante
   /*  public function isEstudiante()
    {
        return $this->role === 'estudiante';
    }

    // Verificar si es tutor
    public function isTutor()
    {
        return $this->role === 'tutor';
    } */
=======

    // Si no usas timestamps automáticos, descomenta esto:
    // public $timestamps = true;
>>>>>>> 41fa91920f3bd0f30fb2388e248023ec6ef7c5d3
}