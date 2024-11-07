<?php

namespace App\Filament\Resources\DepreciacionResource\Pages;

use App\Filament\Resources\DepreciacionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class CreateDepreciacion extends CreateRecord
{
    protected static string $resource = DepreciacionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $datos = $this->createDepreciacion($data);
       // dd($datos);
        return static::getModel()::create($datos);
    }

    private function createDepreciacion(array $data){

        //obtenemos el producto
        $product = $this->getProductById($data['product_id']);
        //obtenmos los datos
        $costoInicial = $product->price;
        $valorResidual = $product->valor_recidual;
        $vidaUtil = $product->vida_util;
        $anios = $data['anios'];

        $depreciacionAnual = ($costoInicial - $valorResidual) / $vidaUtil;
       // Cálculo del porcentaje de depreciación respecto al costo inicial
        $porcentajeDepreciacionAnual = ($depreciacionAnual / $costoInicial) * 100;
       //valor lobros por anios ingresados
        $valorLibros = $costoInicial - ($depreciacionAnual * $anios);

        $datos = [
            'fecha_calculo' => $data['fecha_calculo'],
            'anios' => $data['anios'],
            'metodo' =>$data['metodo'],
            'porcentaje_depreciacion' => $porcentajeDepreciacionAnual,
            'monto_depreciacion' => $depreciacionAnual,
            'product_id' => $product->id,
            'valor_libros' => $valorLibros
        ];

        return $datos;
    }

    private function getProductById($id):?Product{
        return $product = Product::find($id);
       
    }
}
