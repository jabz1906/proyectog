<?php

namespace App\Http\Livewire;

use App\Models\Form;
use App\Models\Question;
use App\Models\Special;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ComponentSpecial extends Component
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
    public $form_id;
    public $data_id;
    public $special_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'data_id' => 'required'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
        $this->question_id = $this->question->id;
        $this->name_question = $this->question->name;
        $this->form_id = null;
        $this->data_id = null;
    }
    
    public function render()
    {
        $forms = Form::query();
        $forms = $forms->where('status', Form::Active)->orderBy('id', 'ASC')->get();
        
        $questions = Question::query();
        if($this->form_id != null)
        {
            $questions = $questions->where('form_id', $this->form_id)->where('status', Question::Active)->orderBy('id', 'ASC')->get();
        }

        $Query = Special::query();
        $specials = $Query->where('status', Special::Active)->orderBy('id', 'ASC')->paginate(7);
        return view('livewire.component-special', compact('forms', 'questions', 'specials'));
    }

    public function store()
    {
        $this->validate();

        $special = new Special();
        $special->question_id = $this->question_id;
        $special->data_id = $this->data_id;
        $special->save();

        $this->clear();
        $this->alerts('success', 'Pregunta Registrada Correctamente');
    }

    public function edit($id)
    {
        $this->special_id = $id;
        $special = Special::find($id);
        $question =  Question::find($special->data_id);
        $this->form_id = $question->form_id;
        $this->data_id = $special->data_id;

        $this->action = "edit";
    }

    public function update()
    {
        $special = Special::find($this->special_id);

        $this->validate();
        $special->data_id = $this->data_id;
        $special->save();

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Pregunta Editada Correctamente');
    }

    public function modalDelete($id)
    {
        $this->special_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $special = Special::find($this->special_id);
        $special->status = Special::Inactive;
        $special->save();

        $this->clear();
        $this->deleteModal = false;
        $this->alerts('warning', 'Pregunta Eliminada Correctamente');
    }

    public function clear()
    {
        $this->reset(['form_id', 'data_id', 'special_id']);
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
