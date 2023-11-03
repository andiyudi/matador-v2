<?php

namespace App\Models;

use App\Models\Schedule;
use App\Models\TenderFile;
use App\Models\Procurement;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Id Procurement" . $this->procurement_id . " {$eventName} by : " . $userName)
        ->logUnguarded()
        ->logOnlyDirty()
        ->useLogName('tender');
    }

    public function procurement(){
        return $this->belongsTo(Procurement::class);
    }

    public function businessPartners(){
        return $this->belongsToMany(BusinessPartner::class, 'business_partner_tender')
        ->withPivot('start_hour', 'end_hour', 'is_selected', 'value_cost')
        ->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function tenderFile()
    {
        return $this->hasMany(TenderFile::class);
    }

}
