<?php

namespace App\Http\Resources;

use App\Traits\Common;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class DPPickupOrderResource extends JsonResource
{
    use Common;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        return [
            'surrender_id' => $this->id,
            'surrender_order_no' => $this->surrender_order_no,
            'user_id' => $this->user_id,
            'pickup_address' => $this->pickup_address,
            'reason_id' => $this->reason_id,
            'reason' => $this->reason->reason,
            'total_qty' => $this->total_qty,
            'status_id' => $this->status_id,
            'status_name' => $this->status->status,
            'status_msg' => $this->status->status_msg,
            'created_at' => DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d M,y'),
            'surrender_details' => $this->surrenderDets->map(function ($surrenderdet) {
                return [
                    'product_id' => $surrenderdet->product_id,
                    'product_name' => $surrenderdet->products->product_name,
                    'quantity' => $surrenderdet->qty
                ];
            })
        ];
    }
}
