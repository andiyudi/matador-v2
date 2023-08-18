<?php

namespace App\Models;

use App\Models\Partner;
use App\Models\Business;
use App\Models\CategoryFiles;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartner extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'business_partner';
    protected $fillable = [
        'business_id',
        'partner_id',
        'is_blacklist',
        'blacklist_at',
        'can_whitelist_at',
        'whitelist_at',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function categoryFiles()
    {
        return $this->hasMany(CategoryFiles::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('business_partner');
    }
}
