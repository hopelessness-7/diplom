<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightsController extends Controller
{
    public function index(Request $request)
    {
        $inputData = $request->all();
        $rules = [
            /**
             * проверяет существует ли iata в таблице
             */
            'from' => 'required|exists:airports,iata',
            'to' => 'required|exists:airports,iata',
            'date1' => 'required|date_format:Y-m-d', // дата отправления, например:2020-10-01
            'date2' => 'date_format:Y-m-d', // дата обратно
            'passengers' => 'required|integer|min:1|max:8'
        ];

        $validator = Validator::make($inputData, $rules);
        if($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        $fromAirport = Airport::where('iata', $inputData['from'])->first();
        $toAirport = Airport::where('iata', $inputData['to'])->first();

        /**
         * FROM ->->->-> TO flights
         */
        $flights_to = [];

        /**
         * TO ->->->-> FROM flights
         */
        $flights_back = [];

        $query = Flight::where([
            ['from_id', '=', $fromAirport->id],
            ['to_id', '=', $toAirport->id]
        ]);

        /**
         * существует ли параметр date2
         * если существует, то другой запрос
         */
        if(isset($inputData['date2'])) {
            $query = Flight::where([
                    ['from_id', '=', $fromAirport->id],
                    ['to_id', '=', $toAirport->id]
                ])
                ->orWhere(function($flightQuery) use ($fromAirport, $toAirport) {
                    $flightQuery->where([
                        ['from_id', '=', $toAirport->id],
                        ['to_id', '=', $fromAirport->id]
                    ]);
                });
        }

        /**
         * Приведенная выше строка запроса была построена
         * Отправить запрос в базу данных только один раз
         */
        $flights = $query->get()->toArray();

        foreach ($flights as $flight) {

            /**
             * FROM ->->->-> TO flights
             * flights_to Array
             */
            if($flight['from_id'] == $fromAirport->id && $flight['to_id'] == $toAirport->id) {

                $flight['from_airport']['date'] = $inputData['date1'];
                $flight['to_airport']['date'] = $inputData['date1'];
                $flight['from_airport']['time'] = $flight['time_from'];
                $flight['to_airport']['time'] = $flight['time_to'];

                array_push($flights_to, $flight);
            }

            /**
             * TO ->->->-> FROM flights
             * flights_back Array
             */
            if(isset($inputData['date2'])) {
                if($flight['from_id'] == $toAirport->id && $flight['to_id'] == $fromAirport->id) {

                    $flight['from_airport']['date'] = $inputData['date2'];
                    $flight['to_airport']['date'] = $inputData['date2'];
                    $flight['from_airport']['time'] = $flight['time_from'];
                    $flight['to_airport']['time'] = $flight['time_to'];

                    array_push($flights_back, $flight);
                }
            }
        }

        return response()->json([
            'data' => [
                'flights_to' => $flights_to,
                'flights_back' => $flights_back
            ]
        ]);
    }
}
