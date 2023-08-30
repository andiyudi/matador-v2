<?php

namespace App\Models;

use App\Models\Tender;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Procurement extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = [
        'id',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function official()
    {
        return $this->belongsTo(Official::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('procurement');
    }

    public function tenders() {
        return $this->hasMany(Tender::class);
    }
}
