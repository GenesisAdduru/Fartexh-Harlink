<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HairRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'contact_number',
        'gender',
        'story',
        'additional_photo',
        'status',
        'appointment_at',
        'notes',
        'documents'
    ];

    protected $casts = [
        'appointment_at' => 'datetime',
        'documents' => 'array',
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
