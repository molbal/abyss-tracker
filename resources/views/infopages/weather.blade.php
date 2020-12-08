@extends("layout.app")
@section("browser-title", sprintf("%s / %s difficulty overview",__("tiers.".$tier), $type))

@section("content")
    <div class="d-flex justify-content-between align-items-start mt-3">
        @if($tier > 0)
            <a class="text-dark" href="{{route('infopage.tier-type', ['tier' => $tier-1, 'type' => $type])}}">&leftarrow;&nbsp;@lang("tiers.".($tier-1)) {{$type}} information</a>
        @else
            <span>&nbsp;</span>
        @endif
        @if($tier < 6)
            <a class="text-dark" href="{{route('infopage.tier-type', ['tier' => $tier+1, 'type' => $type])}}">@lang("tiers.".($tier+1)) {{$type}} information&nbsp;&rightarrow;</a>
        @else
            <span>&nbsp;</span>
        @endif
    </div>
    <div class="row mt-5 mb-2">
        <div class="col-sm-12 text-center">
            <h2 class="font-weight-bold title">
                <div class="icon-wrapper shadow mb-3">
                    <img src="/tiers/{{$tier}}.png" title="@lang("tiers.".$tier) filament icon" class="page-top-icon" data-toggle="tooltip">
                </div>
                <div class="icon-wrapper shadow mb-3">
                    <img src="/types/{{$type}}.png" title="{{$type}} weather icon" class="page-top-icon" data-toggle="tooltip">
                </div>
                <br>
                @lang("tiers.".$tier) {{$type}} runs overview
                <br>
                <small class="subtitle">based on {{number_format($count, 0, ",", " ")}} user submissions</small>
            </h2>
        </div>
    </div>



    <div class="d-flex justify-content-between align-items-start ">
        <h4 class="font-weight-bold">Profitability</h4>
        <p>How much you can make in a tier {{$tier}} {{$type}} abyss run?</p>
    </div>
    <div class="row mt-2">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="20th percentile value">
                <div class="row">
                    <img src="https://img.icons8.com/ios/64/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/more-than.png" class="pull-left ml-2"/>
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($atLoCruiser/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">80% of runs are more profitable</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="Median loot value">
                <div class="row">
                    <img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath("cruiser")}}" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($medianCruiser/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">Most probable loot value (Cruisers)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="80th percentile value">
                <div class="row">
                    <img src="https://img.icons8.com/ios/64/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/less-than.png" class="pull-left ml-2"/>
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($atHiCruiser/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">80% of runs are less profitable</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="20th percentile value">
                <div class="row">
                    <img src="https://img.icons8.com/ios/64/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/more-than.png" class="pull-left ml-2"/>
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($atLoDestroyer/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">80% of runs are more profitable</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="Median loot value">
                <div class="row">
                    <img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath("destroyer")}}" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($medianDestroyer/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">Most probable loot value (Destroyers)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="80th percentile value">
                <div class="row">
                    <img src="https://img.icons8.com/ios/64/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/less-than.png" class="pull-left ml-2"/>
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($atHiDestroyer/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">80% of runs are less profitable</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="20th percentile value">
                <div class="row">
                    <img src="https://img.icons8.com/ios/64/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/more-than.png" class="pull-left ml-2"/>
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($atLoFrigate/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">80% of runs are more profitable</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="Median loot value">
                <div class="row">
                    <img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath("frigate")}}" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($medianFrigate/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">Most probable loot value (Frigates)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm" data-toggle="tooltip" title="80th percentile value">
                <div class="row">
                    <img src="https://img.icons8.com/ios/64/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/less-than.png" class="pull-left ml-2"/>
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{round($atHiFrigate/1000000, 2)}} M ISK</h2>
                        <small class="text-muted font-weight-bold">80% of runs are less profitable</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-md-12 col-sm-12">
            <div class="d-flex justify-content-between align-items-start ">
                <h4 class="font-weight-bold">Historic loot values</h4>
                <p>These graphs show how tier {{$tier}} {{$type}} loot worth changes over time.</p>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-head-cruiser" data-toggle="tab" href="#tab-graph-cruiser" role="tab" aria-controls="home" aria-selected="true">Cruiser size</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-head-destroyer" data-toggle="tab" href="#tab-graph-destroyer" role="tab" aria-controls="home" aria-selected="true">Destroyer size</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-head-frigate" data-toggle="tab" href="#tab-graph-frigate" role="tab" aria-controls="home" aria-selected="true">Frigate size</a>
                </li>
            </ul>
            <div class="card card-body border-0 shadow-sm top-left-no-round">
                <div class="tab-content" id="historic-loot-tab-content">
                    <div class="tab-pane show active" id="tab-graph-cruiser" role="tabpanel" aria-labelledby="tab-head-distribution">
                        <div class="graph-container h-300px">
                            <h5><img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath(\App\Http\Controllers\Misc\Enums\ShipHullSize::CRUISER)}}" class="smallicon mr-1" />Cruiser size median loot history</h5>
                            {!! $cruiserChart->container(); !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-graph-destroyer" role="tabpanel" aria-labelledby="tab-graph-destroyer">
                        <div class="graph-container h-300px">
                            <h5><img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath(\App\Http\Controllers\Misc\Enums\ShipHullSize::DESTROYER)}}" class="smallicon mr-1" />Destroyer size median loot history</h5>
                            {!! $destroyerChart->container(); !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-graph-frigate" role="tabpanel" aria-labelledby="tab-head-distribution">
                        <div class="graph-container h-300px">
                            <h5><img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath(\App\Http\Controllers\Misc\Enums\ShipHullSize::FRIGATE)}}" class="smallicon mr-1" />Frigate size median loot history</h5>
                            {!! $frigateChart->container(); !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


@section("scripts")
    {!! $cruiserChart->script(); !!}
    {!! $destroyerChart->script(); !!}
    {!! $frigateChart->script(); !!}

    <script>
        $(function () {

            $('#tab-head-cruiser').on('shown.bs.tab', function (e) {
                window.{{$cruiserChart->id}}.resize();
            });
            $('#tab-head-destroyer').on('shown.bs.tab', function (e) {
                window.{{$destroyerChart->id}}.resize();
            });
            $('#tab-head-frigate').on('shown.bs.tab', function (e) {
                window.{{$frigateChart->id}}.resize();
            });
        })
    </script>
@endsection

@section('styles')
    <style>
        .icon-wrapper {
            width: 72px;
            height: 72px;
            display: inline-block;
            border: 2px solid #fff;
            padding: 0;
            border-radius: 50%;
        }

        img.page-top-icon {
            width: 66px;
            height: 66px;
            padding: 0;
            margin: 3px 4px 3px 1px;
        }

        h2.title {
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 2px;
        }

        h2 small.subtitle {
            text-transform: lowercase;
            letter-spacing: 1px;
            font-weight: normal;
            font-size: 1rem;
            opacity: 0.78;

            position: relative;
            top: -12px;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(function () {
            $(".select2-nosearch-narrow").select2({
                theme: 'bootstrap',
                minimumResultsForSearch: -1,
                width: '25%'
            });
        });
    </script>
@endsection
