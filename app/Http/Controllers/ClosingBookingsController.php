<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClosingBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $url = 'http://127.0.0.1:8000/api/admin/closing_bookings';

        $json = file_get_contents($url);

        $closing_bookings = json_decode($json);

        return view('closing_bookings.index',compact('closing_bookings'))
            ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $url = 'http://127.0.0.1:8000/api/admin/closing_bookings';

        $json = file_get_contents($url);

        $closing_bookings = json_decode($json);

        $clShow = [
            'username',
            'BookingCode',
            'description',
            'status'
        ];
        foreach ($closing_bookings->data as $closing_booking) {
            if ($closing_booking->id == $id) {
                $clShow['username'] = $closing_booking->username;
                $clShow['BookingCode'] = $closing_booking->BookingCode;
                $clShow['description'] = $closing_booking->description;
                $clShow['status'] = $closing_booking->status;
            }
        }

        return view('closing_bookings.show',compact('clShow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/closing_bookings';

        $json = file_get_contents($url);

        $closing_bookings = json_decode($json);

        $clShow = [
            'id',
            'username',
            'BookingCode',
            'description',
            'status'
        ];
        foreach ($closing_bookings->data as $closing_booking) {
            if ($closing_booking->id == $id) {
                $clShow['id'] = $id;
                $clShow['username'] = $closing_booking->username;
                $clShow['BookingCode'] = $closing_booking->BookingCode;
                $clShow['description'] = $closing_booking->description;
                $clShow['status'] = $closing_booking->status;
            }
        }

        return view('closing_bookings.edit',compact('clShow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'username' => 'required',
            'BookingCode' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $clShow = [
            'username',
            'BookingCode',
            'description',
            'status'
        ];

        $url = 'http://127.0.0.1:8000/api/admin/closing_bookings/'.$id;

        $clShow['username'] = $request->input('username');
        $clShow['BookingCode'] = $request->input('BookingCode');
        $clShow['description'] = $request->input('description');
        $clShow['status'] = $request->input('status');

        $options = array(
            'http' => array(
              'method'  => 'PUT',
              'content' => json_encode( $clShow ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('closing_bookings.index')
            ->with('success','Заявка обработана');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/closing_bookings/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return redirect()->route('closing_bookings.index')
            ->with('success','Заявка удалена');
    }
}
