<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTypeResource extends JsonResource
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
            'id' => $this->id,
            'category_name' => $this->category->category_name,
            'product_type_name' => $this->product_type_name,
            'delivery_charge' => $this->delivery_charge,
            'delivery_duration' => $this->delivery_duration,
            'order_before_time' => $this->order_before_time,
            'newcan_deposit_amt' => $this->newcan_deposit_amt,
            'min_order_qty' => $this->min_order_qty,
            'max_order_qty' => $this->max_order_qty,
            'desc' => $this->desc
        ];
    }
}
