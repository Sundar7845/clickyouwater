<?php

namespace App\Http\Resources;

use App\Traits\Common;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class SurrenderOrderResource extends JsonResource
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
            'reason_id' => $this->reason_id,
            'reason' => $this->reason->reason,
            'hub_id' => $this->hub_id,
            'status_id' => $this->status_id,
            'status_name' => $this->status->status,
            'status_msg' => $this->status->status_msg,
            'address_id' => $this->address_id,
            'address' => UserAddressResource::collection($this->getCustomerAddress_details($this->address_id, $this->user_id))->values(),
            'refund_amount' => $this->refund_amount,
            'refund_to' => $this->refund_to,
            'reject_reason_note' => $this->reject_reason_note,
            'created_at' => DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d M,y'),
            'surrender_details' => $this->surrenderDets->map(function ($surrenderdet) {
                if ($surrenderdet->products) {
                    return [
                        'product_id' => $surrenderdet->product_id,
                        'product_name' => $surrenderdet->products->product_name,
                        'quantity' => $surrenderdet->qty,
                        'deposit_amount' => $surrenderdet->deposit_amount,
                        'collected_can_qty' => $surrenderdet->collected_can_qty,
                        'damaged_can_qty' => $surrenderdet->damaged_can_qty,
                    ];
                }
                return null; // Return null or handle the case when 'products' is null
            })->filter(),
            'pickup_details' => $this->surrenderPickups->map(function ($pickup) {
                return [
                    'delivery_id' => $pickup->id,
                    'delivery_user_id' => $pickup->delivery_user_id,
                    'delivery_person_name' => $this->getPickupPersonName($pickup->delivery_user_id),
                    'notes' => $pickup->notes,
                    'picked_on' => DateTime::createFromFormat('Y-m-d H:i:s', $pickup->created_at)->format('d M,y H:i A'),
                ];
            })->values(),
        ];
    }
}
