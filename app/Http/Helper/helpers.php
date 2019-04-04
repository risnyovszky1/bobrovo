<?php
use Illuminate\Support\Facades\DB;
use Auth;

function newMessagesCount(){
  return DB::table('messages')->select('id')->where([
      ['to', Auth::user()->id],
      ['seen', false]
    ])->count();
}