<?php

namespace App\Models;

use App\Models\BusinessPartner;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryFiles extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'category_files';
    protected $fillable = [
        'category_id',
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
        return LogOptions::defaults()
        ->useLogName('category_files');
    }
}
