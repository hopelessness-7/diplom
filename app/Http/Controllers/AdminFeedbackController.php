<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;



class AdminFeedbackController extends Controller
{
    /**
     * Маршруты для администратора
     *
     * @return \Illuminate\Http\Response
     */
    // Показать все заявки на обратную связь
    public function index()
    {
        $feedbacks = Feedback::all();

        return response()->json(['data'=> $feedbacks,], 200);
    }

    /**
     * Обновление существуюшей зявки
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {

        $validator = Validator::make($request->all(), [
            'nameUser' => 'required',
            'connection' => 'required',
            'message' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };


        $feedback->update($request->all());

        return response()->json([
            'message' => 'Successfull',
            'feedback' => $feedback
        ], 200);


    }

    /**
     * Удаление заявки
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();

        return response(null, Response::HTTP_OK);

    }
}
