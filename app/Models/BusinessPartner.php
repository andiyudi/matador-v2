<?php

namespace App\Models;

use App\Models\Partner;
use App\Models\Business;
use App\Models\Negotiation;
use Spatie\Activitylog\LogOptions;
use App\Models\BusinessPartnerFiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartner extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'business_partner';
    protected $fillable = [
        'business_id',
        'partner_id',
        'is_blacklist',
        'blacklist_at',
        'can_whitelist_at',
        'whitelist_at',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function businessPartnerFiles()
    {
        return $this->hasMany(BusinessPartnerFiles::class, 'business_partner_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Id Partner " . $this->partner_id . " Id Business " . $this->business_id . " {$eventName} by : " . $userName)
        ->logFillable()
        ->logOnlyDirty()
        ->useLogName('business_partner');
    }

    public function tenders()
    {
        return $this->belongsToMany(Tender::class, 'business_partner_tender')
        ->withPivot('start_hour', 'end_hour', 'is_selected', 'value_cost', 'document_pickup', 'aanwijzing_date', 'quotation')
        ->withTimestamp();
    }

    public function negotiations()
    {
        return $this->hasMany(Negotiation::class, 'business_partner_id');
    }

}
