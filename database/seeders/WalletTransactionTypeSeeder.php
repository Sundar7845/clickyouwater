<?php

namespace Database\Seeders;

use App\Models\WalletTransactionType;
use Illuminate\Database\Seeder;

class WalletTransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['wallet_transaction_type' => 'Wallet Pending'],
            ['wallet_transaction_type' => 'Wallet Success'],
            ['wallet_transaction_type' => 'Wallet Failed'],
            ['wallet_transaction_type' => 'Referral'],
            ['wallet_transaction_type' => 'Used'],
            ['wallet_transaction_type' => 'Offers'],
            ['wallet_transaction_type' => 'Order Refund'],
            ['wallet_transaction_type' => 'Surrender Refund'],
            ['wallet_transaction_type' => 'Remove Referral']
        ];
        
        WalletTransactionType::insert($data);
    }
}