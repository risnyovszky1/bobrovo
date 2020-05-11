<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    protected $fillable = ['name', 'description', 'group_id', 'teacher_id', 'available_from',
                            'available_to', 'available_answers', 'available_description',
                            'mix_questions', 'time_to_do', 'public'];

    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_test', 'test_id', 'question_id');
    }
}
