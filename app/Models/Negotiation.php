<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Negotiation extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [
        'id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Business Partner Tender " . $this->business_partner_tender_id . " {$eventName} by : " . $userName)
        ->logUnguarded()
        ->logOnlyDirty()
        ->useLogName('negotiation');
    }
}
