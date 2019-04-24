<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    protected $fillable = ['name', 'description', 'group_id', 'teacher_id', 'available_from',
                            'available_to', 'available_answers', 'available_description', 
                            'mix_questions', 'time_to_do', 'public'];
}
