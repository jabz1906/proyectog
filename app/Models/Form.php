<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    
    const Active = 1;
    const Inactive = 2;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class, 'parent_id');
    }

    public function childForms()
    {
        return $this->hasMany(Form::class, 'parent_id')->with('forms');
    }
}
