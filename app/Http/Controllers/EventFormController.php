<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Event;
use App\Models\Form;
use App\Models\Option;
use App\Models\Question;
use App\Models\Special;
use Illuminate\Http\Request;

class EventFormController extends Controller
{
    public function form(Form $form)
    {
        $questions = Question::where('form_id', $form->id)->where('status', 1)->orderBy('order', 'ASC')->get();
        $form->questions = $questions;
        foreach ($form->questions as $question) {
            if ($question->type_id != 10) {
                $options = Option::where('question_id', $question->id)->where('status', 1)->orderBy('order', 'ASC')->get();
                $question->options = $options;
            }

            if ($question->type_id == 10) {
                $special = Special::where('question_id', $question->id)->where('status', 1)->first();
                $options = Answer::select('id', 'input_data')->where('question_id', $special->data_id)->get();
                $question->options = $options;
            }
        }

        return response()->json([
            'code' => 200,
            'data' => $form
        ], 200);
    }

    public function save(Request $request)
    {
        $event = new Event();
        if ($request->parent_id == 0) {
            $event->parent_id = null;
        } else {
            $event->parent_id = $request->parent_id;
            $eventParent = Event::find($request->parent_id);
            $eventParent->status = Event::Finalized;
            $eventParent->save();
        }

        $event->form_id = $request->form_id;
        $event->user_id = $request->user_id;
        $event->registered = $request->registered;

        $form = Form::find($request->form_id);
        if (!$form->forms) {
            $event->status = Event::Finalized;
        }

        $event->save();

        $answers = $request->answers;
        $event_id = $event->id;

        foreach ($answers as $answer) {
            $register = new Answer();
            $register->event_id = $event_id;
            $register->question_id = $answer['question_id'];

            if ($answer['option_id'] == 0) {
                $register->option_id = null;
            } else {
                $register->option_id = $answer['option_id'];
            }

            if ($answer['input_data'] == 0) {
                $register->input_data = null;
            } else {
                $register->input_data = $answer['input_data'];
            }

            if ($answer['media_file'] == 0) {
                $register->media_file = null;
            } else {
                $register->media_file = $answer['media_file'];
            }

            $register->save();
        }

        return response()->json([
            'code' => 200,
            'message' => "Registrado correctamente",
            'event_id' => $event_id
        ]);
    }
}
