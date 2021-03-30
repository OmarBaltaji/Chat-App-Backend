<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function login(Request $request) {
        $attributes = $request->validate([
            'email' => 'string|required|email',
            'password' => 'string|required',
            'remember_me' => 'boolean',
        ]);

        $cerdentials = [
            'email' => $attributes['email'],
            'password' => $attributes['password'],
        ];

        // If user is not logged in
        if(!Auth::attempt($cerdentials)){
            return response()->json(['message' => 'Invalid email/password combination'], 401);
        }

        // Get authenticated user
        $user = Auth::user();

        // Generate token
        $resultToken = $user->createToken('Personal Access Token');
        $token = $resultToken->token;

        // Add expiration date to the token
        if($attributes['remember_me']) { // If remember me is clicked add a week
            $token->expires_at = Carbon::now()->addWeeks(1);
            $user->remember_token = $resultToken->accessToken;
            $user->save();
        } else { // If it isn't then add one day
            $token->expires_at = Carbon::now()->addDay();
        }

        // Save the token to the user
        $token->save();

        // Return JSON object containing the token datas and user details
        return response()->json([
            'id' => $user->id,
            'access_token' => $resultToken->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($resultToken->token->expires_at)->toDateTimeString(),
        ]);
    }

    public function logout() {
        $user = Auth::user();
        $user->token()->revoke(); // Destroy previously stored token
        return response()->json(['message' => 'logged out'], 200);
    }
}
