<?php

namespace App\Models;

use App\Models\Tender;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenderFile extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tender_files';
    protected $fillable = [
        'tender_id',
        'type',
        'name',
        'path',
        'notes',
    ];

    public function fileTender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('tender_files');
    }
}
