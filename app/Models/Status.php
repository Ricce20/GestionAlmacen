<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'para_activo',
        'para_partida'
    ];

    public function Product():HasMany{
        return $this->hasMany(Product::class);
    }

    public function partida_especifica():HasMany{
        return $this->hasMany(PartidaEspecifica::class);
    }

}
