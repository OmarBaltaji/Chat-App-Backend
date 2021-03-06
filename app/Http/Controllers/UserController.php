<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function getMatchesList() {
        return User::all()->except(Auth::user()->id); // Return all users except the authenticated user
    }
    
    public function getUserDetails() {
        $user = Auth::user();
        return response()->json($user, 200);
    }
}
