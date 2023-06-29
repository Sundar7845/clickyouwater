<?php

namespace Database\Seeders;

use App\Models\AddressType as ModelsAddressType;
use Illuminate\Database\Seeder;

class AddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['address_type' => 'Home'],
            ['address_type' => 'Office'],
            ['address_type' => 'Institution'],
            ['address_type' => 'Other']
        ];

        ModelsAddressType::insert($data);
    }
}
