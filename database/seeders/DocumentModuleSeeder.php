<?php

namespace Database\Seeders;

use App\Models\DocumentModules;
use Illuminate\Database\Seeder;

class DocumentModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['module_name' => 'Manufacturer'],
            ['module_name' => 'Hub'],
            ['module_name' => 'Logistic'],
            ['module_name' => 'Delivery Person'],
            ['module_name' => 'Wholesle Partner'],
            ['module_name' => 'Employee'],
            ['module_name' => 'Driver'],
        ];

        DocumentModules::insert($data);
    }
}
