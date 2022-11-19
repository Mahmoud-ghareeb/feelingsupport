<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeling extends Model
{
    use HasFactory;

    protected $fillable = [
        'reason',
        'image',
        'type',
        'category',
        'user_id'
    ];

    public function emojis()
    {
        return $this->belongsToMany('\App\Models\Emoji', 'feeling_emoji', 'feeling_id', 'emoji_id')
                    ->withTimestamps()
                    ->withPivot(['user_id']);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'feeling_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like', 'feeling_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'type_id', 'id');
    }

}
