<?php

namespace App\Http\Controllers;

use App\Models\Closing_booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClosingBookingsController extends Controller
{
    public function store(Request $request, Closing_booking $Closing_booking)
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

        $closing_booking = Closing_booking::create($request->all());

        return response()->json([
            'message' => 'Successfull',
            'closing_booking' => $closing_booking
        ], 200);
    }
}
