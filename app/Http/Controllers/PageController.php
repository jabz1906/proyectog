<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function form()
    {
        return view('pages.form');
    }

    public function question($id)
    {
        $form = Form::find($id);
        return view('pages.question', compact('form'));
    }

    public function option($id)
    {
        $question = Question::find($id);
        return view('pages.option', compact('question'));
    }

    public function event()
    {
        return view('pages.event');
    }

    public function user()
    {
        return view('pages.user');
    }
}
