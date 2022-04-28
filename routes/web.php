<?php

use App\Http\Controllers\AdminPanelControllrt;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AirportsController;
use App\Http\Controllers\FlightsController;
use App\Http\Controllers\PassnegersController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ClosingBookingsController;

use App\Http\Controllers\DeleteController;

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\СommentController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Airports;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('',[AdminPanelControllrt::class,'index'])->name('home');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('adminPanel');
    })->name('dashboard');

    Route::resource('passengers', PassnegersController::class); // Выводим в браузер шаблоны пассажиров
    Route::resource('airports', AirportsController::class); // Выводим в браузер шаблоны аэропорты
    Route::resource('flights', FlightsController::class); // Выводим в браузер шаблоны рейсы
    Route::resource('bookings', BookingsController::class); // Выводим в браузер шаблоны бронирования
    Route::resource('users', UserController::class); // Выводим в браузер шаблоны пользователей
    Route::resource('comments', СommentController::class); // Выводим в браузер шаблоны Отзывы
    Route::resource('feedbacks', FeedbackController::class); // Выводим в браузер шаблоны запросы пользователей
    Route::resource('closing_bookings', ClosingBookingsController::class); // Выводим в браузер шаблоны отмены бронирования

    Route::get('/adminPanel', function () {
        return view('adminPanel');
    })->name('adminPanel');                     // Главная страница

});
