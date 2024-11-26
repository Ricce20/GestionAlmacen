<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class Clasificacion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clasificacions')->insert([
            [
                'clave' => '5111',
                
            ],
            [
                'clave' => '5121',
                
            ],
            [
                'clave' => '5151',
                
            ],
            [
                'clave' => '5191',
                
            ],
            [
                'clave' => '5211',
                
            ],
            [
                'clave' => '5231',
                
            ],
            [
                'clave' => '5412',
                
            ],
            [
                'clave' => '5491',
                
            ],
            [
                'clave' => '5651',
                
            ],
            [
                'clave' => '5911',
                
            ],
            [
                'clave' => '5931',
                
            ],
            [
                'clave' => '5971',
                
            ],
              
            
        ]);
    }
}
