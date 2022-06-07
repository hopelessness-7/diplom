<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\airport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AdminAirportsController extends Controller
{
    /**
     * Маршруты для администратора
     *
     * @return \Illuminate\Http\Response
     */
    // Получение всех аэропортов
    public function index()
    {
        $airports = Airport::all();
        return response()->json(['data'=> $airports,], 200);
    }

    /**
     * Создание нового аэропорта
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'name' => 'required',
            'iata' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };

        $airport = Airport::create($request->all());

        return response()->json([
            'message' => 'Successfull',
            'airport' => $airport
        ], 200);

    }

    /**
     * Обновление существующего аэропорта
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, airport $airport)
    {

        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'name' => 'required',
            'iata' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };


        $airport->update($request->all());

        return response()->json([
            'message' => 'Successfull',
            'airport' => $airport
        ], 200);


    }

    /**
     * Удаление аэропорта
     *
     * @param  \App\Models\airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $airport = Airport::find($id);
        $airport->delete();

        return response(null, Response::HTTP_OK);

    }
}
