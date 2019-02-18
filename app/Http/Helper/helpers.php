<?php
use App\User;

function getUserNameFromId($id){
  $user = User::find($id);
  return "qweqe";
  return $user->first_name . ' ' . $user->last_name;
}
