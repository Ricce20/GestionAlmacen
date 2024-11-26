<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_empleado',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'puesto',
        'activo',
        'posicion'
    ];

    public function asignacion():HasMany{
        return $this->hasMany(Asignacion::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function traslado():HasMany{
        return $this->hasMany(Traslado::class);
    }
}
