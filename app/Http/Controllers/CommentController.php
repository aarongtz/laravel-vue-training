<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Video $video){

        return $video->comments()->with('user')->paginate(5);
          
    }

    public function getUserName(Comment $comment){
        return $comment->user();
    }

    public function store(Request $request, Video $video){
        $comment = auth()->user()->comments()->create([
            'body'  =>  $request->body,
            'video_id'  =>  $video->id,
            'comment_id'    =>  $request->comment_id
        ])->load('user');


        return $comment;
    }

    public function show(Comment $comment)
    {
        return $comment->replies()->with('user')->paginate(10);
    }
}
