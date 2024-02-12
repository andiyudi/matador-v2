<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessPartnerTender;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Negotiation extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [
        'id',
    ];

    public function businessPartnerTender()
    {
        return $this->belongsTo(BusinessPartnerTender::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Negotiation business partner tender " . $this->business_partner_tender_id . " {$eventName} by : " . $userName)
        ->logUnguarded()
        ->logOnlyDirty()
        ->useLogName('negotiation');
    }
}
