<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Status extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            [
                'status' => 'Activo',
                'para_activo' => true,
                'para_partida' => false
            ],
            [
                'status' => 'Inactivo',
                'para_activo' => true,
                'para_partida' => false
            ],
            [
                'status' => 'Cancelado',
                'para_activo' => false,
                'para_partida' => true
            ],
            [
                'status' => 'Completado',
                'para_activo' => false,
                'para_partida' => true
            ],
            [
                'status' => 'En proceso',
                'para_activo' => false,
                'para_partida' => true
            ],
            [
                'status' => 'Baja',
                'para_activo' => true,
                'para_partida' => false
            ]
        ]);
    }
}
