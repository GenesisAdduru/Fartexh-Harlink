<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = CommunityPost::with([
                'user', 
                'comments' => function($query) {
                    $query->whereNull('parent_id')
                        ->with(['user', 'replies.user'])
                        ->orderBy('created_at', 'asc');
                }
            ])
            ->withCount('likedByUsers as likes')
            ->withExists(['likedByUsers as is_liked' => function($query) {
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($posts);
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120' // 5MB max
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('community/posts', 's3');
            $imageUrl = \Illuminate\Support\Facades\Storage::disk('s3')->url($path);
        }

        $post = $user->communityPosts()->create([
            'content' => $validated['content'],
            'image_url' => $imageUrl
        ]);
        
        $post->setAttribute('likes', 0);

        return response()->json($post->load(['user', 'comments']), 201);
    }

    public function storeComment(Request $request, CommunityPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|uuid|exists:community_comments,id',
            'image' => 'nullable|image|max:5120'
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('community/comments', 's3');
            $imageUrl = \Illuminate\Support\Facades\Storage::disk('s3')->url($path);
        }

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
            'image_url' => $imageUrl
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function toggleLike(CommunityPost $post)
    {
        $user = Auth::user();
        $isLiked = false;
        
        if ($user->likedPosts()->where('community_post_id', $post->id)->exists()) {
            $user->likedPosts()->detach($post->id);
        } else {
            $user->likedPosts()->attach($post->id);
            $isLiked = true;
        }

        return response()->json([
            'likes' => $post->likedByUsers()->count(),
            'is_liked' => $isLiked
        ]);
    }

    public function destroyPost(CommunityPost $post)
    {
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized deletion'], 403);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function destroyComment(CommunityComment $comment)
    {
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized deletion'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
