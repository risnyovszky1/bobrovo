<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ['from', 'to', 'subject', 'content', 'seen'];


    public function recipient()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'from');
    }
}
