<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportsController extends Controller
{
    public function searchAirport(Request $request)
    {
        $inputData = $request->all();
        $rules = ['query' => 'required'];

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

        $q = trim($inputData['query']);

        $items = Airport::where('city', 'like', "%${q}%")
        ->orWhere('name', 'like', "%${q}%")
        ->orWhere('iata', 'like', "%${q}%")
        ->get();

        return response()->json([
            'data' => [
                'items' => $items
            ]
        ], 200);
    }

    public function allAirport(Request $request)
    {
        $airports = Airport::all();
        foreach ($airports as $key => $airport) {
            $city [] = $airport->city;
            $iata [] = $airport->iata;
        };

        return response()->json([
            'data'=> [
                'city' => $city,
                'iata' => $iata,
            ]
        ], 200);

    }


}
