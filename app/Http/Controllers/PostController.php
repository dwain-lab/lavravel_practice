<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class PostController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:view models|edit models|delete models|create models', ['only' => ['index','show']]);
        $this->middleware('permission:create models', ['only' => ['create','store']]);
        $this->middleware('permission:edit models', ['only' => ['edit','update']]);
        $this->middleware('permission:delete models', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('search');
        $posts = Post::latest('updated_at')->paginate(10);
        return view('post.post-table', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         =>      'required',
            'description'   =>      'required',
        ]);

       $post = Post::create($request->all());

       return redirect()->route('post.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $post->update($request->all());

        return redirect()->route('post.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('post.index')
            ->with('success', 'Post deleted successfully');
    }

    public function search(Request $request) {

        $request->validate([

            'search' => 'required'

        ]);

        $search = $request->input('search');

        $count = Post::where('title','like', '%'.$search.'%')
            ->orWhere('description','like', '%'.$search.'%')
            ->count();

        $posts = Post::where('title','like', '%'.$search.'%')
            ->orWhere('description','like', '%'.$search.'%')
            ->orderBy('id')
            ->paginate(10);
            $posts->appends(['search' => $search]);

       return view('post.post-table', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 10)
            ->with('search', session(['search' => $count]));
    }
}
