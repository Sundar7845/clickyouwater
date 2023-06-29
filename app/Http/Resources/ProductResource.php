<?php

namespace App\Http\Resources;

use App\Traits\Common;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_id' => $this->id,
            'product_name' => $this->product_name,
            'product_type_id' => $this->product_type_id,
            'product_type_name' => $this->productType->product_type_name,
            'product_type_desc' => $this->productType->desc,
            'order_before_time' => $this->productType->order_before_time,
            'newcan_deposit_amt' => $this->productType->newcan_deposit_amt,
            // 'min_order_qty' => $this->productType->min_order_qty,
            'max_order_qty' => $this->productType->max_order_qty,
            'delivery_info' => $this->getDeliveryInfo($this->product_type_id, $this->productType->order_before_time, $this->productType->delivery_duration),
            'brand_id' => $this->brand_id,
            'brand' => $this->brand->brand_name,
            "category_id" => $this->category_id,
            "category_name" => $this->category->category_name,
            "product_image" => $this->product_image,
            "customer_price" => $this->customer_price,
            "wholesale_price" => $this->wholesale_price,
            "capacity" => $this->capacity,
            "desc" => $this->desc,
            "is_emptycan_return" => $this->is_emptycan_return,
            'return_empty_cans' => $this->return_empty_cans,
            "CGST" => $this->CGST,
            "SGST" => $this->SGST,
            "is_cart" => $this->is_cart,
            "cart_id" => $this->cart_id,
            "cart_qty" => $this->cart_qty,
            "min_order_qty" => $this->min_order_qty,
        ];
    }
}
