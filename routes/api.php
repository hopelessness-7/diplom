<?php

// Admin
use App\Http\Controllers\AdminAirportsController;
use App\Http\Controllers\AdminBookingsController;
use App\Http\Controllers\AdminClosingBookingsController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\AdminFlightsController;
use App\Http\Controllers\AdminPassengersController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminСommentController;

// User
use App\Http\Controllers\AirportsController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ClosingBookingsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\FlightsController;
use App\Http\Controllers\UsersController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Админ
Route::resource('admin/users', AdminUserController::class);
Route::resource('admin/airports', AdminAirportsController::class);
Route::resource('admin/flights', AdminFlightsController::class);
Route::resource('admin/comments', AdminСommentController::class);
Route::resource('admin/closing_bookings', AdminClosingBookingsController::class);
Route::resource('admin/feedbacks', AdminFeedbackController::class);
Route::resource('admin/bookings', AdminBookingsController::class);
Route::resource('admin/passengers', AdminPassengersController::class);



// Клиент
Route::get('/flight', [FlightsController::class, 'index']);
Route::post('/booking', [BookingsController::class, 'store']);
Route::get('/booking/{code}', [BookingsController::class, 'showBooking'])->where('code', '[0-9A-Z]{5}'); // validate param
Route::get('/booking/{code}/seat', [BookingsController::class, 'showSeat'])->where('code', '[0-9A-Z]{5}'); // validate param
Route::patch('/booking/{code}/seat', [BookingsController::class, 'chooseSeat'])->where('code', '[0-9A-Z]{5}'); // validate param
Route::get('/airport', [AirportsController::class, 'searchAirport']);
Route::get('/allAirport', [AirportsController::class, 'allAirport']);
Route::post('/feedback', [FeedBackController::class, 'store']);
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/closingBooking', [ClosingBookingsController::class, 'store']);


Route::group([
    'middleware' => 'api',
], function () {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);

    Route::get('/user', [UsersController::class, 'userProfile']);
    Route::get('/user/booking', [UsersController::class, 'getMyBookings']);
});
