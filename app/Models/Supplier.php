<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'razon_social',
        'status',
        'RFC',
        'tipo_comprobante_fiscal',
        'domicilio',
        'colonia',
        'codigo_postal',
        'email',
        'telefono_1',
        'telefono_2'
    ];

    public function supplierproduct():HasMany{
        return $this->hasMany(SupplierProduct::class);
    }
}
