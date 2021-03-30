<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request) {
        
        $attributes = $request->validate([
            'name' => 'string|required',
            'email' => 'string|email|required',
            'password' => 'string|min:6|confirmed|required',
        ]);

        $default_photo_url = "assets/images/userImage/none.jpg";
    

        User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password']),
            'profile_photo' => $default_photo_url,
        ]);

        return response()->json(['message' => 'Account created successfully'], 200);
    }
}
