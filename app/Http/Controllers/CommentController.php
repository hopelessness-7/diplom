<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Получения всех коментариев для клиента (пользователя)
    public function index()
    {
        $comments = Comment::all();

        return response()->json([
            'data'=> [
                'comments' => $comments,
            ]
        ], 200);
    }

}
