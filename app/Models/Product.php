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
        'vida_util',
        'folio',
        'clasificacion_id',
        'status_id',
        'category_id'
    ];

    public static function generarFolioUnico($clasificacion): string
    {
        // Obtener el último folio registrado en la base de datos
        $ultimoFolio = self::select('folio','clasificacion_id')->where('clasificacion_id', $clasificacion)->latest('folio')->first();
       // dd($ultimoFolio);
        // Si no existe un folio previo, iniciar desde 00001
        if (!$ultimoFolio) {
           
            $nuevoFolioNumero = 1;
        } else {
            // Extraer el número del folio, eliminar "FOLIO-" y convertir a entero
            $ultimoFolioNumero = intval(substr($ultimoFolio->folio, 5));
            $nuevoFolioNumero = bcadd($ultimoFolioNumero,'1');
           // dd($nuevoFolioNumero );
        }
        $clasificacion = Clasificacion::where('id',$clasificacion)->select('clave')->first();
       // dd($clasificacion);
        // Crear el nuevo folio con el formato FOLIO-00000
        $nuevoFolio = $clasificacion->clave. '-' . str_pad($nuevoFolioNumero, 5, '0', STR_PAD_LEFT);
       // dd($nuevoFolio);
        return $nuevoFolio;
    }

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

    public function clasificacion():BelongsTo{
        return $this->belongsTo(Clasificacion::class);
    }

}
