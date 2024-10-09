<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Element;
use App\Models\Option;

class FormBuilderController extends Controller
{
    public function createForm(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:40'
        ]);

        Form::create([
            'name' => $request->name
        ]);

        return redirect()->route('dashboard.index');
    }

    public function createElement(Request $request)
    {
        $request->validate([
            'form_id' => 'required|numeric',
            'type' => 'required|min:3|max:40',
            'label' => 'required|min:3|max:40',
            'required' => 'required|boolean',
            'value' => 'max:40',
            'sequence' => 'nullable|numeric',
        ]);

        $element = Element::create([
            'form_id' => $request->form_id,
            'type' => $request->type,
            'label' => $request->label,
            'required' => $request->required,
            'value' => $request->value ?? null,
            'sequence' => $request->sequence ?? null,
        ]);

        return redirect()->route('dashboard.index');
    }

    public function createOption(Request $request)
    {
        $request->validate([
            'element_id' => 'required|numeric',
            'option_label' => 'required|min:3|max:40',
            'option_value' => 'required|min:1|max:40',
            'option_sequence' => 'nullable|numeric',
        ]);

        Option::create([
            'element_id' => $request->element_id,
            'label' => $request->option_label,
            'value' => $request->option_value,
            'sequence' => $request->option_sequence ?? null
        ]);

        return redirect()->route('dashboard.index');
    }
}
