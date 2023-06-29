<?php

namespace App\Http\Resources;

use App\Traits\Common;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryPersonOrderResource extends JsonResource
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
            'order_id' => $this->id,
            'order_no' => $this->order_no,
            'invoice_no' => $this->invoice_no,
            'delivery_address' => $this->delivery_address,
            'delivery_desc' => $this->desc,
            'total_qty' => $this->total_qty,
            'status_id' => $this->status_id,
            'status_name' => $this->status->status,
            'status_msg' => $this->status->status_msg,
            'is_cancel' => $this->is_cancel,
            'exp_delivery_date' => DateTime::createFromFormat('Y-m-d H:i:s', $this->exp_delivery_date)->format('d M,y h:i A'),
            'transaction_date' => DateTime::createFromFormat('Y-m-d H:i:s', $this->transaction_date)->format('d M,y'),
            'transaction_amount' => $this->transaction_amount,
            'transaction_status' => $this->transaction_status,
            'is_elite' => $this->getOrderHasEliteItems($this->id),
            'order_details' => $this->orderDets->map(function ($orderdet) {
                return [
                    'product_id' => $orderdet->product_id,
                    'product_name' => $orderdet->products->product_name,
                    'quantity' => $orderdet->qty,
                    'return_empty_cans_qty' => $orderdet->return_empty_cans_qty,
                ];
            }),
            // 'delivery_user_id' => $this->getDeliveryUserId($this->id, false),
            // 'delivery_person_name' => $this->getDeliveryPersonName($this->id, false),
            // 'customer_rating' => $this->getCustomerRating($this->id),
            // 'delivered_on' => ($this->getDeliveryDate($this->id, false) != null ?
            //     DateTime::createFromFormat('Y-m-d H:i:s', $this->getDeliveryDate($this->id, false))->format('d M,y h:i A') : null),
            'delivery_details' => $this->orderDeliveries->filter(function ($delivery) {
                return $delivery->is_notdelivered == 0;
            })->map(function ($delivery) {
                return [
                    'delivery_id' => $delivery->id,
                    'delivery_user_id' => $this->getDeliveryUserId($this->id, false),
                    'delivery_person_name' => $this->getDeliveryPersonName($this->id, false),
                    'floor' => $delivery->floor,
                    'is_lift' => $delivery->is_lift,
                    'delivery_user_notes' => $delivery->delivery_user_notes,
                    'delivery_reason' => $delivery->delivery_reason,
                    'customer_rating' => $delivery->customer_rating,
                    'is_highlighted' => ($delivery->is_highlighted == 1 ? true : false),
                    'is_notdelivered' => $delivery->is_notdelivered,
                    'delivered_on' => ($this->getDeliveryDate($this->id, false) != null ?
                        DateTime::createFromFormat('Y-m-d H:i:s', $this->getDeliveryDate($this->id, false))->format('d M,y h:i A') : null),

                ];
            })->values(),
            'couldnotdeliver_details' => $this->orderDeliveries->filter(function ($delivery) {
                return $delivery->is_notdelivered == 1;
            })->map(function ($delivery) {
                return [
                    'delivery_user_id' => $this->getDeliveryUserId($this->id, true),
                    'delivery_person_name' => $this->getDeliveryPersonName($this->id, true),
                    'delivery_reason' => $delivery->delivery_reason,
                    'is_notdelivered' => $delivery->is_notdelivered,
                    'delivered_on' => ($this->getDeliveryDate($this->id, false) != null ?
                        DateTime::createFromFormat('Y-m-d H:i:s', $this->getDeliveryDate($this->id, true))->format('d M,y h:i A') : null),
                ];
            }),
        ];
    }
}
