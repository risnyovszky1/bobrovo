<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name', 'parent_id'];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_category', 'category_id', 'question_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
