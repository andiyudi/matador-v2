<?php

namespace App\Models;

use App\Models\BusinessPartner;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartnerFiles extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'business_partner_files';
    protected $fillable = [
        'business_partner_id',
        'type',
        'name',
        'path',
        'notes',
    ];

    public function category()
    {
        return $this->belongsTo(BusinessPartner::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => $this->name . " {$eventName} by : " . $userName)
        ->logFillable()
        ->logOnlyDirty()
        ->useLogName('business_partner_files');
    }
}
