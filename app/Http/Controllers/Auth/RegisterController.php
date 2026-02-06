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

        $attributes = request()->validate([
            'username' => ['required', 'string', 'min:5', 'max:100', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'confirmed', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
        ]);

        return redirect('/')->with('success', 'Your account has been validated (NOT CREATED YET)!');
    }
}
