<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WigProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_code',
        'wigmaker_id',
        'donation_id',
        'target_length',
        'target_color',
        'status',
        'due_date',
    ];

    public function wigmaker()
    {
        return $this->belongsTo(User::class, 'wigmaker_id');
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
