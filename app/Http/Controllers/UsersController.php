<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Create a new UsersController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, User $user){
    	$validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                    'errors' => 'Invalid credentials'
                ]
            ], 401);
        }

        return response()->json(['data' => ['token' => $this->createNewToken($token)]], 200,);
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'document_number' => 'required|string|max:10|min:10|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 200);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function getMyBookings()
    {
        $documentNumber = auth()->user()->document_number;

        $bookings = Passenger::with([
            'booking.flight_from',
            'booking.flight_back',
            'booking.passengers'
        ])
            ->where('document_number', $documentNumber)->get()
            ->map(function($r) {
                // $r->booking->flight_from->from_airport->date = $r->booking->date_from;
                return $r->booking;
            })->toArray();


        foreach ($bookings as $key => $b) {
            $bookings[$key]['flight_from']['from_airport']['date'] = $b['date_from'];
            $bookings[$key]['flight_from']['from_airport']['time'] = $b['flight_from']['time_from'];
            $bookings[$key]['flight_from']['to_airport']['date'] = $b['date_from'];
            $bookings[$key]['flight_from']['to_airport']['time'] = $b['flight_from']['time_to'];

            if(isset($bookings[$key]['flight_back'])) {
                $bookings[$key]['flight_back']['from_airport']['date'] = $b['date_back'];
                $bookings[$key]['flight_back']['from_airport']['time'] = $b['flight_back']['time_from'];
                $bookings[$key]['flight_back']['to_airport']['date'] = $b['date_back'];
                $bookings[$key]['flight_back']['to_airport']['time'] = $b['flight_back']['time_to'];
            }

        }

        return response()->json([
            'data' => [
                'items' => $bookings
            ]
        ], 200);
    }
}
