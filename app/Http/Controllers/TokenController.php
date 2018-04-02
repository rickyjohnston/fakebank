<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the page to register API tokens via GUI
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('token');
    }
}
