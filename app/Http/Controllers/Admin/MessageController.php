<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // ---- MESSAGES ----

    public function index()
    {
        $messages = Message::query()
            ->with('sender')
            ->where('to', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('admin.message.list', ['messages' => $messages]);
    }

    public function create()
    {
        $users = User::query()
            ->where('id', '!=', Auth::user()->id)
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->orderBy('id', 'asc')
            ->get();
        return view('admin.message.create', ['addresses' => $users]);
    }

    public function store(Request $request)
    {
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

        $this->flashMsg('Správa bola odoslaná!');

        return redirect()->route('message.index');
    }

    public function show(Message $message)
    {
        $message->load('sender');

        $message->update(['seen' => true]);

        return view('admin.message.show', ['msg' => $message]);
    }

    public function answer(Message $message)
    {
        $message->load('sender', 'recipient');
        return view('admin.message.answer', ['msg' => $message]);
    }

    public function answerSend(Request $request, Message $message)
    {
        $message->load('sender');

        $newMsg = new Message([
            'from' => Auth::user()->id,
            'to' => $message->sender->id,
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
        ]);
        $newMsg->save();

        $this->flashMsg("Odpoveď bola odoslaná!");

        return redirect()->route('message.index');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('message.index');
    }
}
