<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Blog;
use App\Models\like;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // to like blog
    public function like(Blog $blog)
    {
        $user = request()->user();

        // here if the blog is liked by the user already it will remove the like
        if ($blog->isLikedBy($user)) {
            $this->unlikeBlog($user, $blog);
            return response()->json([
                'message' => 'Blog unliked successfully',
            ]);
        }

        // here if the blog is not liked by the user it will add the like
        $this->likeBlog($user, $blog);
        return response()->json([
            'data' => 'Blog liked successfully',
        ]);
    }

    private function likeBlog(User $user, Blog $blog)
    {
        $user->likedBlogs()->attach($blog->id);
    }

    private function unlikeBlog(User $user, Blog $blog)
    {
        $user->likedBlogs()->detach($blog->id);
    }

    public function commentToBLog(Blog $blog)
    {
        $user = request()->user();
        $blog->comments()->create([
            'content' => request('content'),
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'data' => new CommentResource($blog->comments()->latest()->first()),
        ]);
    }
}
