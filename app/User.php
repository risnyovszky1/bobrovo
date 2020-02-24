<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'first_name', 'last_name', 'password', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function students()
    {
        return $this->hasMany(Student::class, 'teacher_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'created_by');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'created_by');
    }
}
