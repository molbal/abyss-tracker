@extends("layout.app")
@section("browser-title", sprintf("%s difficulty overview",__("tiers.".$tier)))

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 text-center">
            <h2 class="font-weight-bold title">
                <div class="icon-wrapper shadow mb-3">
                    <img src="/tiers/{{$tier}}.png" alt="@lang("tiers.".$tier) filament icon" class="page-top-icon">
                </div>
                <br>
                @lang("tiers.".$tier) runs overview
                <br>
                <small class="subtitle">based on {{number_format($count, 0, ",", " ")}} user submissions</small>
            </h2>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-start ">
        <h4 class="font-weight-bold">Profitability</h4>
        <p>How much you can make in a tier {{$tier}} abyss run?</p>
    </div>
    <div class="row mt-2">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
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
            <div class="card card-body border-0 shadow-sm">
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
            <div class="card card-body border-0 shadow-sm">
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
            <div class="card card-body border-0 shadow-sm">
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
            <div class="card card-body border-0 shadow-sm">
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
            <div class="card card-body border-0 shadow-sm">
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
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Fits and types</h4>
        <p>What fit shall I use and what types are popular?</p>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">@lang("tiers.".$tier) filament popularity</h5>
                <div class="graph-container h-300px">
                    {!! $chartTypes->container(); !!}
                </div>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">@lang("tiers.".$tier) survival</h5>
                <div class="graph-container h-300px">
                    {!! $chartSurvival->container(); !!}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Most popular @lang("tiers.".$tier) fits</h5>
                @component("components.fits.filter.result-list", ["results" => $popularFits])@endcomponent
            </div>
            <div class="card-footer">
                <a href="{{route("fit.search", ["TIER" => $tier])}}" target="_blank" class="btn btn-outline-secondary">Show more</a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">The Professionals</h4>
        <p>Who has completed more tier {{$tier}} runs than anyone else?</p>
    </div>
    <div class="row mt-2">
        @foreach($heroes as $hero)
            <div class="col-md-4">
                <div class="card card-body border-0 shadow-sm mb-3">
                    <div class="row">
                        <img src="https://images.evetech.net/characters/{{$hero->CHAR_ID}}/portrait?size=64"
                             class="pull-left ml-2 rounded-circle shadow-sm b2w">
                        <div class="col">
                            <h2 class="font-weight-bold mb-0"><a class="text-dark" href="{{route("profile.index", ["id" => $hero->CHAR_ID])}}">{{$hero->NAME}}</a></h2>
                            <small class="text-muted font-weight-bold">{{number_format($hero->CNT, 0, ","," ")}} @lang("tiers.".$tier) runs</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body shadow-sm border-0 text-center mb-3">
                <p class="mb-0">If you have a question you will probably get it answered in the Abyssal Lurkers discord or ingame in the <b>Abyssal Lurkers</b> channel.</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-start mt-2">
        <h4 class="font-weight-bold">Last runs and loot</h4>
        <p>What are the last tier {{$tier}} runs and what loot did they get?</p>
    </div>
    <div class="row mt-2">
        <div class="col-xs-12 col-sm-8">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Last @lang("tiers.".$tier) runs</h5>
                <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Ship name</th>
                        <th>Abyss type</th>
                        <th>Abyss tier</th>
                        <th class="text-right">Loot value</th>
                        <th class="text-right" colspan="2">Submitted</th>
                    </tr>
                    @foreach($runs as $item)
                        @component("components.runs.row-homepage", ['item' => $item]) @endcomponent
                    @endforeach
                </table>
            </div>
            <div class="card-footer">
                <a class="btn btn-outline-secondary" href="{{route("search.do", ["tier" => $tier])}}">View all @lang("tiers.".$tier) runs</a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most common @lang("tiers.".$tier) drops</h5>
                @foreach($drops as $drop)
                    <div class="d-flex justify-content-start">
                        <img src="https://imageserver.eveonline.com/Type/{{$drop->ITEM_ID}}_32.png"
                             style="width: 32px;height: 32px;" class="mr-2" alt="">
                        <div class="text-left">
                            <span class="font-weight-bold"><a
                                    href="{{route("item_single", ["item_id" => $drop->ITEM_ID])}}">{{$drop->NAME}}</a></span><br>
                            <small>{{number_format($drop->PRICE_BUY, 0, ",", " ")}} ISK
                                - {{number_format($drop->PRICE_SELL, 0, ",", " ")}} ISK</small><br>
                            <small>{{round(min(1,$drop->DROP_CHANCE)*100,2)}}% drop chance</small><br>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <a class="btn btn-outline-secondary" href="{{route("item_all")}}">View all drops</a>
            </div>
        </div>
    </div>

@endsection


@section("scripts")
    {!! $chartTypes->script(); !!}
    {!! $chartSurvival->script(); !!}
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
