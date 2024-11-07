<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depreciacion extends Model
{
    use HasFactory;

    protected $table = 'depreciaciones';

    protected $fillable = [
        'anios',
        'fecha_calculo',
        'metodo',
        'porcentaje_depreciacion',
        'monto_depreciacion',
        'valor_libros',
        'product_id'
    ];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }

}
