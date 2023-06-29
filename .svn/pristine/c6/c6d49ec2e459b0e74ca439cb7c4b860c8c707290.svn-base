<?php

namespace App\Http\Resources;

use App\Traits\Common;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'name' => $this->display_name,
            'email' => $this->email,
            'user_img_path' => ($this->user_img_path == null ? "" : url($this->user_img_path)),
            'referral_code' => $this->referral_code,
            'last_login' => $this->last_login,
            'mobile' => $this->getCustomer($this->ref_id)->mobile,
            'referral_code' => $this->referral_code,
            'customertype_id' => $this->getCustomer($this->ref_id)->customertype_id,
            'wallet_points' => $this->wallet_points,
            'notification_count' => $this->getUnReadNotificationCount(),
            'cans_with_you' => $this->getCansInHand(),
            'is_approved' => $this->is_approved,
            'account_holder_name' => $this->account_holder_name,
            'account_no' => $this->account_no,
            'ifsc_code' => $this->ifsc_code,
            'bank_name' => $this->bank_name,
            'branch_name' => $this->branch_name
        ];
    }
}
