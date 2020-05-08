@extends("layout.app")
@section("browser-title", $ship_name." fit by ".$char_name)
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">{{$fit->NAME}} by <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}">{{$char_name}}</a></h4>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="card card-body border-0 shadow-sm">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <h5 class="font-weight-bold">Fit's modules</h5>
                        <table class="table table-responsive-sm table-sm w-100 mb-4">
                            @component("components.fit_group", ["items" => $fit_quicklook["high"], "section" => "High slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["mid"], "section" => "Mid slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["low"], "section" => "Low slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["rig"], "section" => "Rigs"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["other"], "section" => "Drones & cargo"])@endcomponent
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
                                <td colspan="3" class="font-weight-bold text-right">Total: {{number_format($fit->PRICE, 0, ","," ")}} ISK</td>
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
                <h5 class="font-weight-bold">Description</h5>
                <div class="text-justify">
                    {!! $description !!}
                </div>
                <p class="text-right text-small">
                    - {{$fit->SUBMITTED}}
                </p>
            </div>
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
                        <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="text-muted mx-1 ">fits</a> &centerdot;
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
                                <h2 class="font-weight-bold mb-0 mt-3" style="line-height: 1rem">
                                    <a class="text-dark" href="{{route("ship_single", ["id" => $fit->SHIP_ID])}}">{{$ship_name}}</a>
                                </h2>
                                <small class="text-muted font-weight-bold">{{$ship_type}}</small>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="infolinks text-small">
                            <li><a href="{{route('ship_single', ['id' => $fit->SHIP_ID])}}" class="text-muted">ship usage</a></li>
                            <li><a href="{{route('ship_single', ['id' => $fit->SHIP_ID])}}" class="text-muted">ship fits</a></li>
                            <li><a href="https://zkillboard.com/ship/{{$fit->SHIP_ID}}/" target="_blank" class="text-muted">killboard</a></li>
                            <li><a href="https://www.eveworkbench.com/fitting/search?q={{$ship_name}}" target="_blank" class="text-muted">eve workbench</a></li>
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
@endsection
@section("styles")
    <style>
        .bringupper {
            position: relative;
            top: -1px;
        }

        .table td, .table th {
            border-top: 0 solid transparent !important;
        }

        td.tinyhead {
            line-height: 0.6rem;
        }

        img.tinyicon {
            width: 16px;
            height: 16px;
        }

        img.smallicon {
            width: 24px;
            height: 24px;
        }

        td.w-20p {
            width: 20px !important;
        }

        #char_prof {
            width: 128px;
            height: 128px;
            position: relative;
            top: -52px;
            margin-bottom: -38px;
            border: 2px solid #fff;
        }

        .jqsfield {
            color: #fff;
            font-family: 'Shentox', sans-serif !important;
            text-align: left;
            padding: 1rem;
        }

        .inline-pie {
            position: relative;
            top: 4px;
            opacity: 0.01;
            overflow: hidden;
            width: 16px;
            height: 16px;
            display: inline-block;
        }

        .table-sm td, .table-sm th {
            padding: .1rem;
        }

        ul.infolinks {
            list-style: none;
            margin-bottom: 0;
            padding: 0 20px
        }

        .resist-outer {
            display: block;
            width: 100%;
            height: 20px;
            padding: 0;
            margin:0;
            border: 1px solid rgba(1,5,54,0.59);
            border-radius: 2px;
            -webkit-border-radius: 2px;
            -webkit-box-shadow:inset 0 -4px 8px -2px rgba(1,5,54,0.59);
            box-shadow:inset 0 -4px 8px -2px rgba(1,5,54,0.59);
        }

        .resist-inner {
            display: inline-block;
            height: 100%;
            -webkit-box-shadow:inset 0 -4px 8px -2px rgba(1,5,54,0.59);
            box-shadow:inset 0 -4px 8px -2px rgba(1,5,54,0.59);
        }
        .resist-label {    z-index: 3;
            color: #fff;
            text-shadow: 0 0 2px #010536, 0 1px 0 rgba(1,5,54,0.59);
            position: relative;
            top: -28px;
            display: inline-block;
            width: 100%;
            text-align: center;
        }
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
