<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    use HasFactory;

    const Active = 1;
    const Inactive = 2;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function data()
    {
        return $this->belongsTo(Question::class);
    }
}
