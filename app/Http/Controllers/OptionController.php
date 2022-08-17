<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        $options =  Option::where('status', Option::Active)->get();

        return response()->json([
            'code' => 200,
            'data' => $options
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Option $option)
    {
        return response()->json([
            'code' => 200,
            'data' => $option
        ], 200);
    }

    public function update(Request $request, Option $option)
    {
        //
    }

    public function destroy(Option $option)
    {
        //
    }
}
