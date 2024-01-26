<?php

namespace App\Models;

use App\Models\Procurement;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcurementFile extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'procurement_files';
    protected $fillable = [
        'procurement_id',
        'type',
        'name',
        'path',
        'notes',
    ];

    public function fileProcurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $userName = optional(Auth::user())->username;

        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => $this->name . " {$eventName} by : " . $userName)
        ->logFillable()
        ->logOnlyDirty()
        ->useLogName('procurement_files');
    }
}
