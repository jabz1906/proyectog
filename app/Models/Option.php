<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    
    const Active = 1;
    const Inactive = 2;

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
