<?php

namespace App\Models;

use App\Models\Partner;
use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartner extends Model
{
    use HasFactory;
    protected $table = 'business_partner';

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
