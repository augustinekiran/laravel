<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login_form');
    }

    public function store(Request $request)
    {
        return redirect('login')->with('message', 'Invalid Credentials. Please try again.');
    }
}
