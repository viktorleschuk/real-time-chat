@extends('layouts.app')

@section('styles')

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #edeff2;
            font-family: "Calibri", "Roboto", sans-serif;
        }

        .chat_window {
            width: calc(100% - 20px);
            max-width: 800px;
            height: 500px;
            border-radius: 10px;
            background-color: #fff;
            left: 50%;
            top: 50%;
            transform: translateX(0) translateY(0);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            background-color: #f8f8f8;
            overflow: hidden;
        }

        .top_menu {
            background-color: #fff;
            width: 100%;
            padding: 20px 0 15px;
            box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
        }
        .top_menu .buttons {
            margin: 3px 0 0 20px;
            position: absolute;
        }
        .top_menu .buttons .button {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
            position: relative;
        }
        .top_menu .buttons .button.close {
            background-color: #f5886e;
        }
        .top_menu .buttons .button.minimize {
            background-color: #fdbf68;
        }
        .top_menu .buttons .button.maximize {
            background-color: #a3d063;
        }
        .top_menu .title {
            text-align: center;
            color: #bcbdc0;
            font-size: 20px;
        }

        .messages {
            position: relative;
            list-style: none;
            padding: 20px 10px 0 10px;
            margin: 0;
            height: 347px;
            overflow: scroll;
        }
        .messages .message {
            clear: both;
            overflow: hidden;
            margin-bottom: 20px;
            transition: all 0.5s linear;
            opacity: 0;
        }
        .messages .message.left .avatar {
            background-color: #f5886e;
            float: left;
        }
        .messages .message.left .text_wrapper {
            background-color: #ffe6cb;
            margin-left: 20px;
        }
        .messages .message.left .text_wrapper::after, .messages .message.left .text_wrapper::before {
            right: 100%;
            border-right-color: #ffe6cb;
        }
        .messages .message.left .text {
            color: #c48843;
        }
        .messages .message.right .avatar {
            background-color: #fdbf68;
            float: right;
        }
        .messages .message.right .text_wrapper {
            background-color: #c7eafc;
            margin-right: 20px;
            float: right;
        }
        .messages .message.right .text_wrapper::after, .messages .message.right .text_wrapper::before {
            left: 100%;
            border-left-color: #c7eafc;
        }
        .messages .message.right .text {
            color: #45829b;
        }
        .messages .message.appeared {
            opacity: 1;
        }
        .messages .message .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-block;
        }
        .messages .message .text_wrapper {
            display: inline-block;
            padding: 20px;
            border-radius: 6px;
            width: calc(100% - 85px);
            min-width: 100px;
            position: relative;
        }
        .messages .message .text_wrapper::after, .messages .message .text_wrapper:before {
            top: 18px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }
        .messages .message .text_wrapper::after {
            border-width: 13px;
            margin-top: 0px;
        }
        .messages .message .text_wrapper::before {
            border-width: 15px;
            margin-top: -2px;
        }
        .messages .message .text_wrapper .text {
            font-size: 18px;
            font-weight: 300;
        }

        .bottom_wrapper {
            position: relative;
            width: 100%;
            background-color: #fff;
            padding: 20px 20px;
            position: absolute;
            bottom: 0;
        }
        .bottom_wrapper .message_input_wrapper {
            display: inline-block;
            height: 50px;
            border-radius: 25px;
            border: 1px solid #bcbdc0;
            width: calc(100% - 160px);
            position: relative;
            padding: 0 20px;
        }
        .bottom_wrapper .message_input_wrapper .message_input {
            border: none;
            height: 100%;
            box-sizing: border-box;
            width: calc(100% - 40px);
            position: absolute;
            outline-width: 0;
            color: gray;
        }
        .bottom_wrapper .send_message {
            width: 140px;
            height: 50px;
            display: inline-block;
            border-radius: 50px;
            background-color: #a3d063;
            border: 2px solid #a3d063;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s linear;
            text-align: center;
            float: right;
        }
        .bottom_wrapper .send_message:hover {
            color: #a3d063;
            background-color: #fff;
        }
        .bottom_wrapper .send_message .text {
            font-size: 18px;
            font-weight: 300;
            display: inline-block;
            line-height: 48px;
        }

        .message_template {
            display: none;
        }


    </style>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel-body">

                <div class="chat_window">
                    <div class="top_menu">
                        <div class="buttons">
                            <div class="button close"></div>
                            <div class="button minimize"></div>
                            <div class="button maximize"></div>
                        </div>
                        <div class="title">Common chat</div>
                    </div>
                    <ul class="messages"></ul>
                    <div class="bottom_wrapper clearfix">
                        <div class="message_input_wrapper"><input class="message_input"
                                                                  placeholder="Type your message here..."/></div>
                        <div class="send_message">
                            <div class="icon"></div>
                            <div class="text">Send</div>
                        </div>
                    </div>
                </div>
                <div class="message_template">
                    <li class="message">
                        <div class="avatar"></div>
                        <div class="text_wrapper">
                            <div class="text-right text-mutted email"></div>
                            <div class="text"></div>
                        </div>
                    </li>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://cdn.rawgit.com/samsonjs/strftime/master/strftime-min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

//        Pusher.log = function(msg) {
//            console.log(msg);
//        };
    </script>

    <script>
        var Message;
        Message = function (arg) {
            this.text = arg.text, this.email = arg.email;
            this.draw = function (_this) {
                return function () {
                    var $message;
                    var message_side = _this.email == '{{ auth()->user()->email }}' ? 'right' : 'left';
                    $message = $($('.message_template').clone().html());
                    $message.addClass(message_side).find('.text').html(_this.text);
                    if (message_side == 'left') {
                        $message.addClass(message_side).find('.email').html(_this.email);
                    }
                    $('.messages').append($message);
                    return setTimeout(function () {
                        return $message.addClass('appeared');
                    }, 0);
                };
            }(this);
            return this;
        };

        (function () {
            $(function () {
                var getMessageText, sendMessage, sendMessageSuccess;
                sendMessageSuccess = function () {

                    $('.message_input').val('');
                    console.log('message sent successfully');
                };
                getMessageText = function () {
                    var $message_input;
                    $message_input = $('.message_input');
                    return $message_input.val();
                };
                sendMessage = function (text) {
                    if (text.trim() === '') {
                        return;
                    }

                    var data = {chat_text: text};
                    $.post('{{ route('chat.store') }}', data).success(sendMessageSuccess);
                };
                $('.send_message').click(function (e) {
                    return sendMessage(getMessageText());
                });
                $('.message_input').keyup(function (e) {
                    if (e.which === 13) {
                        return sendMessage(getMessageText());
                    }
                });
            });
        }.call(this));

        var pusher = new Pusher('{{env("PUSHER_KEY")}}');

        var channel = pusher.subscribe('{{$chatChannel}}');
        channel.bind('new-message', addMessage);

        function addMessage(data) {

            var $messages = $('.messages');
            var message = new Message({
                text: data.text,
                email: data.email
            });
            message.draw();
            return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
        }
    </script>

@endsection
