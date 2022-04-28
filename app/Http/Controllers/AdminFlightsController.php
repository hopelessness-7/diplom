<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\flight;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AdminFlightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flights = Flight::all();

        return response()->json(['data'=> $flights,], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'flight_code' => 'required',
            'from_id' => 'required',
            'to_id' => 'required',
            'time_from'=>'required',
            'time_to' => 'required',
            'cost'=>'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };

        $flight = Flight::create($request->all());

        return response()->json([
            'message' => 'Successfull',
            'flight' => $flight
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, flight $flight)
    {
        $validator = Validator::make($request->all(), [
            'flight_code' => 'required',
            'from_id' => 'required',
            'to_id' => 'required',
            'time_from'=>'required',
            'time_to' => 'required',
            'cost'=>'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };

        $flight->update($request->all());

        return response()->json([
            'message' => 'Successfull',
            'flight' => $flight
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = Flight::find($id);
        $flight->delete();

        return response(null, Response::HTTP_OK);
    }
}
