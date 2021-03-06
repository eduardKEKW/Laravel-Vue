<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __constructor ()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * Get the current loggedin user info.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
