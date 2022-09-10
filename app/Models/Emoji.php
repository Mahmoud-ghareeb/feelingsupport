<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{
    use HasFactory;

    protected $table = 'emojis';
    protected $fillable = [
        'type_es',
        'type_fr',
        'type_it',
        'type_tr',
        'type_de',
        'type_en',
        'type_ar',
        'type_hi',
        'type_zh',
        'type_ur',
        'type_fa',
        'type_bn',
        'type_id',
        'type_ru',
        'type_pt',
        'type_ko',
        'type_ja',
        'type_ms',
        'category',
        'css_class',
        'color'
    ];
    public $timestamps = false;

    public function feelings()
    {
        return $this->belongsToMany('\App\Models\Feeling', 'feeling_emoji', 'emoji_id', 'feeling_id');
    }

}
