<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio_factura',
        'fecha_factura',
        'costo',
        'objeto_gasto_id'
    ];

    public function objeto_gasto():BelongsTo{
        return $this->belongsTo(ObjetoGasto::class);
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
        return self::where('folio_factura', $folio)->exists();
    }
}
