<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FilesPartner extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'files_partner';
    protected $fillable = [
        'partner_id',
        'type',
        'name',
        'path',
        'notes',
    ];
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => $this->name . " {$eventName} by : " . $userName)
        ->logFillable()
        ->logOnlyDirty()
        ->useLogName('files_partner');
    }
}
