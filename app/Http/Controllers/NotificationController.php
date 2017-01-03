<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notification');
    }

    public function store(Request $request)
    {
        $notifyText = e($request->input('notify_text'));

        $pusher = app()->make('pusher');

        $pusher->trigger('test-channel',
            'new-notification',
            array('text' => $notifyText));
    }
}