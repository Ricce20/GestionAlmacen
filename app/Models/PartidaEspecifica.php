<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartidaEspecifica extends Model
{
    use HasFactory;

    protected $table = 'partidas_especificas';

    protected $fillable = [
        'folio',
        'nombre_partida',
        'acquisition_type_id',
        'product_id',
        'fecha_creacion',
        'status_id'
    ];

    public function status():BelongsTo{
        return $this->belongsTo(Status::class);
    }

    public function acquisition_type():BelongsTo{
        return $this->belongsTo(AcquisitionType::class);
    }
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
    public function objeto_gasto():HasMany{
        return $this->hasMany(ObjetoGasto::class);
    }
    public static function generarFolioUnico(): string
    {
        do {
            // Genera un folio aleatorio de 7 caracteres
            $folio = strtoupper(Str::random(7));
        } while (self::folioExiste($folio));

        return $folio;
    }

    protected static function folioExiste(string $folio): bool
    {
        return self::where('folio', $folio)->exists();
    }

}
