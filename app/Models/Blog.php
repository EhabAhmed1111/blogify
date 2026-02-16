<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'publish_at',
    ];
    protected $casts = [
        // ok the problem is this field is timestamp but in postman we put it as string so 
        // we have to trans it to time how by using casts that laravel provide that make our controller clean
        'publish_at' => 'datetime', // Automatically converts string to Carbon/timestamp
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'blog_id');
    }

    // return the number of likes on blog
    public function likesCount()
    {
        return $this->likes()->count();
    }

    // this is the users that liked the blog
    // this reverse relation of many to many  
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    // helper method
    public function isLikedBy(User $user): bool
    {
        return $this->likedBy()->where('user_id', $user->id)->exists();
    }



    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'blog_id');
    }
    public function commentsCount()
    {
        return $this->comments()->count();
    }
}
