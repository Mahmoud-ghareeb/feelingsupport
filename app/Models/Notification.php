<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'owner_id',
        'type_id',
        'type',
        'comment_id',
        'replay_id',
        'replayed_id',
        'replayed_on',
        'replayed_on_ids',
        'message',
        'is_viewed'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function feeling()
    {
        return $this->belongsTo('App\Models\Feeling', 'type_id', 'id');
    }
}
