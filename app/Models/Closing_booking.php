<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closing_booking extends Model
{
    use HasFactory;

    protected $table = 'closing_bookings';

    protected $fillable = [
        'username',
        'BookingCode',
        'description',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}

