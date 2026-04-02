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
        $posts = CommunityPost::with(['user', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($posts);
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $post = Auth::user()->communityPosts()->create($validated);

        return response()->json($post->load('user'), 201);
    }

    public function storeComment(Request $request, CommunityPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content']
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function toggleLike(CommunityPost $post)
    {
        $user = Auth::user();
        
        if ($user->likedPosts()->where('community_post_id', $post->id)->exists()) {
            $user->likedPosts()->detach($post->id);
            $post->decrement('likes');
        } else {
            $user->likedPosts()->attach($post->id);
            $post->increment('likes');
        }

        return response()->json(['likes' => $post->fresh()->likes]);
    }

    public function destroyPost(CommunityPost $post)
    {
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized delection'], 403);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function destroyComment(CommunityComment $comment)
    {
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized delection'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
