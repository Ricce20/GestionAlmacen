<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'brand',
        'model',
        'serial_number',
        'price',
        'valor_recidual',
        'vida_util',
        'Utj_id',
        'key',
        'acquisition_type_id',
        'status_id',
        'category_id'
    ];

    // public function acquisition_type():BelongsTo{
    //     return $this->belongsTo(AcquisitionType::class);
    // }
    public function asignacion():HasMany{
        return $this->hasMany(Asignacion::class);
    }
    public function status():BelongsTo{
        return $this->belongsTo(Status::class);
    }
    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function supplierproduct():HasMany{
        return $this->hasMany(SupplierProduct::class);
    }

    public function depreciacion():BelongsTo{
        return $this->belongsTo(Depreciacion::class);
    }

    public function partidaespecifica():HasMany{
        return $this->hasMany(PartidaEspecifica::class);
    }

    public function objeto_gasto():HasMany{
        return $this->hasMany(ObjetoGasto::class);
    }

}
