@extends('layout.stream-base')
@section("browser-title", "Daily browser source")
@section("content")
    @auth

    @elseauth
        <h1>ERROR: Expired session.</h1>
    @endauth
@endsection

@section('styles')
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
            border: 0;

            width: 1920px;
            height: 1080px;

        }

        body, tr, td, span, p, small {
            color: {{$fontColor}};
            font-size: {{$fontSize}};
            text-align: {{$align}};
            text-shadow: 0 2px 3px rgba(255,255,255, .15);
        }

        small.text-muted {
            font-size: 0.5rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{mix('js/stream/stream-base.js')}}"></script>
    <script>
        $(function () {
            console.log("Creating Echo");

            const channel = 'runs.save.{{$charId}}';
            {{--const token = '{{$token}}';--}}
            const urlFirst = '{{route('stream-tools.run.view', ['token' => $token, 'id' => '__ID__'])}}';
            const event = '.run-saved';
            console.log('Subscribing on ', channel,'for ', event);
            Echo.private(channel)
                .listen(event, (e) => {
                    console.warn('run.saved: ', e);



                });
        });
    </script>
@endsection
