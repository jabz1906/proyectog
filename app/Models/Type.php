<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    const Active = 1;
    const Inactive = 2;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
