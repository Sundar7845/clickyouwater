<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'balance',
        'credit_debit',
        'wallet_transaction_type_id',
        'transaction_date',
        'transaction_status',
        'transaction_response',
        'transaction_id',
        'transaction_order_id'
    ];

    public function walletTransactionType()
    {
        return $this->belongsTo(WalletTransactionType::class, 'wallet_transaction_type_id', 'id');
    }
}
