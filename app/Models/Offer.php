<?php

namespace App\Models;

use App\Models\Procurement;
use App\Models\BusinessPartner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{

    use HasFactory;
    protected $table = 'offers';
    protected $guarded = [
        'id',
    ];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function category()
    {
        return $this->belongsTo(BusinessPartner::class);
    }
}
