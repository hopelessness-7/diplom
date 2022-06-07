<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    public function store(Request $request)
    {
        $inputData = $request->all();
        $rules = [
            'flight_from' => 'required',
            'flight_from.id' => 'required|exists:flights,id',
            'flight_from.date' => 'required|date_format:Y-m-d',

            /**
             * обратный рейс - при необходимости
             *
             * если существует поле flight_back
             */
            'flight_back.id' => 'required_with:flight_back|exists:flights,id',
            'flight_back.date' => 'required_with:flight_back|date_format:Y-m-d',

            'passengers' => 'required|array',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.last_name' => 'required|string',
            'passengers.*.birth_date' => 'required|date_format:Y-m-d',
            'passengers.*.document_number' => 'required|string|min:10|max:10'
        ];

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

        DB::beginTransaction();

        try {

            $booking = new Booking;

            $booking->flight_from = $inputData['flight_from']['id'];
            $booking->date_from = $inputData['flight_from']['date'];

            if(isset($inputData['flight_back'])) {
                $booking->flight_back = $inputData['flight_back']['id'];
                $booking->date_back = $inputData['flight_back']['date'];
            }

            /**
             * сгенерировать КОД рейса, которого нет в базе данных
             * генерировать до тех пор, пока код не станет уникальным
             */
            $code = '';
            while (true) {
                $code = strtoupper(\Str::random(5));
                if (!Booking::where('code', $code)->first()) {
                    break;
                }
            }

            $booking->code = $code;

            $booking->save();

            foreach ($inputData['passengers'] as $p) {

                $passenger = new Passenger;
                $passenger->booking_id = $booking->id;
                $passenger->first_name = $p['first_name'];
                $passenger->last_name = $p['last_name'];
                $passenger->birth_date = $p['birth_date'];
                $passenger->document_number = $p['document_number'];
                $passenger->save();

            }


        } catch (\Throwable $th) {

            /**
             * Откат транзакции, если произошла ошибка
             */
            DB::rollback();

            return response()->json([
                'error' => [
                    'code' => 500,
                    'message' => 'Internal server error',
                ]
            ], 500);
        }

        DB::commit();

        return response()->json([
            'data' => [
                'code' => $booking->code
            ]
        ], 201);

    }

    public function showBooking($code)
    {
        $booking = Booking::with(['flight_from', 'flight_back', 'passengers'])
            ->where('code', $code)
            ->first();

        if(!$booking) {
            return response()->json([
                'not found' => [
                    'code' => 404,
                    'message' => "Бронирование с кодом=$code не найдено"
                ]
            ], 404);
        } else {
            $booking = $booking->toArray();
        }

        $booking['flight_from']['from_airport']['date'] = $booking['date_from'];
        $booking['flight_from']['from_airport']['time'] = $booking['flight_from']['time_from'];
        $booking['flight_from']['to_airport']['date'] = $booking['date_from'];
        $booking['flight_from']['to_airport']['time'] = $booking['flight_from']['time_to'];

        if(isset($booking['flight_back'])) {
            $booking['flight_back']['from_airport']['date'] = $booking['date_back'];
            $booking['flight_back']['from_airport']['time'] = $booking['flight_back']['time_from'];
            $booking['flight_back']['to_airport']['date'] = $booking['date_back'];
            $booking['flight_back']['to_airport']['time'] = $booking['flight_back']['time_to'];
        }

        return response()->json(['data' => $booking], 200);
    }

    public function showSeat($code)
    {
        $booking = Booking::with(['flight_from', 'flight_back', 'passengers'])
            ->where('code', $code)
            ->first();

        if(!$booking) {
            return response()->json([
                'not found' => [
                    'code' => 404,
                    'message' => "Бронирование с кодом=$code не найдено"
                ]
            ], 404);
        }

        $data['occupied_from'] = [];
        $data['occupied_back'] = [];

        foreach ($booking->passengers as $passenger) {
            $data['occupied_from'][] = [
                'passenger_id' => $passenger->id,
                'place' => $passenger->place_from
            ];

            if (isset($booking['flight_back'])) {
                $data['occupied_back'][] = [
                    'passenger_id' => $passenger->id,
                    'place' => $passenger->place_back
                ];
            }
        }

        return response()->json(['data' => $data], 200);
    }

    public function chooseSeat($code, Request $request)
    {
        $booking = Booking::with(['flight_from', 'flight_back', 'passengers'])
            ->where('code', $code)
            ->first();

        if(!$booking) {
            return response()->json([
                'not found' => [
                    'code' => 404,
                    'message' => "Resource with code=$code not found"
                ]
            ], 404);
        }

        $inputData = $request->all();
        $rules = [
            'passenger' => 'required|integer|exists:passengers,id',
            'seat' => 'required|string|min:2|max:2',
            'type' => 'required|in:from,back'
        ];

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

        /**
         * Если в бронировании нет обратного рейса
         */
        if($inputData['type'] == 'back') {
            if (!$booking->flight_back) {
                return response()->json([
                    'error' => [
                        'code' => 422,
                        'message' => "Бронирование $code не имеет обратного рейса"
                    ]
                ], 422);
            }
        }

        /**
         * Проверка на то, что пассажир принадлежит к бронированию
         */
        $passenger = $booking->passengers->find($inputData['passenger']);
        if (!$passenger) {
            return response()->json([
                'error' => [
                    'code' => 403,
                    'message' => "Пассажир не входит в это бронирование $code"
                ]
            ], 403);
        }

        /**
         * Если место занято
         */
        $placeFromOrBack = $inputData['type'] == 'back' ? 'place_back' : 'place_from';

        if($inputData['type'] == 'from') {
            /**
             * получить все Бронирования на один рейс
             */
            $allFromFlightsBookings = Flight::find($booking->flight_from)->from_flights_bookings()->with('passengers')->get();

            foreach ($allFromFlightsBookings as $b) {
                /**
                 * собрать всех пассажиров на один рейс и проверьте их места
                 */
                foreach ($b->passengers as $p) {
                    if ($p->{$placeFromOrBack} == strtoupper($inputData['seat'])) {
                        return response()->json([
                            'error' => [
                                'code' => 422,
                                'message' => "Место занято"
                            ]
                        ], 422);
                    }
                }
            }
        }

        if($inputData['type'] == 'back') {
            /**
             * get all bookings for one flight_back
             */
            $allBackFlightsBookings = Flight::find($booking->flight_back)->back_flights_bookings()->with('passengers')->get();

            foreach ($allBackFlightsBookings as $b) {
                /**
                 * собрать всех пассажиров на один обратный рейс и проверьте их места
                 */
                foreach ($b->passengers as $p) {
                    if ($p->{$placeFromOrBack} == strtoupper($inputData['seat'])) {
                        return response()->json([
                            'error' => [
                                'code' => 422,
                                'message' => "Место занято"
                            ]
                        ], 422);
                    }
                }
            }
        }

        $passenger->{$placeFromOrBack} = strtoupper($inputData['seat']);
        $passenger->save();

        return response()->json(['data' => $passenger], 200);
    }
}
