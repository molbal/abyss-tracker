@extends('layout.stream-base')
@section("browser-title", "Run popover")
@section("content")
    @if($id)
    <div id="backdrop" class="puff-in-center">
        &nbsp;
    </div>
    <div class="topbar shadow d-flex justify-content-start align-items-center opacity-0" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="0">
        @if($qr)
            <img src="{{route('run.qr', ['id' => $id, 'color' => ltrim($fontColor, '#')])}}" id="qr" class="shadow" alt="">
        @elseif($charVisible)
            <img src="https://images.evetech.net/characters/{{$run->CHAR_ID}}/portrait?size=256" id="qr" class="shadow" alt="">
        @endif
        <span class="gradient  h1  mb-0 pb-0 mx-3 opacity-0" data-add-class="tracking-in-expand" data-remove-class="opacity-0" data-delay="800">New @lang('tiers.'.$run->TIER) {{$run->TYPE}} run saved @if($charVisible) by {{$run->NAME}}@endif</span>
    </div>
    <div class="subbar d-flex justify-content-start align-items-center opacity-0" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="1200">
        @if($run->SHIP_NAME)<span class="text-uppercase font-weight-bold">Used ship: {{$run->SHIP_NAME}}</span><span class="mx-4">&middot;</span>@endif
        @if($run->RUNTIME_SECONDS)<span class="text-uppercase font-weight-bold">Runtime: {{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($run->RUNTIME_SECONDS)}}</span><span class="mx-4">&middot;</span>@endif
            <span class="text-uppercase font-weight-bold">Profit: {{number_format($run->LOOT_ISK, 0, ",", ".")}} ISK</span>
    </div>


    @endif
@endsection

@section('styles')
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
            border: 0;

            width: 1920px;
            height: 1080px;

            outline: 1px dashed #5e0000;
            background: transparent;

        }

        div#backdrop {
            z-index: -1;
            display: block;
            position: absolute;
            width: 1920px !important;
            height: 1080px !important;
            top:0;
            left:0;
            background: rgba(0,0,0,0.34);

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
            background-image: linear-gradient(180deg, rgba(0,0,0,0.4) 10%, rgba(0,0,0,0.8) 100%);

            border: 2px solid {{$fontColor}};
            border-width: 0 0 2px 0;
        }

        div.subbar  {
            position: absolute;
            width: 1920px;
            height: 85px;
            top: 162px;
            padding: 0 200px;
            letter-spacing: 1px;
            color: #fff;
            text-shadow: 0 2px 2px rgba(0,0,0,0.6);
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
