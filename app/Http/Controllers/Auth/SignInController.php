<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignInController extends Controller
{

    /**
     * Sign in user by email/pass and return jwt.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response(null, 401);
        }

        $user = $request->user()->load('vote');

        return response()->json(compact('token', 'user'));
    }
}
