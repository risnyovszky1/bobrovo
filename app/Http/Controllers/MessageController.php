<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\DB;
use Auth;

class MessageController extends Controller
{
    // ---- MESSAGES ---- 

    public function getMessagesPage()
    {
        $messages = DB::table('messages')
            ->join('users', 'messages.from', 'users.id')
            ->select('messages.id', 'messages.subject', 'messages.created_at', 'users.email', 'users.first_name', 'users.last_name', 'messages.seen')
            ->where('to', Auth::user()->id)
            ->orderBy('messages.created_at', 'DESC')
            ->get();
        return view('admin.msg_all', ['messages' => $messages]);
    }

    public function getSendMessagePage()
    {
        $users = DB::table('users')->select('id', 'first_name', 'last_name', 'email')->where('id', '!=', Auth::user()->id)->get();
        return view('admin.msg_send', ['addresses' => $users]);
    }

    public function postSendMessagePage(Request $request)
    {
        $users = DB::table('users')->select('id', 'first_name', 'last_name', 'email')->where('id', '!=', Auth::user()->id)->get();

        $this->validate($request, [
            'addresses' => 'required',
            'subject' => 'required|max:70',
            'content' => 'required',
        ]);

        foreach ($request->input('addresses') as $addr) {
            $msg = new Message([
                'from' => Auth::user()->id,
                'to' => $addr,
                'subject' => $request->input('subject'),
                'content' => $request->input('content'),
            ]);

            $msg->save();
        }

        return view('admin.msg_send', ['addresses' => $users, 'success' => "Správa bola odoslaná!"]);
    }

    public function getOneMessagePage($id)
    {
        $msg = DB::table('messages')
            ->join('users', 'messages.from', 'users.id')
            ->select('messages.id', 'messages.subject', 'messages.content', 'users.email', 'users.first_name', 'users.last_name')
            ->where('messages.id', $id)
            ->get();

        DB::table('messages')->where('id', $id)->update(['seen' => true]);

        return view('admin.msg_one', ['msg' => $msg->first()]);
    }

    public function getAnswerPage($id)
    {
        $msg = DB::table('messages')
            ->join('users', 'messages.from', 'users.id')
            ->select('messages.id', 'messages.subject', 'messages.content', 'users.id as uid', 'users.email', 'users.first_name', 'users.last_name')
            ->where('messages.id', $id)
            ->get();
        return view('admin.msg_answer', ['msg' => $msg->first()]);
    }

    public function postAnswerPage(Request $request, $id)
    {
        $msg = DB::table('messages')
            ->join('users', 'messages.from', 'users.id')
            ->select('messages.id', 'messages.subject', 'messages.content', 'users.id as uid', 'users.email', 'users.first_name', 'users.last_name')
            ->where('messages.id', $id)
            ->get();

        $newMsg = new Message([
            'from' => Auth::user()->id,
            'to' => $request->input('address_id'),
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
        ]);
        $newMsg->save();
        return view('admin.msg_answer', ['msg' => $msg->first(), 'success' => "Odpoveď bola odoslaná!"]);
    }

    public function getDeleteMessagePage($id)
    {
        $msg = DB::table('messages')->select('to')->where('id', $id)->first();
        if ($msg->to != Auth::user()->id)
            return redirect()->route('badlink');

        DB::table('messages')->where('id', $id)->delete();
        return redirect()->route('msg.all');
    }
}
