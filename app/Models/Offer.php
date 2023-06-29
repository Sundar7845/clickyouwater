<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_type_id',
        'offer_name',
        'validity',
        'start_date',
        'end_date',
        'offer_total_points',
        'offer_claim_points',
        'offer_image_path',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function offerType()
    {
        return $this->belongsTo(OfferType::class, 'offer_type_id');
    }
    public function allocation()
    {
        return $this->hasOne(OfferAllocation::class, 'offer_id');
    }
    public function offerCode()
    {
        return $this->hasOne(OfferCode::class, 'offer_id');
    }
    public function offerHubAllocation()
    {
        return $this->hasOne(OfferHubAllocation::class, 'offer_id');
    }
}
