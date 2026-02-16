<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // to show all blog for author
    public function index()
    {
        // in HasMany there are two way to call it first as variable 
        // its function  but laravel make it variable so you have to call the variable 
        // or as function then use get
        // if you will use paginate no need to call get function 
        // $data = request()->user()->blogs()->paginate(2);

        // this good because blogs with () will return query builder so you need to add get to return what you need
        $data = request()->user()->blogs()->with('author')->get();

        return BlogResource::collection($data);
        // return BlogResource::collection(Blog::with('author')->where('author_id', request()->user()->id)->paginate(2));
    }

    // to show specific blog for user 
    // unless its private but this i will do in future
    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }

    public function store(BlogRequest $request)
    {
        $validatedData = $request->validated();

        $blog = Blog::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'author_id' => request()->user()->id,
            'publish_at' => $validatedData['publish_at'],
        ]);


        return new BlogResource($blog);
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        abort_if($blog->author_id != $request->user()->id, 403, "Access_Denied");
        $validatedData = $request->validated();

        $blog->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'publish_at' => $validatedData['publish_at'],
        ]);

        return new BlogResource($blog);
    }

    public function destroy(Blog $blog, Request $request)
    {
        abort_if($blog->author_id != $request->user()->id, 403, "Access_Denied");
        $blog->delete();

        return response()->noContent();
    }
}
