<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
// this is just pivot for many to many realtion between blog and user i just created it for clearity
    protected $fillable =[
        'user_id',
        'blog_id'
    ];

    // this is the middle table for many to many

    public function user() : BelongsTo {
        return$this->belongsTo(User::class, 'user_id');
    }

    public function blog() : BelongsTo {
        return$this->belongsTo(Blog::class, 'blog_id');
    }

}
