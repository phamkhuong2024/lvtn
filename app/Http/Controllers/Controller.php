<?php

namespace App\Http\Controllers;

use App\Models\User;

class Controller
{
    function index()
    {
        $user = User::find(1);
        return view('login', compact('user'));
    }
}
