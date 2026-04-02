<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'likes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(CommunityComment::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'community_post_likes', 'community_post_id', 'user_id')->withTimestamps();
    }
}
