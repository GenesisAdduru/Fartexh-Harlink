<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'trackable_id',
        'trackable_type',
        'status'
    ];

    public function trackable()
    {
        return $this->morphTo();
    }
}
