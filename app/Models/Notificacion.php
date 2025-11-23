<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;
    protected $table = 'notificaciones';
    protected $fillable = [
        'id_estudiante', 'titulo', 'mensaje', 'tipo', 'leida'
    ];

    protected $casts = [
        'leida' => 'boolean'
    ];

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'id_estudiante');
    }
}