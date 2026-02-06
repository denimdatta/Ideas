<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        echo 'Registering user...';

        return redirect('/')->with('success', '(NOT CREATED YET)!');
    }
}
