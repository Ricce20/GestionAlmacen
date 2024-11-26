<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Traslado extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacion_id',
        'fecha_inicio',
        'origen_employee_id',
        'origen_activo_id',
        'motivo_tralado',
        'destinatario_employee_id',
        'nueva_ubicacion',
        'fecha_cierre',
        'aceptado',
        'motivo_destinatario'
    ];

    public function origen_employee():BelongsTo{
        return $this->belongsTo(Employee::class);
    }

    public function origen_activo():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function destinatario_employee():BelongsTo{
        return $this->belongsTo(Employee::class);
    }
}
