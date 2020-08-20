@extends("layout.app")
@section("browser-title", "Home")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Welcome to Veetor's Abyss Loot Tracker</h4>
        <p>Home of {{$abyss_num}} saved runs ({{$today_num}} new today)</p>
    </div>

    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card card-body border-0 shadow-sm p-0">
                <img src="{{asset('home/news.jpg')}}" alt="News" class="w-100 rounded-top">
                <div class="p-3">
                    <a href="#" class="font-weight-bold h4 text-white">News</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="card card-body border-0 shadow-sm p-0">
                    <img src="{{asset('home/alliance-open.jpg')}}" alt="News" class="w-100 rounded-top">
                    <div class="p-3">
                        <a href="#" class="font-weight-bold h4 text-white">Alliance <strike>Tournament</strike> Open</a>
                    </div>
                </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card card-body border-0 shadow-sm">
                Last donations
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 10 (last 90 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Runs</th>
                    </tr>
                    @forelse($leaderboard_90 as $l)
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
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 10 (last 30 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Runs</th>
                    </tr>
                    @forelse($leaderboard_30 as $l)
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
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 10 (last 7 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Runs</th>
                    </tr>
                    @forelse($leaderboard_07 as $l)
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

    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-head-distribution" data-toggle="tab" href="#tab-distribution" role="tab" aria-controls="home" aria-selected="true">Cruiser loot distribution</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-head-distribution-frig" data-toggle="tab" href="#tab-distribution-frig" role="tab" aria-controls="home" aria-selected="true">Frigate loot distribution</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-head-activity" data-toggle="tab" href="#tab-activity" role="tab" aria-controls="profile" aria-selected="false">Abyss activity</a>
                </li>
            </ul>
            <div class="card card-body border-0 shadow-sm top-left-no-round">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-distribution" role="tabpanel" aria-labelledby="tab-head-distribution">
                        <div class="graph-container h-400px">
                            {!! $lootDistributionCruiser->container(); !!}
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="tab-distribution-frig" role="tabpanel" aria-labelledby="tab-head-distribution-frig">
                        <div class="graph-container h-400px">
                            {!! $lootDistributionFrigate->container(); !!}
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
                        <th class="text-right" colspan="2">Submitted</th>
                    </tr>
                    @foreach($items as $item)
                        @component("components.runs.row-homepage", ['item' => $item]) @endcomponent
                    @endforeach
                </table>
            </div>
            <div class="card-footer">
                <a class="btn btn-outline-secondary" href="{{route("runs")}}">View all runs</a>
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
    <div class="row mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">All recorded filament types</h5>
                <div class="graph-container h-400px">
                    {!! $loot_types_chart->container(); !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">All recorded tier levels</h5>
                <div class="graph-container h-400px">
                    {!! $tier_levels_chart->container(); !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Survival rate of recorded runs</h5>
                <div class="graph-container h-400px">
                    {!! $survival_chart->container(); !!}
                </div>
            </div>
        </div>
    </div>
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

@endsection

@section("scripts")
    {!! $loot_types_chart->script(); !!}
    {!! $tier_levels_chart->script(); !!}
    {!! $survival_chart->script(); !!}
    {!! $lootDistributionCruiser->script(); !!}
    {!! $lootDistributionFrigate->script(); !!}
    {!! $daily_add_chart->script(); !!}
    <script type="text/javascript">

        $('#tab-head-distribution').on('shown.bs.tab', function (e) {window.{{$lootDistributionCruiser->id}}.resize();});
        $('#tab-head-distribution-frig').on('shown.bs.tab', function (e) {window.{{$lootDistributionFrigate->id}}.resize();});
        $('#tab-head-activity').on('shown.bs.tab', function (e) {window.{{$daily_add_chart->id}}.resize();});
    </script>
@endsection
