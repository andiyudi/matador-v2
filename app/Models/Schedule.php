<?php

namespace App\Models;

use App\Models\Tender;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [
        'id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => $this->activity . " {$eventName} by : " . $userName)
        ->logUnguarded()
        ->logOnlyDirty()
        ->useLogName('schedule');
    }

    public function tender(){
        return $this->belongsTo(Tender::class);
    }
}
