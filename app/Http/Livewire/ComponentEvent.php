<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;

class ComponentEvent extends Component
{
    use WithPagination;

    public $search;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function mount()
    {
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = Event::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->whereHas('form', function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }
        $events = $Query->orderBy('id', 'DESC')->paginate(7);
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
        $this->reset(['search']);
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
