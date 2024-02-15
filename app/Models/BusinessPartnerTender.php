<?php

namespace App\Models;

use App\Models\Negotiation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartnerTender extends Model
{
    use HasFactory;

    protected $table = 'business_partner_tender';
    protected $guarded = [
        'id',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function businessPartner()
    {
        return $this->belongsTo(BusinessPartner::class);
    }

    public function negotiations()
    {
        return $this->hasMany(Negotiation::class, 'business_partner_tender_id');
    }

}
