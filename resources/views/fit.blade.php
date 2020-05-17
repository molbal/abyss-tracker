@extends("layout.app")
@section("browser-title", $ship_name." fit")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">{{$fit->NAME}} <small class="ml-3">(Fit #{{$id}})</small></h4>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="card card-body border-0 shadow-sm">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <h5 class="font-weight-bold">Fit's modules</h5>
                        <table class="table table-responsive-sm table-sm w-100 mb-4">
                            @php
                            $price = 0;
                            foreach ($fit_quicklook as $section) {
                            	foreach($section as $item) {
                            		$price += $item["count"]*$item["price"];
                            	}
                            }
                            $fit_price = $price;
                            $price += $ship_price;
                            @endphp
                            @component("components.fit_group", ["items" => $fit_quicklook["high"], "section" => "High slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["mid"], "section" => "Mid slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["low"], "section" => "Low slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["rig"], "section" => "Rigs"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["drone"], "section" => "Drones"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["ammo"], "section" => "Ammunition"])@endcomponent
                                @component("components.fit_group", ["items" => $fit_quicklook["booster"], "section" => "Boosters"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["cargo"], "section" => "Other cargo and implants"])@endcomponent
{{--                            @component("components.fit_group", ["welitems" => $fit_quicklook["implant"], "section" => "Implants"])@endcomponent--}}
                            <tr>
                                <td colspan="3" class="font-weight-bold text-right">Total without ship: {{number_format($fit_price, 0, ","," ")}} ISK</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-left text-uppercase font-weight-bold">Ship</td>
                            </tr>
                            <tr>
                                <td style="width: 36px;">
                                    <img src="https://imageserver.eveonline.com/Type/{{$fit->SHIP_ID}}_32.png" alt="{{$ship_name}} icon" style="width: 32px;height: 32px;">
                                </td>
                                <td>
                                    {{$ship_name}}
                                </td>
                                <td class="text-right">
                                    {{number_format($ship_price, 0, ",", " ")}} ISK
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="font-weight-bold text-right">Total: {{number_format($price, 0, ","," ")}} ISK</td>
                            </tr>
                        </table>
                    </div>
                    <div id="eft" class="tab-pane fade">
                        <h3>EFT</h3>
                        <textarea class="w-100 form-control readonly" rows="20" readonly="readonly" onclick="this.focus();this.select()"
                                  style="font-family: 'Fira Code', 'Consolas', fixed">{{$fit->RAW_EFT}}</textarea>
                    </div>
                </div>

                <ul class="nav nav-pills">
                    <li class="active nav-item mr-3"><a data-toggle="tab" href="#home">Formatted</a></li>
                    <li class="nav-item mr-3"><a data-toggle="tab" href="#eft">EFT</a></li>
                </ul>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Maximum suggested Abyssal difficulty</h5>
                <table class="w-100 table-sm">
                    <tr>
                        @foreach(['DARK','ELECTRICAL','EXOTIC','FIRESTORM','GAMMA'] as $type)
                            <td class="text-center" style="width: 20%">
                                <p class="h3 mb-1">
                                    @if($recommendations->$type == 0)
                                        <img src="_icons/unavailable.png" class="smallicon" alt="Nope" data-toggle="tooltip" title="Not recommended for any {{strtolower($type)}} runs">
                                        @else
                                        {{$recommendations->$type}}
                                    @endif
                                </p>
                                <img src="types/{{ucfirst(strtolower($type))}}.png"  class="tinyicon" alt=""> {{ucfirst(strtolower($type))}}
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Description</h5>
                {!! $embed !!}
                <div class="text-justify">
                    {!! $description !!}
                </div>
                <p class="text-right text-small">
                    - {{$fit->SUBMITTED}}
                </p>
            </div>
            @if($fit->VIDEO_LINK)
                <div class="card-footer">
                    <a class="btn btn-outline-info" href="{{$fit->VIDEO_LINK}}" target="_blank">Video guide</a>
                </div>
            @endif
        </div>
        <div class="col-sm-4">
            <div class="card card-body shadow-sm border-0 text-center">
                @if($fit->PRIVACY == 'public')
                    <div class="text-small">
                        <img src="https://images.evetech.net/characters/{{$fit->CHAR_ID}}/portrait?size=128" alt="{{$char_name}}" class="rounded-circle shadow" id="char_prof">
                        <br>
                        <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="h5 font-weight-bold text-dark mb-1 d-inline-block">{{$char_name}} </a>
                        <br>
                        <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="text-muted mx-1 ">profile</a> &centerdot;
                        <a href="{{route("fit.search", ['CHAR_ID' => $fit->CHAR_ID])}}" class="text-muted mx-1 ">fits</a> &centerdot;
                        <a href="https://zkillboard.com/character/{{$fit->CHAR_ID}}/" target="_blank" class="text-muted mx-1 ">killboard</a> &centerdot;
                        <a href="{{$eve_workbench_url}}" target="_blank" class="text-muted mx-1 ">eve workbench</a>
                    </div>
                @else
                    <p class="mb-0">This is an anonym fit, so its uploader is hidden.</p>
                @endif
            </div>
            <div class="card card-body shadow-sm border-0 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="" style="width: 191px;
text-align: center;">
                            <img src="https://images.evetech.net/types/{{$fit->SHIP_ID}}/render?size=64"
                                 class="rounded-circle shadow" style="border: 2px solid #fff; width: 64px;height: 64px;">
                            <br>
                            <div>
                                <h2 class="font-weight-bold mb-0 mt-3" style="line-height: 1.6rem">
                                    <a class="text-dark" href="{{route("ship_single", ["id" => $fit->SHIP_ID])}}">{{$ship_name}}</a>
                                </h2>
                                <small class="text-muted font-weight-bold">{{$ship_type}}</small>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="infolinks text-small">
                            <li><a href="{{route('ship_single', ['id' => $fit->SHIP_ID])}}" class="text-muted">ship usage</a></li>
                            <li><a href="{{route('fit.search', ['SHIP_ID' => $fit->SHIP_ID])}}" class="text-muted">ship fits</a></li>
                            <li><a href="https://zkillboard.com/ship/{{$fit->SHIP_ID}}/" target="_blank" class="text-muted">killboard</a></li>
                            <li><a href="https://www.eveworkbench.com/fitting/search?q={{$ship_name}}" target="_blank" class="text-muted">eve wbench</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @if(strtoupper($fit->STATUS) == "DONE")
                @component('components.fit_stats', ["stats" => $fit->STATS])@endcomponent
            @elseif(strtoupper($fit->STATUS) == "QUEUED")
                <div class="card card-body border-warning shadow-sm text-center mt-3">
                    <div class="mb-0">
                        <img src="https://img.icons8.com/cotton/64/000000/clock-settings.png" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Calculating stats</h5>
                        <p class="mb-0">Please reload this page in a few minutes once we have calculated its stats.</p>
                    </div>
                </div>
            @else
                <div class="card card-body border-warning shadow-sm text-center mt-3">
                    <div class="mb-0">
                        <img src="https://img.icons8.com/cotton/64/000000/cancel--v1.png" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Error</h5>
                        <p class="mb-0">The EFT fit is probably broken or we have an error in the system and could not calculate stats</p>
                    </div>
                </div>
            @endif


        </div>
    </div>
    @if (session()->get("login_id", -1) == $fit->CHAR_ID)
    <div class="row mt-5">
        <div class="card card-body border-danger shadow-sm text-center mt-3">
            <div class="mb-0">
                <h5 class="font-weight-bold">Fit settings</h5>
                <p class="mb-0">You submitted this fit so you can delete it or modify its privacy. If you would like to modify it, please delete this an create a new one instead.</p>
                <a href="{{route("fit.delete", ['id' => $fit->ID])}}" class="text-danger">Delete fit</a> &centerdot;
                <a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'public'])}}" class="">Set privacy to 'Public'</a> &centerdot;
                <a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'incognito'])}}" class="">Set privacy to 'Anonym'</a> &centerdot;
                <a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'private'])}}" class="">Set privacy to 'Private'</a>
            </div>
        </div>
    </div>
    @endif
@endsection
@section("styles")
    <style>
        .table-sm td, .table-sm th {
            padding: .1rem;
        }
    </style>
@endsection
@section("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
    <script>
        $(function () {
            $('.inline-pie').sparkline('html', {
                type: 'pie',
                sliceColors: ['#78b7aa', 'rgba(0,0,0,0)'],
                disableInteraction: true
            });
            $('.inline-pie').animate({'opacity': 1}, 1500);
        });
    </script>
@endsection
