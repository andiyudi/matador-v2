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

    public function businessPartners()
    {
        return $this->belongsToMany(BusinessPartner::class, 'business_partner_tender')
                    ->withPivot('start_hour', 'end_hour', 'is_selected', 'value_cost', 'document_pickup', 'aanwijzing_date', 'quotation')
                    ->withTimestamps();
    }

    public function tenders()
    {
        return $this->belongsToMany(Tender::class, 'business_partner_tender')
                    ->withPivot('start_hour', 'end_hour', 'is_selected', 'value_cost', 'document_pickup', 'aanwijzing_date', 'quotation')
                    ->withTimestamps();
    }

}
