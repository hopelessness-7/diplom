<?php

namespace App\Http\Controllers;

use App\Models\Closing_booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AdminClosingBookingsController extends Controller
{
    /**
     * Маршруты для администратора
     *
     * @return \Illuminate\Http\Response
     */
    // Показать все заявки на отмену бронирования
    public function index()
    {
        $closing_bookings = Closing_booking::all();

        return response()->json(['data'=> $closing_bookings,], 200);
    }

    /**
     * Обновление существубщей заявки
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Closing_booking $closing_booking)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'BookingCode' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };


        $closing_booking->update($request->all());

        return response()->json([
            'message' => 'Successfull',
            'closing_booking' => $closing_booking
        ], 200);

    }

    /**
     * Удаление заявки
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $closing_booking = Closing_booking::find($id);
        $closing_booking->delete();

        return response(null, Response::HTTP_OK);
    }
}
