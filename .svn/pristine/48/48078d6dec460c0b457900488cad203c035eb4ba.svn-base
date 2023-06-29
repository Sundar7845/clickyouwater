<?php

namespace App\Http\Resources;

use App\Traits\Common;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductDetails extends JsonResource
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'return_empty_cans_qty' => $this->return_empty_cans_qty,
            'product_image' => url($this->products->product_image),
            'product_name' => $this->products->product_name,
            'customer_price' => $this->products->customer_price,
            'wholesale_price' => $this->products->wholesale_price,
            'cgst' => $this->products->CGST,
            'sgst' => $this->products->SGST,
            'capacity' => $this->products->capacity,
            'brand_name' => $this->products->brand->brand_name,
            'return_empty_cans' => $this->return_empty_cans,
            'newcan_deposit_amt' => $this->products->productType->newcan_deposit_amt,
            // 'min_order_qty' => $this->products->productType->min_order_qty,
            'min_order_qty' => $this->min_order_qty,
            'max_order_qty' => $this->products->productType->max_order_qty,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
