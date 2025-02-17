<?php

namespace App\Http\Controllers;

use App\Jobs\SendFormCreatedMail;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Element;
use App\Models\Option;
use App\Models\FormSubmission;
use App\Models\FormInput;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FormBuilderController extends Controller
{
    public function createForm(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:40'
        ]);

        $slugExist = false;
        $formPostValue = 0;

        do {
            $slug = Str::slug($request->name) . ($formPostValue != 0 ? "-$formPostValue" : '');
            $slugExist = Form::where('slug', $slug)->exists();
            $formPostValue++;
        } while ($slugExist);

        $form = Form::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        if (isset($form->id)) {
            SendFormCreatedMail::dispatch($form, Auth::user());
        }

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

    public function deleteElement($elementId)
    {
        Element::findOrFail($elementId)->delete();
        return redirect()->route('dashboard.index');
    }

    public function deleteForm($formId)
    {
        Form::findOrFail($formId)->delete();
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

    public function showForm($formSlug)
    {
        $form = Form::where('slug', $formSlug)
            ->with([
                'elements' => function ($query) {
                    $query->orderByRaw('ISNULL(sequence), sequence ASC') // nulls last, order by sequence
                        ->orderBy('id', 'asc');  // if sequence is null, order by id
                },
                'elements.options' => function ($query) {
                    $query->orderByRaw('ISNULL(sequence), sequence ASC') // nulls last, order by sequence
                        ->orderBy('id', 'asc');  // if sequence is null, order by id
                }
            ])
            ->first();

        if ($form) {
            return view('show_form')->with('form', $form);
        }

        abort(404);
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'form_id' => 'required|numeric',
            'form_slug' => 'required|min:1|max:40',
        ]);

        try {
            $elementInputs = array_filter($request->all(), function ($value, $key) {
                return is_numeric($key);
            }, ARRAY_FILTER_USE_BOTH);

            if (count($elementInputs) > 0) {
                $formSubmission = FormSubmission::create([
                    'form_id' => $request->form_id
                ]);

                $insertArray = [];

                foreach ($elementInputs as $key => $input) {
                    array_push($insertArray, [
                        'form_submission_id' => $formSubmission->id,
                        'element_id' => $key,
                        'value' => $input,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                FormInput::insert($insertArray);
                return redirect()->route('form.show', ['form_slug' => $request->form_slug])->with('message', 'Form successfully submitted.');
            }
        } catch (\Exception $ex) {
            info("Exception while form submit: $ex");
        }

        return redirect()->route('form.show', ['form_slug' => $request->form_slug])->with('error', 'Cannot submit form. Please try again.');
    }

    public function editElement($elementId)
    {
        $element = Element::findOrFail($elementId);
        return view('edit_element')->with('element', $element);
    }

    public function updateElement(Request $request, $elementId)
    {
        $request->validate([
            'type' => 'required|min:3|max:40',
            'label' => 'required|min:3|max:40',
            'required' => 'required|boolean',
            'value' => 'max:40',
            'sequence' => 'nullable|numeric',
        ]);

        $updateArray = [
            'type' => $request->type,
            'label' => $request->label,
            'required' => $request->required,
            'value' => $request->value,
            'sequence' => $request->sequence
        ];

        if ($request->type != 'select') {
            Option::where('element_id', $elementId)->delete();
        }

        Element::findOrFail($elementId)->update($updateArray);
        return redirect()->route('dashboard.index');
    }
}
