@extends('layout.stream-base')
@section("browser-title", "Run popover")
@section("content")
    @if($id)
    <div id="backdrop" class="puff-in-center overlay_container">
        &nbsp;
    </div>
    <div class="topbar shadow d-flex justify-content-start align-items-center opacity-0 overlay_container" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="0">
        @if($qr)
            <img src="{{route('run.qr', ['id' => $id, 'color' => ltrim($fontColor, '#')])}}" id="qr" class="shadow" alt="">
        @elseif($charVisible)
            <img src="https://images.evetech.net/characters/{{$run->CHAR_ID}}/portrait?size=256" id="qr" class="shadow" alt="">
        @endif
        <span class="gradient  h1  mb-0 pb-0 mx-3 opacity-0" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="800">New @lang('tiers.'.$run->TIER) {{$run->TYPE}} run saved @if($charVisible) by {{$run->NAME}}@endif</span>
    </div>
    <div class="subbar d-flex justify-content-start align-items-center opacity-0 overlay_container" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="1200">
        @if($run->SHIP_NAME)<span class="text-uppercase font-weight-bold">Used ship: {{$run->SHIP_NAME}}</span><span class="mx-4">&middot;</span>@endif
        @if($run->RUNTIME_SECONDS)<span class="text-uppercase font-weight-bold">Runtime: {{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($run->RUNTIME_SECONDS)}}</span><span class="mx-4">&middot;</span>@endif
            <span class="text-uppercase font-weight-bold">Profit: {{number_format($run->LOOT_ISK, 0, ",", ".")}} ISK</span>
    </div>
    <div class="container overlay_container" id="lost_and_found">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="text-uppercase font-weight-bold opacity-0" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="1600">Looted</h3>
                @foreach($loot as $item)
                    <div class="d-flex loot-item justify-content-start align-items-center opacity-0 mb-2" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="{{($loop->index*100) + 1600}}">
                        <img src="https://imageserver.eveonline.com/Type/{{$item->ITEM_ID}}_32.png"
                             alt="" class="mr-2" />
                        <span>{{$item->NAME}} (x{{$item->COUNT}})</span>
                    </div>
                    @php
                        $last = ($loop->index*100) + 1600;
                    @endphp
                @endforeach
            </div>
            <div class="col-sm-6">
                <h3 class="text-uppercase font-weight-bold opacity-0" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="{{$last + 100}}">Lost &amp; Consumed</h3>
                @foreach($lost as $item)
                    <div class="d-flex loot-item justify-content-start align-items-center opacity-0 mb-2" data-add-class="puff-in-center" data-remove-class="opacity-0" data-delay="{{($loop->index*100) + 100 + $last}}">
                        <img src="https://imageserver.eveonline.com/Type/{{$item->ITEM_ID}}_32.png"
                             alt="" class="mr-2" />
                        <span>{{$item->NAME}} (x{{$item->COUNT}})</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="overlay_container" id="credit">
        <span class="text-muted">Screen provided by abyss.eve-nt.uk</span>
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

            overflow: hidden;
        }

        #credit {
            position: absolute;
            right: 32px;
            bottom: 32px;
        }

        div#backdrop {
            z-index: -1;
            display: block;
            position: absolute;
            width: 1920px !important;
            height: 1080px !important;
            top:0;
            left:0;
            background-image: linear-gradient(45deg, rgba(159, 159, 159, 0.4) 0%, rgba(62, 62, 62, 0.8) 100%);
            background-image: -webkit-linear-gradient(45deg, rgba(159, 159, 159, 0.4) 0%, rgba(62, 62, 62, 0.8) 100%);

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
            background-image: -webkit-linear-gradient(180deg, rgba(0,0,0,0.4) 10%, rgba(0,0,0,0.8) 100%);

            border: 2px solid {{$fontColor}};
            border-width: 0 0 2px 0;

            letter-spacing: 1px;
            color: #fff;
            text-shadow: 0 2px 2px rgba(0,0,0,0.6);
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

        #lost_and_found {
            position: absolute;
            top: 273px;
            left: 187px;
        }

        h3 {
            text-shadow: 0 2px 2px rgba(0,0,0,0.6);

        }
        .loot-item {
            letter-spacing: 1px;
            color: #fff;
            text-shadow: 0 2px 2px rgba(0,0,0,0.6);
            text-transform: uppercase;
            font-weight: bold;
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

            setTimeout(function() {$(".overlay_container").removeClass("opacity-0").removeClass("puff-in-center").addClass("fade-out-bck")}, 2000+{{$duration}});
            setTimeout(function() {$(".overlay_container").remove()}, 2000+{{$duration}}+5000);
            console.log("Creating Echo");

            const channel = 'runs.save.{{$charId}}';
            {{--const token = '{{$token}}';--}}
            const urlFirst = '{{route('stream-tools.run.view', ['token' => $token, 'id' => '__ID__'])}}';
            const event = '.run-saved';
            console.log('Subscribing on ', channel,'for ', event);
            Echo.private(channel)
                .listen(event, (e) => {
                    console.warn('run.saved: ', e);
                    window.location = urlFirst.replace('__ID__', e.lastRunId);
                });
        });
    </script>
@endsection
