<?php

namespace App\Http\Resources;

use App\Traits\Common;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            "customer_id" => $this->customer_id,
            "addresstype_id" => $this->addresstype_id,
            "addresstype" => $this->getAddressType->address_type,
            "hub_id" => $this->getCustomerNearestHub($this->id),
            "building_no" => $this->building_no,
            "street" => $this->street,
            "area" => $this->area,
            "landmark" => $this->landmark,
            "city_id" => $this->city_id,
            "city_name" => $this->cityname->city_name,
            "state_id" => $this->state_id,
            "state_name" => $this->statename->state_name,
            "country_id" => $this->country_id,
            "country_name" => $this->countryname->country_name,
            "pincode" => $this->pincode,
            "floor" => $this->floor,
            "is_lift_avail_working" => $this->is_lift_avail_working,
            "contact_person_name" => $this->contact_person_name,
            "contact_person_mobile" => $this->contact_person_mobile,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "geolocation" => $this->geolocation,
            "is_service_available" => $this->is_service_available,
            "is_default" => $this->is_default,
            "is_manual_address" => $this->is_manual_address,
            "is_order" => $this->is_order
        ];
    }
}
