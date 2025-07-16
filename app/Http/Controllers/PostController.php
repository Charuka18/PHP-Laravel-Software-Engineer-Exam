<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create()
{
    $users = User::all();
    return view('posts.create', compact('users'));
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'user_id' => 'required|exists:users,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imageName = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Save in public/post_images (NOT in storage)
        $image->move(public_path('post_images'), $imageName);
    }

    Post::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => $request->user_id,
        'image' => $imageName, // Just the filename
    ]);

    return redirect()->route('posts.create')->with('success', 'Post created successfully!');
}
public function post_list()
{
    $posts = Post::with('user')->latest()->get(); // eager load user
    return view('posts.post_list', compact('posts'));
}
public function edit($id)
{
    $post = Post::findOrFail($id);
    $users = User::all();
    return view('posts.edit', compact('post', 'users'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'user_id' => 'required|exists:users,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $post = Post::findOrFail($id);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($post->image && file_exists(public_path('post_images/' . $post->image))) {
            unlink(public_path('post_images/' . $post->image));
        }
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('post_images'), $imageName);
        $post->image = $imageName;
    }

    $post->title = $request->title;
    $post->content = $request->content;
    $post->user_id = $request->user_id;
    $post->save();

    return redirect()->route('posts.post_list')->with('success', 'Post updated successfully!');
}

public function destroy($id)
{
    $post = Post::findOrFail($id);

    // Delete image file
    if ($post->image && file_exists(public_path('post_images/' . $post->image))) {
        unlink(public_path('post_images/' . $post->image));
    }

    $post->delete();

    return redirect()->route('posts.post_list')->with('success', 'Post deleted successfully!');
}
}
