@extends('layout.stream-base')
@section("browser-title", "Daily browser source")
@section("content")
   hi
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.10.0/echo.min.js" integrity="sha512-zWBmTYhOQXqyCFDXCv6kp2Yr8Hscog103IX4XJDXnjOLki2I8P5AmLHny0vn7naLiwKkISHtEbTRtTSZdoXdpQ==" crossorigin="anonymous"></script>

    <script>

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'e9fdcb5bf99f9b62d21f',
            cluster: 'eu',
            forceTLS: true
        });

        window.Echo.private('Runs.Saves.').listen()

        // var channel = Echo.channel('my-channel');
        // channel.listen('.my-event', function(data) {
        //     alert(JSON.stringify(data));
        // });
    </script>
@endsection
