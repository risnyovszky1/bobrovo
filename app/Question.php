<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = [
        'title', 'question', 'a', 'b', 'c', 'd',  'answer', 'type', 'year',
        'difficulty', 'description', 'description_teacher', 'created_by', 'public'
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'question_category', 'question_id', 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id');
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'question_test', 'question_id', 'test_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'question_id');
    }
}
