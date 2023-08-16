<?php

namespace App\Models;

use App\Models\BusinessPartner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryFiles extends Model
{
    use HasFactory;

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
}
