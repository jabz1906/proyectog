<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions =  Question::where('status', Question::Active)->get();

        return response()->json([
            'data' => $questions
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Question $question)
    {
        return response()->json([
            'code' => 200,
            'data' => $question
        ], 200);
    }

    public function update(Request $request, Question $question)
    {
        //
    }

    public function destroy(Question $question)
    {
        //
    }
}
