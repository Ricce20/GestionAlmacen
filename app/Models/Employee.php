<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    public function asignacion():HasMany{
        return $this->hasMany(Asignacion::class);
    }
}
