<?php

namespace App\Models;

use App\Models\Procurement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{

    use HasFactory;
    protected $table = 'offers';
    protected $guarded = [
        'id',
    ];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }
}
