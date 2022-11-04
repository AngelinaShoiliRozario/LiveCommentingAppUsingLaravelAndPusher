<?php

namespace App\Http\Controllers;

use App\Post;
use App\Events\NewComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Post $post){
        return response()->json($post->comments()->with('user')->latest()->get());
    }
    public function store(Request $request,Post $post){
        $comment = $post->comments()->create([
            'body'=>$request->body,
            'post_id'=>$post->id,
            'user_id'=>Auth::id(),
        ]);
        //dd($comment);
        $comment = \App\Comment::where('id',$comment->id)->with('user')->first();
        event(new NewComment($comment));
        return $comment->toJson();
    }
}
