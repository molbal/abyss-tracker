@extends("layout.app")
@section("browser-title", "Home")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Welcome to Veetor's Abyss Loot Tracker</h4>
        <p>Home of {{$abyss_num}} saved runs ({{$today_num}} new today)</p>
    </div>


    <div class="row mt-3">

        <div class="col-sm-12">
            <div class="card card-body
            shadow-sm p-3 pb-0 mb-3 border-danger">
                <p class="text-center mb-0">The Abyss Tracker is experiencing technical difficulties at the moment. The following functions may now work properly at the moment:
                Run deletion, Drop rate display, Median calculation.</p>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-8 row">


            {{--        NEWS START --}}
            <div class="col-xs-12 col-md-6">
                <div class="card card-body border-0 shadow-sm p-0 mb-3">
                    <img src="{{asset("home/1.6.0b.jpg")}}" alt="1.5.5 released" class="w-100 rounded-top shadow-sm" style="min-height: 170px;">
                    <div class="p-3 text-center">
                        <a href="{{route('changelog')}}" class="font-weight-bold h5 text-dark">Abyss Tracker updated to 1.6 <sup>beta</sup></a>
                        <p class="mb-0">See changes and new features</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="card card-body border-0 shadow-sm p-0 mb-3">
                    <img src="{{asset('home/alliance-open.jpg')}}" alt="Alliance Open" class="w-100 rounded-top shadow-sm" style="min-height: 170px;">
                    <div class="p-3 text-center">
                        <a href="https://open.eve-nt.uk" target="_blank" class="font-weight-bold h5 text-dark">EVE-NT Alliance Open</a>
                        <p class="mb-0">We made our own Alliance Tournament with 200000+ PLEX in the prizes</p>
                    </div>
                </div>
            </div>
            {{--        NEWS END--}}


            {{--        LOOT GRAPH STARTS--}}

            <div class="col-md-12 col-sm-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-head-distribution" data-toggle="tab" href="#tab-distribution" role="tab" aria-controls="home" aria-selected="true">Loot values</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-head-activity" data-toggle="tab" href="#tab-activity" role="tab" aria-controls="profile" aria-selected="false">Abyss activity (daily)</a>
                    </li>
                </ul>
                <div class="card card-body border-0 shadow-sm top-left-no-round">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-distribution" role="tabpanel" aria-labelledby="tab-head-distribution">
                            <div class="graph-container h-400px">
                                {!! $lootDistributionCruiser->container(); !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-activity" role="tabpanel" aria-labelledby="tab-head-activity">
                            <div class="graph-container h-400px">
                                {!! $daily_add_chart->container(); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--        LOOT GRAPH ENDS--}}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <img src="https://images.evetech.net/characters/{{$ingame_last->CHAR_ID}}/portrait?size=128"  class="portrait rounded-circle shadow-sm" alt="">
                    <p class="h5 font-weight-bold mb-0 mt-2">{{$ingame_last->NAME}}</p>
                    <span style="font-size: 0.7rem" class="text-uppercase">Donated {{number_format($ingame_last->AMOUNT, 0, ",", " ")}} ISK {{\App\Http\Controllers\TimeHelper::timeElapsedString($ingame_last->DATE)}}</span>
                    @if (trim($ingame_last->REASON) != "")
                        <blockquote class="donation">&bdquo;{{$ingame_last->REASON}}&ldquo;</blockquote>
                    @endif
                </div>
            </div>
            <div class="card-footer shadow-sm">
                <a href="{{route("donors.index")}}" class="text-dark" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/receive-cash.png">Donate ingame</a>
            </div>

            <div class="mt-3 card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <span>Last Patreon donor</span>
                    <p class="h4 font-weight-bold mb-0">{{$patreon_last->name}} ({{$patreon_last->monthly_donation}} €/m)</p>
                    <span style="font-size: 0.7rem" class="text-uppercase">joined {{\App\Http\Controllers\TimeHelper::timeElapsedString($patreon_last->joined)}}</span>
                </div>
            </div>
            <div class="card-footer shadow-sm">
                <a href="https://patreon.com/veetor" class="text-dark" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/patreon.png">Support us on Patreon</a>
            </div>


            <div class="mt-3 card card-body border-0 shadow-sm text-center">
                <h4 class="font-weight-bold"><img class="smallicon bringupper mr-1" src="https://img.icons8.com/small/32/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/info.png"/> Overview pages</h4>
{{--                <img src="{{asset("home/infopage.jpg")}}" alt="Information pages" class="w-100 shadow-sm rounded-top mb-2">--}}
                <table class="ml-auto mr-auto">
                @for($i = 1; $i <=5; $i++)
                    <tr cellpadding="1">
                        <td><a href="{{route('infopage.tier',['tier' => $i])}}" class="text-dark"><img class="smallicon" src="{{asset("tiers/{$i}.png")}}" alt=""></a></td>
                        <td class="text-left"><a href="{{route('infopage.tier',['tier' => $i])}}" class="text-dark">@lang('tiers.'.$i) difficulty overview</a></td>
                    </tr>
                @endfor
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Active contributors</h4>
        <a class="text-dark"
           href="{{route("leaderboard.index")}}">
            <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())}}/trophy.png" class="tinyicon bringupper mr-1">Leaderboard</a>
    </div>
    <div class="row mt-4">
        <div class="col-md-4 col-sm-12">
            <div class="d-flex justify-content-between">
                <h5 class="font-weight-bold mb-2">Top 10</h5>
                <small>(last 90 days)</small>
            </div>
            <div class="card card-body border-0 shadow-sm leaderboard">
                @if(count($leaderboard_90)>0)
                    @component("components.leaderboard_top", ['item' => $leaderboard_90[0]])@endcomponent
                @endif
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    @forelse($leaderboard_90 as $i => $l)
                        @if ($i ==0) @continue @endif
                        @component("components.leaderboard_char", ['item' => $l]) @endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="d-flex justify-content-between">
                <h5 class="font-weight-bold mb-2">Top 10</h5>
                <small>(last 30 days)</small>
            </div>
            <div class="card card-body border-0 shadow-sm leaderboard">
                @if(count($leaderboard_30)>0)
                    @component("components.leaderboard_top", ['item' => $leaderboard_30[0]])@endcomponent
                @endif
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    @forelse($leaderboard_30 as  $i => $l)
                        @if ($i ==0) @continue @endif
                        @component("components.leaderboard_char", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="d-flex justify-content-between">
                <h5 class="font-weight-bold mb-2">Top 10</h5>
                <small>(last 7 days)</small>
            </div>
            <div class="card card-body border-0 shadow-sm leaderboard">
                @if(count($leaderboard_07)>0)
                    @component("components.leaderboard_top", ['item' => $leaderboard_07[0]])@endcomponent
                @endif
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    @forelse($leaderboard_07 as $i => $l)
                        @if ($i ==0) @continue @endif
                        @component("components.leaderboard_char", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
    </div>







    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Ship fits for the Abyss</h4>
        <a class="text-dark"
           href="{{route("fit.index")}}">
            <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())}}/job.png" class="tinyicon bringupper mr-1">All fits</a>
    </div>

