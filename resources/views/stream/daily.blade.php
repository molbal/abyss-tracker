@extends('layout.stream-base')
@section("browser-title", "Daily browser source")
@section("content")
   <p style="color: {{$fontColor}}">{{$charId}}</p>
    @auth
        <p style="color: {{$fontColor}}">yes auth</p>
    @elseauth
        <p style="color: {{$fontColor}}">no auth</p>
    @endauth
@endsection

@section('styles')
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
            border: 0;

            width: {{$width}};
            height: {{$height}};

            color: {{$fontColor}};
            font-size: {{$fontSize}};
        }
    </style>
@endsection

@section('scripts')
    <script src="{{mix('js/stream/stream-base.js')}}"></script>
    <script>
        $(function () {
            console.log("Creating Echo");

            // Echo.channel('runs.save')
            const channel = 'runs.save.{{$charId}}';
            const event = '.run.saved';
            console.log('Subscribing to private channel ', channel,' for ', event);
            Echo.private(channel)
                .listen(event, (e) => {
                    console.warn('run.saved: ', e);
                });
        });
    </script>
@endsection
