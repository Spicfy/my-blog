<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author')->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:news,update,task',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       $post = new Post();
       $post->title = $request->input('title');
       $post->message = $request->input('message');
       $post->type = $request->input('type');
       $post->author_id = Auth::id(); // Get the currently logged in user's ID.
       $post->save();
       return response()->json(['message' => 'Post created successfully.'], 201);

    }

    public function show($id)
    {
        $post = Post::with('author')->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validator = Validator::make($request->all(), [
           'title' => 'required|string|max:255',
           'message' => 'required|string',
           'type' => 'required|in:news,update,task',
       ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $post->title = $request->input('title');
        $post->message = $request->input('message');
        $post->type = $request->input('type');
        $post->save();
        return response()->json(['message' => 'Post updated successfully.'], 200);

    }

    public function destroy($id)
    {
       $post = Post::findOrFail($id);
       $post->delete();
       return response()->json(['message' => 'Post deleted successfully.'], 200);
    }
}