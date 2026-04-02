<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'hair_length',
        'hair_color',
        'treated_hair',
        'address',
        'reason',
        'dropoff_location',
        'appointment_at',
        'status',
        'certificate_no'
    ];

    protected $casts = [
        'treated_hair' => 'boolean',
        'appointment_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories()
    {
        return $this->morphMany(StatusHistory::class, 'trackable');
    }
}
