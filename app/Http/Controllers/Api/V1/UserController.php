<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Blog;
use App\Models\like;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CloudinaryService;
use App\Http\Requests\ProfileImageRequest;
use App\Http\Requests\ProfileBioRequest;
use App\Http\Requests\ProfileSocialLinksRequest;
use App\Http\Resources\UserResource;

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

    public function follow(User $user)
    {
        $follower = request()->user();
        if ($follower->id === $user->id) {
            return response()->json([
                'message' => 'You cannot follow yourself',
                'data' => null
            ], 422);
        }

        // as i am the person that will follow the user
        if ($follower->isFollowing($user)) {
            $this->unfollowUser($follower, $user);
            return response()->json([
                'message' => 'User unfollowed successfully',
                'data' => null
            ]);
        }
        $this->followUser($follower, $user);
        return response()->json([
            'message' => 'User followed successfully',
            'data' => null
        ]);
    }

    private function followUser(User $follower, User $followed)
    {
        $follower->following()->attach($followed->id);
    }

    private function unfollowUser(User $follower, User $followed)
    {
        $follower->following()->detach($followed->id);
    }

    public function addProfilePhoto(ProfileImageRequest $request, CloudinaryService $cloudinary)
    {
        $user = request()->user();
        $image = $request->file('image');
        $result = $cloudinary->upload($image);
        auth()->user()->update(
            [
                'cloudinary_profile_image_public_id' => $result['id'],
                'cloudinary_profile_image_url' => $result['url'],
            ]
        );

        return response()->json([
            'message' => 'Profile photo added successfully',
            'data' => $result['url']
        ]);
    }

    public function addCoverPhoto(ProfileImageRequest $request, CloudinaryService $cloudinary)
    {
        $user = request()->user();
        $image = $request->file('image');
        $result = $cloudinary->upload($image);
        auth()->user()->update(
            [
                'cloudinary_cover_image_public_id' => $result['id'],
                'cloudinary_cover_image_url' => $result['url'],
            ]
        );

        return response()->json([
            'message' => 'Cover photo added successfully',
            'data' => $result['url']
        ]);
    }

    // should i delete the privous photo??
    private function updateProfilePhoto()
    {

    }

    public function addBio(ProfileBioRequest $request)
    {
        $user = request()->user();
        $user->update([
            'bio' => $request->bio
        ]);
        return response()->json([
            'message' => 'Bio added successfully',
            'data' => $user->bio
        ]);
    }

    public function addSocialLinke(ProfileSocialLinksRequest $request)
    {
        $user = request()->user();
        $user->update([
            'socialLinks' => $request->socialLinks
        ]);
        return response()->json([
            'message' => 'Social links added successfully',
            'data' => $user->socialLinks
        ]);

    }

    //need some modify
    // this no need to be authed
    public function getProfileDetailesByUserId(User $user)
    {
        // name image coverimage bio bologs sociallinks 
        return new UserResource($user);

    }
}
