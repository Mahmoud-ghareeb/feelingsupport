<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment', 'user_id', 'feeling_id', 'parent_id', 'type', 'guest_name', 'image'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function feel()
    {
        return $this->belongsTo('App\Models\Feeling', 'feeling_id', 'id');
    }

    /**
     * Returns all comments that this comment is the parent of.
     */
    public function children()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    /**
     * Returns the comment to which this comment belongs to.
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Comment', 'child_id');
    }
}
