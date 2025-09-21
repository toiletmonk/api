<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Redis;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function index(PostIndexRequest $request)
    {
        $filters = $request->validated();

        $key = 'posts.index' . md5(json_encode($filters));

        $post = Cache::remember($key, now()->addMinutes(10), function () use ($filters) {
            $this->postService->getFilteredPosts($filters);
        });

        return PostResource::collection($post);
    }

    public function create(CreatePostRequest $request)
    {
        $post = $request->validated();

        Post::create($post);

        return response()->json(['message'=>'Post created successfully']);
    }

    public function update(UpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validated();

        $post->update($data);

        return response()->json(['message'=>'Post updated successfully']);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return response()->json(['message'=>'Post deleted successfully']);
    }

    public function show(Request $request, $id)
    {
        $request->user();

        $post = Post::findOrFail($id);

        return response()->json($post);
    }
}
