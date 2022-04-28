<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'nameUser',
        'connection',
        'message',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
