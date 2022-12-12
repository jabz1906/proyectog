<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Form;
use App\Models\User;
use Livewire\Component;

class ComponentDashboard extends Component
{
    public $forms;
    public $events;
    public $events_inctive;
    public $users;
    public $users_active;
    public $users_inactive;

    public function mount()
    {
        $this->forms = Form::where('status', Form::Active)->get();
        $this->events = Event::where('status', Event::Finalized)->get();
        $this->events_inctive = Event::where('status', Form::Inactive)->get();
        $this->users = User::all();
        $this->users_active = User::where('status', User::Active)->get();
        $this->users_inactive = User::where('status', User::Inactive)->get();
    }

    public function render()
    {
        return view('livewire.component-dashboard');
    }
}
