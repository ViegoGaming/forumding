<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $posts = Post::with('user')->get();
    return view('forum.index')->with('posts', $posts);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('forum.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'subject' => 'required|max:255',
        'content' => 'required',
    ]);

    $post = new Post();
    $post->subject = $validatedData['subject'];
    $post->content = $validatedData['content'];
    $post->user_id = auth()->user()->id; // Assuming you have authentication set up
    $post->save();

    return redirect()->route('forum.index')->with('success', 'Post created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $post = Post::findOrFail($id);

    // Check if the user is authorized to edit the post
    if ($post->user_id != auth()->user()->id) {
        return redirect()->route('forum.index')->with('error', 'You are not authorized to edit this post');
    }

    return view('forum.update', compact('post'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $post = Post::findOrFail($id);

    // Check if the user is authorized to update the post
    if ($post->user_id != auth()->user()->id) {
        return redirect()->route('forum.index')->with('error', 'You are not authorized to update this post');
    }

    $request->validate([
        'subject' => 'required', 'string', 'max:255',
        'content' => 'required', 'string'
    ]);

    $post->subject = $request->input('subject');

        $post->content = $request->input('content');

    $post->save();

    return redirect()->route('forum.index')->with('success', 'Post updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $posts = Post::findOrFail($id);
        $posts->delete();
        $posts = Post::all();
        return view('forum.index')->with('posts',$posts);
    }

    public function storeComment(Request $request, $postId)
{
    // Validate the request
    $request->validate([
        'content' => 'required',
    ]);

    // Create the comment
    $comment = new Comment([
        'content' => $request->input('content'),
        'user_id' => auth()->user()->id,
        'post_id' => $postId,
    ]);
    $comment->save();

    return redirect()->route('forum.index')->with('success', 'Comment added successfully');
}
}


