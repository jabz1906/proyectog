<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ComponentCalendar extends Component
{
    public function render()
    {
        $calendar = [];

        $events = Event::where('form_id', 2)->get();

        foreach ($events as $event) {
            $answers = $event->answers;
            $title = "cita " . $event->user->name;
            $start = "";
            $end = "";
            $date = "";
            $client = "";
            foreach ($answers as $answer) {
                if ($answer->question_id == 8) {
                    $dataClient = Answer::find($answer->input_data);
                    $client = $dataClient->input_data;
                }
                if ($answer->question_id == 9) {
                    $date = $answer->input_data;
                }
                if ($answer->question_id == 10) {
                    $start = $answer->input_data;
                }
                /*if ($answer->question_id == 9) {
                    $end = $answer->input_data;
                }*/
            }

            $auxDate = explode("-", $date);
            $year = $auxDate[0];
            $month = $auxDate[1];
            $day = $auxDate[2];

            $auxHour = explode(":", $start);
            $hour = $auxHour[0];
            $minute = $auxHour[1];
            $second = 0;

            $tz = "America/La_Paz";

            $title = $title . " " . $client;

            $calendar[] = [
                'title' => $title,
                //'start' => Carbon::createFromFormat('Y-m-d', $date)->toDateTimeString(),
                'start' => Carbon::create($year, $month, $day, $hour, $minute, $second, $tz),
                'color' => "purple"
            ];
        }

        $calendar =  json_encode($calendar);

        return view('livewire.component-calendar', compact('calendar'));
    }
}
