<?php

namespace App\Http\Livewire;

use App\Models\Question;
use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ComponentQuestion extends Component
{
    use WithPagination;
    use WithFileUploads;

    //Variables enviadas por la vista
    public $form;

    //variables del componente
    public $action;
    public $iteration;
    public $search;

    public $form_id;
    public $name_form;
    public $type_id;
    public $name;
    public $mandatory;
    public $order;
    public $question_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'type_id' => 'required',
        'name' => 'required|max:200',
        'mandatory' => 'required|boolean',
        'order' => 'required|integer'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
        $this->form_id = $this->form->id;
        $this->name_form = $this->form->name;
    }

    public function render()
    {
        $Query = Question::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $questions = $Query->where('form_id', $this->form_id)->where('status', Question::Active)->orderBy('id', 'ASC')->paginate(7);
        $types = Type::where('status', Type::Active)->get();
        return view('livewire.component-question', compact('questions', 'types'));
    }

    public function store()
    {
        $this->validate();

        $question = new Question();
        $question->form_id = $this->form_id;
        $question->type_id = $this->type_id;
        $question->name = $this->name;
        $question->mandatory = $this->mandatory;
        $question->order = $this->order;
        $question->save();

        $this->clear();
        $this->alerts('success', 'Pregunta Registrada Correctamente');
    }

    public function edit($id)
    {
        $this->question_id = $id;
        $question = Question::find($id);
        $this->type_id = $question->type_id;
        $this->name = $question->name;
        $this->mandatory = $question->mandatory;        
        $this->order = $question->order;

        $this->action = "edit";
    }

    public function update()
    {
        $question = Question::find($this->question_id);

        $this->validate();
        $question->form_id = $this->form_id;
        $question->type_id = $this->type_id;
        $question->name = $this->name;
        $question->mandatory = $this->mandatory;
        $question->order = $this->order;
        $question->save();

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Pregunta Editada Correctamente');
    }

    public function modalDelete($id)
    {
        $this->question_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $question = Question::find($this->question_id);
        $question->status = Question::Inactive;
        $question->save();

        $this->clear();
        $this->deleteModal = false;
        $this->alerts('warning', 'Pregunta Eliminada Correctamente');
    }

    public function clear()
    {
        $this->reset(['type_id', 'name', 'mandatory', 'order', 'question_id']);
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
