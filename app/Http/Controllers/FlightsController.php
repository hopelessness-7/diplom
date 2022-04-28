<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;


class FlightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = 'http://127.0.0.1:8000/api/admin/flights';

        $json = file_get_contents($url);

        $flights = json_decode($json);

        return view('flights.index',compact('flights'))
                ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $url = 'http://127.0.0.1:8000/api/admin/airports';

        $json = file_get_contents($url);

        $airports = json_decode($json);

        return view('flights.create',compact('airports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = 'http://127.0.0.1:8000/api/admin/flights';

        $request->validate([
            'flight_code' => 'required',
            'from_id' => 'required',
            'to_id' => 'required',
            'time_from'=>'required',
            'time_to' => 'required',
            'cost'=>'required|integer',
        ]);

        $flight = [
            'flight_code',
            'from_id',
            'to_id',
            'time_from',
            'time_to',
            'cost'
        ];

        $flight['flight_code'] = $request->input('flight_code');
        $flight['from_id'] = $request->input('from_id');
        $flight['to_id'] = $request->input('to_id');
        $flight['time_from'] = $request->input('time_from');
        $flight['time_to'] = $request->input('time_to');
        $flight['cost'] = $request->input('cost');

        $options = array(
            'http' => array(
              'method'  => 'POST',
              'content' => json_encode($flight),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('flights.index')
            ->with('success','Рейс добавлен в базу');
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/flights';

        $json = file_get_contents($url);

        $flights = json_decode($json);

        $showFlight = [
            'flight_code',
            'from_airport',
            'to_airport',
            'time_from',
            'time_to',
            'cost',
        ];

        foreach ($flights->data as $flight) {
            if ($flight->id == $id) {
                $showFlight['flight_code'] = $flight->flight_code;
                $showFlight['from_airport'] = $flight->from_airport->city;
                $showFlight['to_airport'] = $flight->to_airport->city;
                $showFlight['time_from'] = $flight->time_from;
                $showFlight['time_to'] = $flight->time_to;
                $showFlight['cost'] = $flight->cost;
            }
        }
        return view('flights.show',compact('showFlight'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/flights';

        $json = file_get_contents($url);

        $flights = json_decode($json);

        $showFlight = [
            'id',
            'flight_code',
            'from_airport',
            'to_airport',
            'from_id',
            'to_id',
            'time_from',
            'time_to',
            'cost',
        ];

        foreach ($flights->data as $flight) {
            if ($flight->id == $id) {
                $showFlight['id'] = $id;
                $showFlight['flight_code'] = $flight->flight_code;
                $showFlight['from_airport'] = $flight->from_airport->city;
                $showFlight['to_airport'] = $flight->to_airport->city;
                $showFlight['from_id'] = $flight->from_airport->id;
                $showFlight['to_id'] = $flight->to_airport->id;
                $showFlight['time_from'] = $flight->time_from;
                $showFlight['time_to'] = $flight->time_to;
                $showFlight['cost'] = $flight->cost;
            }
        }

        $url = 'http://127.0.0.1:8000/api/admin/airports';

        $json = file_get_contents($url);

        $airports = json_decode($json);

        return view('flights.edit',compact('showFlight'),compact('airports'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'flight_code' => 'required',
            // 'from_id '=>'required',
            'to_id' => 'required',
            'time_from'=>'required',
            'time_to' => 'required',
            'cost'=>'required|integer',
        ]);

        $flight = [
            'flight_code',
            'from_airport',
            'to_airport',
            'time_from',
            'time_to',
            'cost',
        ];

        $url = 'http://127.0.0.1:8000/api/admin/flights/'.$id;

        $flight['flight_code'] = $request->input('flight_code');
        $flight['from_id'] = $request->input('from_id');
        $flight['to_id'] = $request->input('to_id');
        $flight['time_from'] = $request->input('time_from');
        $flight['time_to'] = $request->input('time_to');
        $flight['cost'] = $request->input('cost');

        $options = array(
            'http' => array(
              'method'  => 'PUT',
              'content' => json_encode( $flight ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('flights.index')
            ->with('success','Рейс обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/flights/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return redirect()->route('flights.index')
                ->with('success','Рейс удален из базы');
    }
}
