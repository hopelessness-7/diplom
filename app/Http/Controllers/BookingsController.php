<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = 'http://127.0.0.1:8000/api/admin/bookings';

        $json = file_get_contents($url);

        $bookings = json_decode($json);

        return view('bookings.index',compact('bookings'))
                ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $url = 'http://127.0.0.1:8000/api/admin/bookings';

        $json = file_get_contents($url);

        $bookings = json_decode($json);

        $flight_from_to_booking = [
            'flight_code_from',
            'cost_from'
        ];

        $flight_back_to_booking = [
            'flight_code_back',
            'cost_back'
        ];

        $ps = [
            'first_name',
            'last_name',
            'birth_date',
            'place_from',
            'place_back',
            'document_number'
        ];

        $showBK = [
            'date_from',
            'date_back',
            'code'
        ];

        foreach ($bookings->data as $bk) {
            if ($bk->id == $id) {
                $showBK['date_from'] = $bk->date_from;
                $showBK['date_back'] = $bk->date_back;
                $showBK['code'] = $bk->code;
                $flight_from_to_booking['flight_code_from'] = $bk->flight_from_to_booking->flight_code;
                $flight_from_to_booking['cost_from'] = $bk->flight_from_to_booking->cost;

                if(isset($bk->flight_back)) {
                    $flight_back_to_booking['flight_code_back'] = $bk->flight_back_to_booking->flight_code;
                    $flight_back_to_booking['cost_back'] = $bk->flight_back_to_booking->cost;
                }
                foreach ($bk->passengers as $passenger) {
                    $ps['first_name'] = $passenger->first_name;
                    $ps['last_name'] = $passenger->last_name;
                    $ps['birth_date'] = $passenger->birth_date;
                    $ps['place_from'] = $passenger->place_from;
                    $ps['place_back'] = $passenger->place_back;
                    $ps['document_number'] = $passenger->document_number;
                }
            }
        }

        $booking = array_merge($showBK, $flight_from_to_booking, $flight_back_to_booking, $ps);
        return view('bookings.show',compact('booking'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/bookings/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return redirect()->route('bookings.index')
                ->with('success','Бронирование удалено из базы');
    }
}
