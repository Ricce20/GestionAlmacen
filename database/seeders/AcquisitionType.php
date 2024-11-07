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
                'type' => 'Compra'
            ],
            [
                'type' => 'Comodato'
            ],
            [
                'type' => 'Donacion'
            ],
            [
                'type' => 'Baja Activo'
            ]
        ]);
    }
}
