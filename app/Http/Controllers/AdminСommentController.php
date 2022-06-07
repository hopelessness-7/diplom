<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class AdminСommentController extends Controller
{
    /**
     * Маршруты для администратора
     *
     * @return \Illuminate\Http\Response
     */
    // Получение всех комментариев
    public function index()
    {
        $comments = Comment::all();
        return response()->json(['data'=> $comments,], 200);

    }


    /**
     * Создание комментария
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'nameUser' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };

        $comment = Comment::create($request->all());

        return response()->json([
            'message' => 'Successfull',
            'comment' => $comment
        ], 200);

    }

    /**
     * Обновление существующего комментария
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {

        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'nameUser' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };


        $comment->update($request->all());

        return response()->json([
            'message' => 'Successfull',
            'comment' => $comment
        ], 200);

    }

    /**
     *
     * удаление комментария
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $comment = Comment::find($id);
        $comment->delete();

        return response(null, Response::HTTP_OK);
    }
}
