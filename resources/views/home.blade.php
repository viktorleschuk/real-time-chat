@extends('layouts.app')

@section('styles')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel-body">

                @include('partials.chat_window')

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script>
        alert('qwerty');
    </script>

@endsection
