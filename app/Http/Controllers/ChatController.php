<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    protected $pusher;
    protected $user;
    protected $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'chat';

    public function __construct()
    {
    }

    public function index()
    {
//        if(!$this->user)
//        {
//            return redirect('auth/github?redirect=/chat');
//        }

//        dd($this->user);

        return view('chat', ['chatChannel' => self::DEFAULT_CHAT_CHANNEL]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $message = [
            'text' => e($request->input('chat_text')),
            'email' => $user->getAttribute('email'),
//            'avatar' => $this->user->getAvatar(),
            'timestamp' => (time()*1000)
        ];

        app()->make('pusher')->trigger(self::DEFAULT_CHAT_CHANNEL, 'new-message', $message);
    }
}