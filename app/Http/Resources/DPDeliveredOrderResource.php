<?php

namespace App\Http\Resources;

use App\Traits\Common;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class DPDeliveredOrderResource extends JsonResource
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
            'customer_rating' => $this->getCustomerRating($this->id),
            'delivered_on' => ($this->getDeliveryDate($this->id, false) != null ?
                DateTime::createFromFormat('Y-m-d H:i:s', $this->getDeliveryDate($this->id, false))->format('d M,y h:i A') : null),
        ];
    }
}
