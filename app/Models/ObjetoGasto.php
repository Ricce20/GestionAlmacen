<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObjetoGasto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuenta',
        'concepto',
        'vida',
        'product_id',
        'partida_especifica_id'
    ];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function partida_especifica():BelongsTo{
        return $this->belongsTo(PartidaEspecifica::class);
    }

    public function factura():BelongsTo{
        return $this->belongsTo(Factura::class);
    }

}
