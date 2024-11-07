<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class AcquisitionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'es_tipo_venta',
        'es_tipo_donativo',
        'es_tipo_comodato',
        'es_tipo_baja',
        'es_tipo_compra',
    ];

    public function product():HasMany{
        return $this->hasMany(Product::class);
    }

    public function partida_especifica():HasMany{
        return $this->hasMany(PartidaEspecifica::class);
    }
}
