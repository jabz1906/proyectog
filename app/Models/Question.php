<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    const Active = 1;
    const Inactive = 2;

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function specials()
    {
        return $this->hasMany(Special::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
