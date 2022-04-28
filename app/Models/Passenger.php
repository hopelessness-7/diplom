<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'document_number',

    ];

    protected $hidden = ['booking_id', 'created_at', 'updated_at'];

    /**
     * Relations
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
