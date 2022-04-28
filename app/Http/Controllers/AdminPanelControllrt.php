<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPanelControllrt extends Controller
{
    public function index()
    {

        if (Auth::check() == true) {

            return view('dashboard');
        } else {
            return view('auth.login');
        }

    }
}
