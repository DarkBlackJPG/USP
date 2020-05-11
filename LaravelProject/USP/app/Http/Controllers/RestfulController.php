<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestfulController extends Controller
{
    public function userExists(Request $request) {
        $email = $request->email;
        $password = $request->password;

        $result = Auth::attempt(['email' => $email, 'password' => $password]);

        return response()->json(['user_exists' => $result]);
    }
}
