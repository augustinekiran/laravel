<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Element;
use Illuminate\Support\Facades\Validator;

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

        if ($request->type == 'select') {
            $this->createOptions($request, $element->id);
        }

        return redirect()->route('dashboard.index');
    }

    private function createOptions(Request $request, $elementId)
    {
        $validator = Validator::make($request->all(), [
            'credit_card_number' => 'required_if:payment_type,cc'
        ]);

        if (!$validator->fails()) {
            //    
        }
    }
}
