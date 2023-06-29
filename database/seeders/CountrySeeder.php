<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'country_code' => 'IN',
                'country_name' => 'india',
                'is_active'    => 1
            ]
        ];

        Country::insert($data);
    }
}
