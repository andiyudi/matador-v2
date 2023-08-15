<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesPartner extends Model
{
    use HasFactory;
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
}
