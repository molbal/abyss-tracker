@extends("layout.app")
@section("browser-title", $name)
@section("content")
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm">
                <img src="https://images.evetech.net/characters/{{$id}}/portrait?size=128" class="rounded-circle shadow-sm">
                <h4 class="font-weight-bold ">{{$name}}</h4>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            @component("components.restricted", ["title" => "Last public runs","public" => $access["LAST_RUNS"], 'icon_size' => 128])
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">Public runs</h5>
                <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Ship name</th>
                        <th>Abyss type</th>
                        <th>Abyss tier</th>
                        <th class="text-right">Loot value</th>
                        <th class="text-right" colspan="2">Submitted</th>
                    </tr>
                    @forelse($last_runs as $item)
                        <tr class="action-hover-only">
                            <td>
                                {!!$item->SHIP_NAME ? ($item->IS_CRUISER ? '<img src="/overview/cruiser.png" data-toggle="tooltip" title="Cruiser run">' : '<img src="/overview/frigate.png" data-toggle="tooltip" title="Frigate run">') : '' !!}
                                {!! $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run railed, ship and capsule lost"/>' !!}
                            </td>
                            <td>
                                @if($item->SHIP_ID === null)
                                    <em class="font-italic text-black-50 ">Unknown</em>
                                @else
                                    <img src="https://imageserver.eveonline.com/Type/{{$item->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" height="24px" width="24px" alt="">&nbsp;
                                    <a class="text-dark" href="{{route("search.do", ["ship_id" => $item->SHIP_ID])}}">{{$item->SHIP_NAME}}</a>
                                @endif
                            </td>
                            <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["type" => $item->TYPE])}}">{{$item->TYPE}}</a></td>
                            <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["tier" => $item->TIER])}}">{{$item->TIER}}</a></td>
                            <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
                            <td class="text-right">{{date("H:i:s", strtotime($item->CREATED_AT))}}</td>
                            <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}"
                                                     title="Open"><img
                                        src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/view-file.png"></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6"><p class="py-4 text-center"><img src="https://img.icons8.com/cotton/32/000000/empty-box.png" style="position: relative;top:-4px"/> <em>No runs yet</em></p></td>
                        </tr>
                    @endforelse
                </table>
            </div>
            <div class="card-footer">
                {{$last_runs->links()}}
            </div>
                @endcomponent
        </div>
        <div class="col-sm-12 col-md-4">

            @component("components.restricted", ["title" => "Runs count","public" => $access["TOTAL_RUNS"]])
            <div class="card card-body shadow-sm border-0 mt-3">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/counter.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{$my_runs_count}}</h2>
                        <small class="text-muted font-weight-bold">Runs so far</small>
                    </div>
                </div>
            </div>
            @endcomponent
            @component("components.restricted", ["title" => "Loot data","public" => $access["TOTAL_LOOT"]])
            <div class="card card-body shadow-sm border-0 mt-3">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/treasure-chest.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($my_sum_loot/1000000, 0, ",", " ")}}</h2>
                        <small class="text-muted font-weight-bold">Total loot (Million ISK)</small>
                    </div>
                </div>
            </div>
            <div class="card card-body shadow-sm border-0 mt-3">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/average-2.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($my_avg_loot/1000000, 2, ".", " ")}}</h2>
                        <small class="text-muted font-weight-bold">Average loot (Million ISK)</small>
                    </div>
                </div>
            </div>
                @endcomponent
                @component("components.restricted", ["title" => "Survival ratio","public" => $access["SURVIVAL"]])
            <div class="card card-body shadow-sm border-0 mt-3">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/web-shield.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{sprintf("%1.2f", $my_survival_ratio)}}%</h2>
                        <small class="text-muted font-weight-bold">Survival ratio</small>
                    </div>
                </div>
            </div>
                @endcomponent
                @component("components.restricted", ["title" => "Most used ships","public" => $access["SHIPS"]])
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">Favorite ships</h5>
                {!! $favoriteShipsChart->container(); !!}
            </div>
                @endcomponent
        </div>
    </div>
@endsection

@section("scripts")
    {!! $favoriteShipsChart->script(); !!}
@endsection

@section("styles")
    <style type="text/css">
        #banner {
            background: url("/profile.jpg");
            background-size: cover;
            display: flex;
            height: 86px;
            border-radius: 8px;
            align-items: center;
        }

        #banner > img {
            border: 3px solid {{App\Http\Controllers\ThemeController::getThemedBorderColor()}};
            position: relative;
            top:0;
            left: 32px;
            z-index: 50;
        }

        #banner > h4 {
            color: #fff;
            text-shadow: 0 2px 0 rgba(0,0,0,0.8);
            position: relative;
            top:10px;
            left: 64px;
            text-transform: uppercase;
            font-size: 26px;
        }
    </style>
@endsection
