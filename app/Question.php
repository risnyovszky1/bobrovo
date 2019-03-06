<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = [
        'title', 'question', 'a', 'b', 'c', 'd',  'answer', 'type', 
        'difficulty', 'description', 'description_teacher', 'created_by', 'public' 
    ];
}
