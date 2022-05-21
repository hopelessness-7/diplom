<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $url = 'http://127.0.0.1:8000/api/admin/airports';

        $json = file_get_contents($url);

        $airports = json_decode($json);

        return view('airports.index',compact('airports'))
                ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('airports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $url = 'http://127.0.0.1:8000/api/admin/airports';

        $request->validate([
            'city' => 'required',
            'name' => 'required',
            'iata' => 'required|string',
        ]);

        $airport = [
            'city',
            'name',
            'iata'
        ];

        $airport['city'] = $request->input('city');
        $airport['name'] = $request->input('name');
        $airport['iata'] = $request->input('iata');

        $options = array(
            'http' => array(
              'method'  => 'POST',
              'content' => json_encode( $airport ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('airports.index')
            ->with('success','Аэропорт добавлен в базу');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/airports';

        $json = file_get_contents($url);

        $airports = json_decode($json);

        $airportShow = [
            'city',
            'name',
            'iata'
        ];
        foreach ($airports->data as $airport) {
            if ($airport->id == $id) {
                $airportShow['city'] = $airport->city;
                $airportShow['name'] = $airport->name;
                $airportShow['iata'] = $airport->iata;
            }
        }

        return view('airports.show',compact('airportShow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $url = 'http://127.0.0.1:8000/api/admin/airports';

        $json = file_get_contents($url);

        $airports = json_decode($json);

        $airportShow = [
            'id',
            'city',
            'name',
            'iata'
        ];

        foreach ($airports->data as $airport) {
            if ($airport->id == $id) {
                $airportShow['id'] = $airport->id;
                $airportShow['city'] = $airport->city;
                $airportShow['name'] = $airport->name;
                $airportShow['iata'] = $airport->iata;
            }
        }

        return view('airports.edit',compact('airportShow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'city' => 'required',
            'name' => 'required',
            'iata' => 'required',
        ]);

        $airport = [
            'city',
            'name',
            'iata'
        ];

        $url = 'http://127.0.0.1:8000/api/admin/airports/'.$id;

        $airport['city'] = $request->input('city');
        $airport['name'] = $request->input('name');
        $airport['iata'] = $request->input('iata');

        $options = array(
            'http' => array(
              'method'  => 'PUT',
              'content' => json_encode( $airport ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('airports.index')
            ->with('success','Аэропорт обновлен в базе');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/airports/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return redirect()->route('airports.index')
                ->with('success','Аэропорт удален из базы');
    }
}
