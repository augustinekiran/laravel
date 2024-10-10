<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login_form');
    }

    public function attemptLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4|max:40',
            'password' => 'required|min:6|max:40',
        ]);

        $credentials = [
            'username' => trim($request->username),
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index');
        }

        return redirect()->route('login')->with('message', 'Invalid Credentials. Please try again.');
    }
}
