<?php

namespace Database\Seeders;

use App\Models\PaymentMode;
use Illuminate\Database\Seeder;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['payment_mode' => 'CASH'],
            ['payment_mode' => 'CHEQUE'],
            ['payment_mode' => 'DD'],
            ['payment_mode' => 'NEFT'],
            ['payment_mode' => 'UPI'],
            ['payment_mode' => 'RTGS'],
            ['payment_mode' => 'CARD']
        ];

        PaymentMode::insert($data);
    }
}
