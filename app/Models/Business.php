<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['core_business_name', 'classification_name', 'parent_id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Business::class, 'parent_id');
    }
}