<div class="row mt-3">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="card card-body border-0 shadow-sm">
            <h5 class="font-weight-bold mb-2">Most popular hulls</h5>
            <div class="graph-container h-300px">
                {!! $popularShipsGraph->container(); !!}
            </div>
        </div>
        <div class="card card-body border-0 shadow-sm mt-3">
            <h5 class="font-weight-bold mb-2">Most popular classes</h5>
            <div class="graph-container h-300px">
                {!! $popularClassesGraph->container(); !!}
            </div>
        </div>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
        <ul class="nav nav-tabs" id="fits-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab-head-fits-popular" data-toggle="tab" href="#tab-fits-popular" role="tab" aria-controls="home" aria-selected="true">Most popular fits</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab-head-fits-new" data-toggle="tab" href="#tab-fits-new" role="tab" aria-controls="profile" aria-selected="false">Newest fits</a>
            </li>
        </ul>
        <div class="card card-body border-0 shadow-sm top-left-no-round">
            <div class="tab-content" id="fits-tab-content">
                <div class="tab-pane fade show active" id="tab-fits-popular" role="tabpanel" aria-labelledby="tab-head-distribution">
                    @component("components.fits.filter.result-list", ["results" => $popularFits])@endcomponent
                    <div class="">
                        <a class="text-dark" href="{{route("fit.search", ['ORDER_BY' => 'RUNS_COUNT', 'DIRECTION' => 'DESC'])}}"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/job.png">View more popular fits</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-fits-new" role="tabpanel" aria-labelledby="tab-head-activity">
                    @component("components.fits.filter.result-list", ["results" => $newFits])@endcomponent
                    <div class="">
                        <a class="text-dark" href="{{route("fit.search", ['ORDER_BY' => 'Submitted', 'ORDER_BY_ORDER' => 'ASC'])}}"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/job.png">View more new fits</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Last added submissions</h4>
        <a class="text-dark"
           href="{{route("runs")}}">
            <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())}}/database.png" class="tinyicon bringupper mr-1">All runs</a>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-8">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Last submitted runs</h5>
                <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Ship name</th>
                        <th>Abyss type</th>
                        <th>Abyss tier</th>
                        <th class="text-right">Loot value</th>
                        <th class="text-right" colspan="2">Duration</th>
                    </tr>
                    @foreach($items as $item)
                        @component("components.runs.row-homepage", ['item' => $item]) @endcomponent
                    @endforeach
                </table>
            </div>
            <div class="card-footer">
                <a class="text-dark" href="{{route("runs")}}"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())}}/database.png">View all runs</a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most frequent drops</h5>
                @foreach($drops as $drop)
                    <div class="d-flex justify-content-start">
                        <img src="https://imageserver.eveonline.com/Type/{{$drop->ITEM_ID}}_32.png"
                             style="width: 32px;height: 32px;" class="mr-2" alt="">
                        <div class="text-left">
                            <span class="font-weight-bold"><a class="text-dark"
                                    href="{{route("item_single", ["item_id" => $drop->ITEM_ID])}}">{{$drop->NAME}}</a></span><br>
                            <small>{{number_format($drop->PRICE_BUY, 0, ",", " ")}} ISK
                                - {{number_format($drop->PRICE_SELL, 0, ",", " ")}} ISK</small><br>
                            <small>{{round(min(1,$drop->DROP_CHANCE)*100,2)}}% drop chance</small><br>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <a class="text-dark" href="{{route("item_all")}}"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/empty-box.png">View drop table</a>
            </div>
        </div>
    </div>
{{--    <div class="row mt-3">--}}
{{--        <div class="col-md-4 col-sm-12">--}}
{{--            <div class="card card-body border-0 shadow-sm">--}}
{{--                <h5 class="font-weight-bold mb-2">All recorded filament types</h5>--}}
{{--                <div class="graph-container h-400px">--}}
{{--                    {!! $loot_types_chart->container(); !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 col-sm-12">--}}
{{--            <div class="card card-body border-0 shadow-sm">--}}
{{--                <h5 class="font-weight-bold mb-2">All recorded tier levels</h5>--}}
{{--                <div class="graph-container h-400px">--}}
{{--                    {!! $tier_levels_chart->container(); !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 col-sm-12">--}}
{{--            <div class="card card-body border-0 shadow-sm">--}}
{{--                <h5 class="font-weight-bold mb-2">Survival rate of recorded runs</h5>--}}
{{--                <div class="graph-container h-400px">--}}
{{--                    {!! $survival_chart->container(); !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row">
        <div class="col-md-12 col-sm-12 mt-3">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">What is this site?</h5>
                <p class="text-justify">Welcome,<br>
                    This is a website to track and compare your Abyss runs, how much your loot is worth, and what kind of
                    filaments are popular.
                    <br>
                    If you also add your Abyssal deadspace runs we will have a better idea on how much loot spawns in
                    Abyssal sites (which is really hectic).</p>
                <p>Cheers, <br>
                    <img src="https://images.evetech.net/characters/93940047/portrait?size=32" alt=""
                         class="rounded-circle shadow-sm"> Veetor Nara
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@section("styles")
    <style>

    </style>
    @endsection

@section("scripts")
{{--    {!! $loot_types_chart->script(); !!}--}}
    {!! $popularShipsGraph->script(); !!}
    {!! $popularClassesGraph->script(); !!}
{{--    {!! $survival_chart->script(); !!}--}}
    {!! $lootDistributionCruiser->script(); !!}
    {!! $daily_add_chart->script(); !!}
    <script type="text/javascript">

        $('#tab-head-distribution').on('shown.bs.tab', function (e) {window.{{$lootDistributionCruiser->id}}.resize();});
        $('#tab-head-activity').on('shown.bs.tab', function (e) {window.{{$daily_add_chart->id}}.resize();});
    </script>
@endsection
