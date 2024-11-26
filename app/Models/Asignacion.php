<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asignacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_asignacion',
        'employee_id',
        'ubicacion_id',
        'product_id',
        'fecha_finalizacion',
        'devuelto',
        'nota',
        'activo',
        'tipo_asignacion'
    ];
    protected $guarded = ['id'];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function employee():BelongsTo{
        return $this->belongsTo(Employee::class);
    }

    public function ubicacion():BelongsTo{
        return $this->belongsTo(Ubicacion::class);
    }

}
