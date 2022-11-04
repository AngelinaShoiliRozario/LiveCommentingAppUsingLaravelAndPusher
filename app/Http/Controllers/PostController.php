<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPostbyId(Post $post){
        $post = Post::where('id',$post->id)->with('comments','user')->latest()->first();

       // dd($post);
        return view('Post.PostItem')->with('post',$post);
    }
}
