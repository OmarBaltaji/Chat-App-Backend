<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserDetails() {
        $user = Auth::user();
        return response()->json($user, 200);
        event(new MessageSent());
    }
}
