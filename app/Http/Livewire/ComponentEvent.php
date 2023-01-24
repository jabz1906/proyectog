<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Form;
use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;

class ComponentEvent extends Component
{
    use WithPagination;

    public $search;

    public $form_id;
    public $question_id;
    public $textSearch;

    public $deleteModal;

    public $forms;
    public $questions;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function mount()
    {
        $this->deleteModal = false;
        $this->form_id = null;
        $this->question_id = null;
        $this->forms = Form::where('status', Form::Active)->get();
        $this->questions = collect();
    }

    public function render()
    {
        $Query = Event::query();

        if ($this->search != null) {
            $this->updatingSearch();
            /*$Query = $Query->whereHas('form', function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });*/
            $Query = $Query->where('id', 'like', '%' . $this->search . '%');
        }

        if ($this->form_id != null) {
            $Query = $Query->where('form_id', $this->form_id);
            $this->questions = Question::where('form_id', $this->form_id)
            ->where('type_id', 3)->orWhere('type_id', 4)->orWhere('type_id', 6)->orWhere('type_id', 7)->get();
        }

        if ($this->question_id != null) {
            $Query = $Query->whereHas('answers', function (Builder $query) {
                $query->where('question_id', $this->question_id);
            });
        }

        if ($this->textSearch != null)
        {
            $Query = $Query->whereHas('answers', function (Builder $query) {
                $query->where('input_data', 'like', '%' . $this->textSearch . '%');
            });
        }

        $events = $Query->where('status', '!=', Event::Inactive)->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-event', compact('events'));
    }

    public function modalDelete($id)
    {
        $this->form_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $event = Event::find($this->form_id);
        $event->status = Event::Inactive;
        $event->save();

        $this->deleteModal = false;
        $this->alerts('warning', 'Evento Eliminado Correctamente');
    }

    public function exportPdf($id)
    {
        $event = Event::find($id);
        
        $pdf = PDF::loadView('pdf.eventForm', compact('event'))->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $event->form->name.'.pdf'
       );
    }

    public function resetSearch()
    {
        $this->reset(['search', 'form_id', 'question_id', 'textSearch']);
        $this->updatingSearch();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function alerts($typeMessage, $message)
    {
        $this->dispatchBrowserEvent($typeMessage, ['message' => $message]);
    }
}
