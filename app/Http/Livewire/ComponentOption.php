<?php

namespace App\Http\Livewire;

use App\Models\Option;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ComponentOption extends Component
{
    use WithPagination;
    use WithFileUploads;

    //Variables enviadas por la vista
    public $question;

    //variables del componente
    public $action;
    public $iteration;
    public $search;

    public $question_id;
    public $name_question;
    public $name;
    public $order;
    public $option_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'order' => 'required|integer'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
        $this->question_id = $this->question->id;
        $this->name_question = $this->question->name;
    }

    public function render()
    {
        $Query = Option::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $options = $Query->where('question_id', $this->question_id)->where('status', Option::Active)->orderBy('id', 'ASC')->paginate(7);
        return view('livewire.component-option', compact('options'));
    }

    public function store()
    {
        $this->validate();

        $option = new Option();
        $option->question_id = $this->question_id;
        $option->name = $this->name;
        $option->order = $this->order;
        $option->save();

        $this->clear();
        $this->alerts('success', 'Pregunta Registrada Correctamente');
    }

    public function edit($id)
    {
        $this->option_id = $id;
        $option = Option::find($id);
        $this->name = $option->name;     
        $this->order = $option->order;

        $this->action = "edit";
    }

    public function update()
    {
        $option = Option::find($this->option_id);

        $this->validate();
        $option->question_id = $this->question_id;
        $option->name = $this->name;
        $option->order = $this->order;
        $option->save();

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Pregunta Editada Correctamente');
    }

    public function modalDelete($id)
    {
        $this->option_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $option = Option::find($this->option_id);
        $option->status = Option::Inactive;
        $option->save();

        $this->clear();
        $this->deleteModal = false;
        $this->alerts('warning', 'Pregunta Eliminada Correctamente');
    }

    public function clear()
    {
        $this->reset(['name', 'order', 'option_id']);
        $this->iteration++;
        $this->action = "create";
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
