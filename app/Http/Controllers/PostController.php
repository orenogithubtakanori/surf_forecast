<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Location;

class PostController extends Controller
{
    //public function show(Location $location,Post $post)
    //{
    //    return view('posts.show')->with([
    //        'location' => $location,
    //        'post' => $post->get()
    //    ]);
    //}

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function create(Location $location)
    {
        return view('posts.create')->with([
            'location' => $location ->get()
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'location_id' => 'required',
            'surf_time' => 'required',
            'comment' => 'required'
        ]);

        $input = $request->all();

        $post = new Post([
            'location_id' => $input['location_id'],
            'surf_time' => $input['surf_time'],
            'comment' => $input['comment'],
            'user_id' => Auth::id(), // ログインユーザーのIDを取得
        ]);

        //$post->location_id = $input[location_id];
        //$post->surf_time = $input[surf_time];
        //$post->comment = $input[comment];
        //$post->user_id = Auth::id(); // ログインユーザーのIDを取得
        $post->save();

        return redirect('/posts/' . $post->id);
        //$input = $request['post'];
        //$post->fill($input)->save();
    }
}
