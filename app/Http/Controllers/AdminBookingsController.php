<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::all();

        $flight_from_to_booking = [
            'flight_code',
            'cost'
        ];

        $flight_back_to_booking = [
            'flight_code',
            'cost'
        ];

        $passenger = [
            'first_name',
            'last_name',
            'birth_date',
            'place_from',
            'place_back',
            'document_number'
        ];



        foreach ($bookings as $key => $booking) {
            $flight_from_to_booking['flight_code'] = $booking->flight_from_to_booking->flight_code;
            $flight_from_to_booking['cost'] = $booking->flight_from_to_booking->cost;

            if(isset($booking->flight_back)) {
                $flight_back_to_booking['flight_code'] = $booking->flight_back_to_booking->flight_code;
                $flight_back_to_booking['cost'] = $booking->flight_back_to_booking->cost;
            }
            foreach ($booking->passengers as $key => $passenger) {
                $passenger['first_name'] = $passenger->first_name;
                $passenger['last_name'] = $passenger->last_name;
                $passenger['birth_date'] = $passenger->birth_date;
                $passenger['place_from'] = $passenger->place_from;
                $passenger['place_back'] = $passenger->place_back;
                $passenger['document_number'] = $passenger->document_number;
            }
        }

        return response()->json(['data'=> $bookings,], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        $booking->delete();

        return response(null, Response::HTTP_OK);
    }
}
