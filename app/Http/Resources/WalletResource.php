<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'wallet_id' => $this->id,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'credit_debit' => $this->credit_debit,
            'wallet_transaction_type_id' => $this->wallet_transaction_type_id,
            'wallet_transaction_type' => $this->walletTransactionType->wallet_transaction_type,
            'transaction_date' => DateTime::createFromFormat('Y-m-d H:i:s', $this->transaction_date)->format('d M,y h:i A'),
            'transaction_status' => $this->transaction_status,
            'transaction_response' => $this->transaction_response,
            'transaction_id' => $this->transaction_id,
            'wallet_transaction_msg' => $this->wallet_transaction_msg
        ];
    }
}
