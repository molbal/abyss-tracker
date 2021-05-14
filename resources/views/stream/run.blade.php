@extends('layout.stream-base')
@section("browser-title", "Run popover")
@section("content")
    <div class="topbar shadow d-flex justify-content-start align-items-center flicker-in-1">

        @if($qr)
            <img src="{{route('run.qr', ['id' => $id, 'color' => ltrim($fontColor, '#')])}}" id="qr" class="shadow" alt="">
        @endif
    </div>


@endsection

@section('styles')
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
            border: 0;

            width: 1920px;
            height: 1080px;

            outline: 1px dashed red;

        }

        img#qr {
            margin-left: 32px;
            height: 148px;
            width: 148px;
            background: #fff;
            padding: 6px;
            border-radius: 12px;
        }

        div.topbar  {
            position: absolute;
            width: 1920px;
            height: 85px;
            top: 100px;
            background-image: linear-gradient(180deg, rgba(0,0,0,0.2) 10%, rgba(0,0,0,0.5) 100%);

            border: 2px solid {{$fontColor}};
            border-width: 0 0 2px 0;
        }


        .gradient {
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

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
