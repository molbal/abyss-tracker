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
                                <td colspan="3" class="font-weight-bold text-right">Total: {{number_format($fit->PRICE, 0, ","," ")}} ISK</td>
                            </tr>
                        </table>
                    </div>
                    <div id="eft" class="tab-pane fade">
                        <h3>EFT</h3>
                        <textarea class="w-100 form-control readonly" rows="20" readonly="readonly" style="font-family: 'Fira Code', 'Consolas', fixed">{{$fit->RAW_EFT}}</textarea>
                    </div>
                </div>

                <ul class="nav nav-pills">
                    <li class="active nav-item mr-3"><a data-toggle="tab" href="#home">Formatted</a></li>
                    <li class="nav-item mr-3"><a data-toggle="tab" href="#eft">EFT</a></li>
                </ul>
            </div>

            @component('components.fit_stats', ["stats" => $fit->STATS])@endcomponent
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
                <div>
                    <img src="https://images.evetech.net/characters/{{$fit->CHAR_ID}}/portrait?size=128" alt="{{$char_name}}" class="rounded-circle shadow" id="char_prof">
                    <br>
                    <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="h5 font-weight-bold text-dark">{{$char_name}} </a>
                </div>
            </div>
            <div class="card card-body shadow-sm border-0 mt-3">
                <div class="row">
                    <img src="https://images.evetech.net/types/{{$fit->SHIP_ID}}/render?size=64"
                         class="pull-left ml-2 rounded-circle shadow-sm">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0"><a class="text-dark"
                                                             href="{{route("ship_single", ["id" => $fit->SHIP_ID])}}">{{$ship_name}}</a>
                        </h2>
                        <small class="text-muted font-weight-bold">{{$ship_type}}</small>
                    </div>
                </div>
            </div>
            @if(strtoupper($fit->STATUS) == "DONE")
                @component('components.fit_stats', ["stats" => $fit->STATS])@endcomponent
            @elseif(strtoupper($fit->STATUS) == "QUEUED")
                <div class="card card-body border-warning shadow-sm text-center">
                    <div class="mb-0">
                        <img src="https://img.icons8.com/cotton/64/000000/clock-settings.png" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Calculating stats</h5>
                        <p class="mb-0">Please reload this page in a few minutes once we have calculated its stats.</p>
                    </div>
                </div>
            @else
                <div class="card card-body border-warning shadow-sm text-center">
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
            top: -2px;
        }

        .table td, .table th {
            border-top: 0 solid transparent !important;
        }

        td.tinyhead {
            line-height: 0.6rem;
        }

        img.tinyicon {
            width:16px;
            height:16px;
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
            font-family: 'Shentox', sans-serif  !important;
            text-align: left;
            padding: 1rem;
        }
        .inline-pie {
            position: relative;
            top:4px
        }
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
                sliceColors: ['#3c5163', '#aaa']

            } );
        });
    </script>
@endsection
