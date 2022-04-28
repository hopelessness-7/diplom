<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_code',
        'time_from',
        'from_id',
        'to_id',
        'time_to',
        'cost',
    ];

    protected $with = ['from_airport', 'to_airport'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relations
     */
    public function from_flights_bookings()
    {
        return $this->hasMany(Booking::class, 'flight_from');
    }

    public function back_flights_bookings()
    {
        return $this->hasMany(Booking::class, 'flight_back');
    }

    public function from_airport()
    {
        return $this->belongsTo(Airport::class, 'from_id');
    }

    public function to_airport()
    {
        return $this->belongsTo(Airport::class, 'to_id');
    }


    /**
     * Accessors
     */
    public function getTimeFromAttribute($value) {
        return date('H:i', strtotime($value));
    }
    public function getTimeToAttribute($value) {
        return date('H:i', strtotime($value));
    }
}
