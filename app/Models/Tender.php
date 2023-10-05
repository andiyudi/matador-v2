<?php

namespace App\Models;

use App\Models\Schedule;
use App\Models\TenderFile;
use App\Models\Procurement;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [
        'id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('tender');
    }

    public function procurement(){
        return $this->belongsTo(Procurement::class);
    }

    public function businessPartners(){
        return $this->belongsToMany(BusinessPartner::class, 'business_partner_tender')
        ->withPivot('start_hour', 'end_hour', 'is_selected')
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
