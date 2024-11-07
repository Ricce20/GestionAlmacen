<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        

        $this->call(Status::class);
        $this->call(AcquisitionType::class);
        $this->call(CategoriesSeeders::class);
        $this->call(SuppliersSeeders::class);

        //\App\Models\Product::factory(10)->create();

        // \App\Models\Product::factory()->create([
        //     'name' => 'mesa1',
        //     'description' => 'mesa de madera',
        //     'brand' => 'ninguna',
        //     'model' => 'ninguna',
        //     'serial_number' => '122334234',
        //     'Utj_id' => '231',
        //     'key' => 'ddsd23213'
        // ]);


    }
}
