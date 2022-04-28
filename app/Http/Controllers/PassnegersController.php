<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\passenger;
use Illuminate\Http\Request;

class PassnegersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = 'http://127.0.0.1:8000/api/admin/passengers';

        $json = file_get_contents($url);

        $passengers = json_decode($json);

        return view('passengers.index',compact('passengers'))
                ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/passengers';

        $json = file_get_contents($url);

        $passengers = json_decode($json);

        $passengerShow = [
            'first_name',
            'last_name',
            'birth_date',
            'document_number',
            'booking_id',
            'place_from',
            'place_back'

        ];
        foreach ($passengers->data as $passenger) {
            if ($passenger->id == $id) {
                $passengerShow['first_name'] = $passenger->first_name;
                $passengerShow['last_name'] = $passenger->last_name;
                $passengerShow['birth_date'] = $passenger->birth_date;
                $passengerShow['document_number'] = $passenger->document_number;
                $passengerShow['booking_id'] = $passenger->booking_id;
                $passengerShow['place_from'] = $passenger->place_from;
                $passengerShow['place_back'] = $passenger->place_back;
            }
        }

        return view('passengers.show',compact('passengerShow'));
    }
}
