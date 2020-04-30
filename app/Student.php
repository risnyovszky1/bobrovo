<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Student extends Authenticatable
{
    //
    use Notifiable;

    protected $guard = 'bobor';

    protected $fillable = ['first_name', 'last_name', 'code', 'teacher_id'];

    protected $hidden = [
        'remember_token',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'student_group', 'student_id', 'group_id');
    }
}
