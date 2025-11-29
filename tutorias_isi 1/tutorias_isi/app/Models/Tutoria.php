<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_estudiante',
        'id_tutor',
        'tema',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'observaciones'
    ];

    public function estudiante() {
        return $this->belongsTo(User::class, 'id_estudiante');
    }

    public function tutor() {
        return $this->belongsTo(User::class, 'id_tutor');
    }
}
