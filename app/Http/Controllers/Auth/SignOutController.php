<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignOutController extends Controller
{

    /**
     * Sign out current user, the token should also be deleted on the client side.
     *
     *
     * @return void
     */
    public function index()
    {
        return auth()->logout();
    }
}
