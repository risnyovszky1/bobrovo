<?php
use Illuminate\Support\Facades\DB;
//use Auth;


$QUESTIONS_IN_ONE_PAGE = 50;


function newMessagesCount(){
  return DB::table('messages')->select('id')->where([
      ['to', Auth::user()->id],
      ['seen', false]
    ])->count();
}

function getQuestionsAnswerText($question, $answer){
  switch ($answer) {
    case 'a':
      return $question->a;
    case 'b':
      return $question->b;
    case 'c':
      return $question->c;
    case 'd':
      return $question->d;
    default:
      return $answer;
      break;
  }
}