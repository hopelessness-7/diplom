<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\passenger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminPassengersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passengers = Passenger::all();
        // $passengers = DB::select('select * from passengers');
        return response()->json(['data'=> $passengers,], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $passenger = Passenger::find($id);
        $passenger->delete();

        return response(null, Response::HTTP_OK);
    }
}
