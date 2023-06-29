<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['vehicle_type' => '2 Wheeler'],
            ['vehicle_type' => '3 Wheeler'],
            ['vehicle_type' => '4 Wheeler'],
            ['vehicle_type' => '6 Wheeler'],
            ['vehicle_type' => '10 Wheeler'],
            ['vehicle_type' => '12 Wheeler']
        ];

        VehicleType::insert($data);
    }
}
