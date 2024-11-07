<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
class SuppliersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'razon_social' => 'Comercializadora y Servicios Industriales S.A. de C.V.',
                'status' => 'Activo',
                'RFC' => 'CSI920716H32',
                'tipo_comprobante_fiscal' => 'Factura',
                'domicilio' => 'Av. Paseo de la Reforma 123, Piso 5',
                'colonia' => 'Cuauhtémoc',
                'codigo_postal' => '06500',
                'email' => 'contacto@comercializadora.mx',
                'telefono_1' => '52 55 1234 5678',
                'telefono_2' => '52 55 8765 4321'
            ],[
                'razon_social' => 'Comercializadora y Servicios Industriales S.A. de C.V.',
                'status' => 'Activo',
                'RFC' => 'CSI920716H32',
                'tipo_comprobante_fiscal' => 'Factura',
                'domicilio' => 'Av. Paseo de la Reforma 123, Piso 5',
                'colonia' => 'Cuauhtémoc',
                'codigo_postal' => '06500',
                'email' => 'contacto2@comercializadora.mx',
                'telefono_1' => '52 55 1234 5678',
                'telefono_2' => '52 55 8765 4321'
            ],[
                'razon_social' => 'Comercializadora y Servicios Industriales S.A. de C.V.',
                'status' => 'Activo',
                'RFC' => 'CSI920716H32',
                'tipo_comprobante_fiscal' => 'Factura',
                'domicilio' => 'Av. Paseo de la Reforma 123, Piso 5',
                'colonia' => 'Cuauhtémoc',
                'codigo_postal' => '06500',
                'email' => 'contacto3@comercializadora.mx',
                'telefono_1' => '52 55 1234 5678',
                'telefono_2' => '52 55 8765 4321'
            ],
        ]);
    }
}
