<?php

namespace Database\Seeders;

use App\Models\OfferType;
use Illuminate\Database\Seeder;

class OfferTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['offer_type_name' => 'Introduction'],
            ['offer_type_name' => 'Seasonal'],
            ['offer_type_name' => 'Common'],
            ['offer_type_name' => 'Special']
        ];
        OfferType::insert($data);
    }
}
