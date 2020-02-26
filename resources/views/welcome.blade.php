@extends("layout.app")
@section("browser-title", "Home")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Welcome to Veetor's Abyss Loot Tracker</h4>
        <p>Home of {{$abyss_num}} saved runs ({{$today_num}} new today)</p>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card card-body border-info shadow-sm">
                <p class="m-0 p-0 text-left">
                    Please tell me what to improve on this application by <a target="_blank" href="https://t.co/vgpdmRXk9U">filling this short survey</a>
                </p>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Average loot per tier</h5>
                {!! $loot_tier_chart->container(); !!}
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Abyss activity</h5>
                {!! $daily_add_chart->container(); !!}
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
                        <tr class="action-hover-only">
                            <td>
                                {!!$item->SHIP_NAME ? ($item->IS_CRUISER ? '<img src="/overview/cruiser.png" data-toggle="tooltip" title="Cruiser run">' : '<img src="/overview/frigate.png" data-toggle="tooltip" title="Frigate run">') : '' !!}
                                {!! $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run railed, ship and capsule lost"/>' !!}
                            </td>
                            <td>{!! $item->SHIP_NAME ?? '<em class="text-black-50">Unknown</em>' !!}</td>
                            <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;"
                                     alt=""> {{$item->TYPE}}</td>
                            <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;"
                                     alt=""> {{$item->TIER}}</td>
                            <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
                            <td class="text-right">{{date("H:i:s", strtotime($item->CREATED_AT))}}</td>
                            <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}"
                                                     title="Open"><img
                                        src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/view-file.png"></a>
                            </td>
                        </tr>
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
                            <small>{{round($drop->DROP_CHANCE*100,2)}}% drop chance</small><br>
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
                {!! $loot_types_chart->container(); !!}
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">All recorded tier levels</h5>
                {!! $tier_levels_chart->container(); !!}
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Survival rate of recorded runs</h5>
                {!! $survival_chart->container(); !!}
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
    {!! $loot_tier_chart->script(); !!}
    {!! $daily_add_chart->script(); !!}
    <script type="text/javascript">
    </script>
@endsection
