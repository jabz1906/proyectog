<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function index()
    {
        $forms =  Form::where('status', Form::Active)->whereNull('parent_id')->get();

        foreach($forms as $form)
        {
            $form->image = base64_encode(Storage::get($form->image));
        }

        return response()->json([
            'code' => 200,
            'data' => $forms
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Form $form)
    {
        $forms = $form->forms;

        foreach($forms as $form)
        {
            $form->image = base64_encode(Storage::get($form->image));
        }

        return response()->json([
            'code' => 200,
            'data' => $form,
            'child' => $forms
        ], 200);
    }

    public function update(Request $request, Form $form)
    {
        //
    }

    public function destroy(Form $form)
    {
        //
    }
}
