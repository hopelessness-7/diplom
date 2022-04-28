<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'city',
    //     'name',
    //     'iata',
    // ];

    protected $hidden = ['created_at', 'updated_at'];
}
