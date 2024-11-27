<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcquisitionType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('acquisition_types')->insert([
            [
                'type' => 'Compra',
                'es_tipo_venta' => false,
                'es_tipo_donativo' => false,
                'es_tipo_comodato' => false,
                'es_tipo_baja' => false,
                'es_tipo_compra' => true
            ],
            [
                'type' => 'Comodato',
                'es_tipo_venta' => false,
                'es_tipo_donativo' => false,
                'es_tipo_comodato' => true,
                'es_tipo_baja' => false,
                'es_tipo_compra' => false
            ],
            [
                'type' => 'Donacion',
                'es_tipo_venta' => false,
                'es_tipo_donativo' => true,
                'es_tipo_comodato' => false,
                'es_tipo_baja' => false,
                'es_tipo_compra' => false
            ],
            [
                'type' => 'Baja Activo',
                'es_tipo_venta' => false,
                'es_tipo_donativo' => false,
                'es_tipo_comodato' => false,
                'es_tipo_baja' => true,
                'es_tipo_compra' => false
            ]
        ]);
    }
}
