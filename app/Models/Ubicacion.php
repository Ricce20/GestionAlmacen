<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ubicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'area',
        'descripcion',
    ];

    public function asignacion():HasMany{
        return $this->hasMany(Asignacion::class);
    }
}
