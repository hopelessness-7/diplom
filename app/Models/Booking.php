<?php

namespace App\Models;

use App\Http\Controllers\Admin\FlightsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from',
        'date_back ',
        'code ',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relations
     */
    public function flight_from()
    {
        return $this->belongsTo(Flight::class, 'flight_from');
    }

    public function flight_back()
    {
        return $this->belongsTo(Flight::class, 'flight_back');
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }




    public function flight_from_to_booking()
    {
        return $this->belongsTo(Flight::class, 'flight_from');
    }

    public function flight_back_to_booking()
    {
        return $this->belongsTo(Flight::class, 'flight_back');
    }



}
