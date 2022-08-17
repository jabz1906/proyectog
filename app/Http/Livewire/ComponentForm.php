<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ComponentForm extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $iteration;
    public $search;

    public $parent_id;
    public $name;
    public $description;
    public $image;
    public $imageBefore;
    public $form_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'description' => 'required|max:1000',
        'image' => 'required|mimes:jpg,bmp,png|max:5120'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = Form::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $forms = $Query->where('status', Form::Active)->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-form', compact('forms'));
    }

    public function store()
    {
        $this->validate();

        $form = new Form();
        if ($this->parent_id == "null") {
            $form->parent_id = null;
        } else {
            $form->parent_id = $this->parent_id;
        }
        $form->name = $this->name;
        $form->description = $this->description;
        $form->image = $this->image->store('public');
        $form->save();

        $this->clear();
        $this->alerts('success', 'Formulario Registrado Correctamente');
    }

    public function edit($id)
    {
        $this->form_id = $id;
        $form = Form::find($id);
        $this->parent_id = $form->parent_id;
        $this->name = $form->name;
        $this->description = $form->description;
        $this->imageBefore = $form->image;

        $this->action = "edit";
    }

    public function update()
    {
        $form = Form::find($this->form_id);

        if ($this->image != null) {
            $this->validate();
            Storage::delete($form->image);
            $form->parent_id = $this->parent_id;
            $form->name = $this->name;
            $form->description = $this->description;
            $form->image = $this->image->store('public');
            $form->save();
        } else {
            $this->validate([
                'name' => 'required|max:200',
                'description' => 'required|max:1000',
            ]);
            $form->parent_id = $this->parent_id;
            $form->name = $this->name;
            $form->description = $this->description;
            $form->save();
        }

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Formulario Editado Correctamente');
    }

    public function modalDelete($id)
    {
        $this->form_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $form = Form::find($this->form_id);
        $form->parent_id = null;
        $form->status = Form::Inactive;
        $form->save();

        $forms = Form::where('parent_id', $this->form_id)->get();
        foreach ($forms as $form)
        {
            $form->parent_id = null;
            $form->save();
        }

        $this->clear();
        $this->deleteModal = false;
        $this->alerts('warning', 'Formulario Eliminado Correctamente');
    }

    public function clear()
    {
        $this->reset(['parent_id', 'name', 'description', 'image', 'form_id']);
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
