<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Message;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    const DEFAULT_CHAT_CHANNEL = 'common';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('sel')) {

            $user_id = $request->get('sel');

            if (is_null($user = User::find(intval($user_id)))) {

                return redirect()->route('chat.im');
            }

            $channel = $this->getOrCreateChannel($user);
            $channelName = $channel->getAttribute('channel_name');
            $messages = $channel->getAttribute('messages');
        } else {

            $channelName = 'common';
            $messages = [];
        }

        return view('chat', [
            'chatChannel'   => $channelName,
            'messages'      => $messages
        ]);
    }

    /**
     * Store and subscribe new message
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $channelName = $request->get('channel', self::DEFAULT_CHAT_CHANNEL);

        $info = [
            'text' => e($request->input('chat_text')),
            'email' => $user->getAttribute('email'),
            'timestamp' => (time()*1000)
        ];

        app('pusher')->trigger($channelName, 'new-message', $info);

        $message = new Message;
        $message->text = $info['text'];

        Channel::where('channel_name', $channelName)->first()->messages()->save($message);

        return response()->json();
    }

    /**
     * Returns Channel that are relate to auth user and $user
     *
     * @param User $user
     * @return mixed
     */
    protected function getOrCreateChannel(User $user)
    {
        $first_user_id = auth()->user()->getKey();
        $second_user_id = $user->getKey();
        $channel = Channel::where(function($query) use ($first_user_id, $second_user_id) {

            $query->where('first_user_id', $first_user_id)
                ->where('second_user_id', $second_user_id);
        })->orWhere(function($query) use ($first_user_id, $second_user_id) {

            $query->where('first_user_id', $second_user_id)
                ->where('second_user_id', $first_user_id);
        })->first();

        if (is_null($channel)) {

            $channel = Channel::create([
                'first_user_id'     =>  $first_user_id,
                'second_user_id'    =>  $second_user_id,
                'channel_name'      =>  $first_user_id . '_' . $second_user_id
            ]);
        }

        return $channel;
    }
}
