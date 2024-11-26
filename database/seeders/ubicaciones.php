<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
class ubicaciones extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ubicacions')->insert([
            [
                'area' => '2000',
                
            ],
            [
               'area' => '2001',
                
            ],
            [
               'area' => '2002',
               
            ],
            [
                'area' => '2003',
                
            ],
            [
                'area' => '2004',
                
            ],
            [
                'area' => '2005',
                
            ],
            [
                'area' => '2005',
                
            ],
            [
                'area' => '2006',
                
            ],
            [
                'area' => '2007',
                
            ],
            [
                'area' => '2008',
                
            ],
            [
                'area' => '2009',
                
            ],
            [
                'area' => '2010',
                
            ],
            [
                'area' => '2011',
                
            ],
            [
                'area' => '2012',
                
            ],
            [
                'area' => '2013',
                
            ],
            [
                'area' => '2014',
                
            ]
        ]);
    }
}
