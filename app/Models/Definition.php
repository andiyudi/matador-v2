<?php

namespace App\Models;

use App\Models\ProcurementFile;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Definition extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
    ];

    protected static $logFillable = true;

    public function definition_procurement_files()
    {
        return $this->hasMany(ProcurementFile::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => $this->name . " {$eventName} by : " . $userName)
        ->logFillable()
        ->logOnlyDirty()
        ->useLogName('definition');
    }
}
