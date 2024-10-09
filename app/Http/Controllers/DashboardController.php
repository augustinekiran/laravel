<?php

namespace App\Http\Controllers;

use App\Models\Form;

class DashboardController extends Controller
{
    public function index()
    {
        $forms = Form::with('elements.options')->get();
        return view('dashboard')->with('forms', $forms);
    }
}
