<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends Controller
{
    // Создания заявки на обратную связь - для клилента (пользователя)
    public function store(Request $request, FeedBack $feedBack)
    {
        $validator = Validator::make($request->all(), [
            'nameUser' => 'required|string',
            'connection' => 'required|string',
            'message' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };

        $feedBack = FeedBack::create($request->all());

        return response()->json([
            'message' => 'Successfull',
            'feedBack' => $feedBack
        ], 200);
    }
}
