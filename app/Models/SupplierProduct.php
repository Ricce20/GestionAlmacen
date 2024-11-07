<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'precio_compra',
        'status'
    ];

    public function supplier():BelongsTo{
        return $this->belongsTo(Supplier::class);
    }

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
