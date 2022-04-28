<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();

        // foreach ($comments as $key => $comment) {
        //     $arrCommentName [] = $comment->nameUser;
        //     $arrComment [] = $comment->comment;
        // };

        return response()->json([
            'data'=> [
                'comments' => $comments,
            ]
        ], 200);
    }

}
