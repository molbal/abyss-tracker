@extends("layout.app")
@section("browser-title", "Run #".$run->ID." details")
@section("content")
        <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
            <h4 class="font-weight-bold">Showing the details of <span data-toggle="tooltip" title="Loot value compared to average loot of this tier: {{round($percent)}}%">{{$run_summary}}</span> Abyssal run</h4>
            <p class="text-right font-italic text-sm mb-0 pb-0">
                Saved at: {{$run->CREATED_AT ?? $run->RUN_DATE}}
            </p>
        </div>
        <div class="row">

            <div class="col-md-4 col-sm-6">
                <div class="card card-body shadow-sm border-0">
                    <div class="row">
                        @if($run->PUBLIC)
                            <img src="https://images.evetech.net/characters/{{$run->CHAR_ID}}/portrait?size=64"
                                 class="pull-left ml-2 rounded-circle shadow-sm">
                        @else
                            <img src="https://images.evetech.net/characters/1/portrait?size=64"
                                 class="pull-left ml-2 rounded-circle shadow-sm">
                        @endif
                        <div class="col">
                            <h2 class="font-weight-bold mb-0">{{$run->PUBLIC ? $run->NAME : "Private"}}</h2>
                            <small class="text-muted font-weight-bold">Abyss runner</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card card-body shadow-sm border-0">
                    <div class="row">
                        @if($all_data->SHIP_ID)
                            <img src="https://images.evetech.net/types/{{$all_data->SHIP_ID}}/render?size=64"
                                 class="pull-left ml-2 rounded-circle shadow-sm">
                        @else
                            <img src="https://imageserver.eveonline.com/Type/34436_64.png"
                                 class="pull-left ml-2 rounded-circle shadow-sm">
                        @endif
                        <div class="col">
                            <h2 class="font-weight-bold mb-0">{{$run->SHIP_NAME ?? "Unknown"}}</h2>
                            <small class="text-muted font-weight-bold">Ship type</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card card-body shadow-sm border-0">
                    <div class="row">
                        <img src="https://image.eveonline.com/Type/434_64.png" class="pull-left ml-2 rounded-circle">
                        <div class="col"><h2 class="font-weight-bold mb-0">
                            @if($all_data->RUNTIME_SECONDS == 0)
                                <span class="">Unknown</span>
                                @else
                                    {{sprintf("%02d", $all_data->RUNTIME_SECONDS/60)}}:{{sprintf("%02d", $all_data->RUNTIME_SECONDS%60)}}
                            @endif</h2>
                            <small class="text-muted font-weight-bold">Run duration</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row mt-3">
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="types/{{$run->TYPE}}.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{$run->TYPE}}</h2>
                        <small class="text-muted font-weight-bold">Filament type</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="tiers/{{$run->TIER}}.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">Tier {{$run->TIER}}</h2>
                        <small class="text-muted font-weight-bold">Deadspace tier</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://imageserver.eveonline.com/Type/30768_64.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($run->LOOT_ISK/1000000,2,","," ")}}</h2>
                        <small class="text-muted font-weight-bold">Run loot (Million ISK)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://image.eveonline.com/Type/{{!$run->SURVIVED ? "37885" : "34432"}}_64.png"
                         class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0 {{!$run->SURVIVED ? "text-danger" : ""}}">{{$run->SURVIVED ? "Survived" : "Exploded"}}</h2>
                        <small class="text-muted font-weight-bold">Survival</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Exact loot &nbsp;<img
                        src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png" data-toggle="tooltip"
                        title="Jita prices were used to calculate loot value">
                    <small class="float-right">{{$loot_type}}</small>
                </h5>
                @if(count($loot_table) > 0)
                    <table class="table table-hover table-sm table-responsive-sm">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Name</th>
                            <th class="text-right">Count</th>
                            <th class="text-right">Sell price/piece</th>
                            <th class="text-right">Buy price/piece</th>
                            <th class="text-right">Sell price/all</th>
                            <th class="text-right">Buy price/all</th>
                            <th class="text-right">Drop rate</th>
                        </tr>
                        @foreach($loot_table as $loot_item)
                            <tr>
                                <td><img src="https://imageserver.eveonline.com/Type/{{$loot_item->ITEM_ID}}_32.png"
                                         alt=""></td>
                                <td>
                                    <a data-toggle="tooltip" title="{{$loot_item->GROUP_NAME}}"
                                       href="{{route('item_single', ["item_id" => $loot_item->ITEM_ID])}}">
                                        {{$loot_item->NAME}}
                                    </a>
                                </td>
                                <td class="text-right">{{$loot_item->COUNT}}</td>
                                @if(stripos($loot_item->NAME, "Blueprint") !== false)
                                    <td class="text-center font-italic" colspan="4">We currently can't estimate
                                        blueprint values
                                    </td>
                                    <td class="text-right" data-toggle="tooltip" title="{{$loot_item->TOOLTIP}}">{{number_format($loot_item->DROP_PERCENT*100, 1, ",", " ")}}&nbsp;%
                                    </td>
                                @else
                                    <td class="text-right">{{number_format($loot_item->PRICE_SELL, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->PRICE_BUY, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->SELL_PRICE_ALL, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->BUY_PRICE_ALL, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right" data-toggle="tooltip" title="{{$loot_item->TOOLTIP}}">{{number_format($loot_item->DROP_PERCENT*100, 1, ",", " ")}}&nbsp;%
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                @elseif($run->LOOT_ISK)
                    <p class="m-5 text-center font-italic">Unfortunately we do not have information about exact
                        loot.</p>
                @else
                    <p class="m-5 text-center font-italic">Unfortunately no loot could be gathered from this run.</p>
                @endif
            </div>
        </div>
    </div>

    @if(count($lost_table) > 0)
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card card-body border-0 shadow-sm">
                    <h5 class="font-weight-bold">Items consumed or lost &nbsp;<img
                            src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png" data-toggle="tooltip"
                            title="Jita prices were used to calculate loot value">
                    </h5>
                    <table class="table table-hover table-sm">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Name</th>
                            <th class="text-right">Count</th>
                            <th class="text-right">Sell price/piece</th>
                            <th class="text-right">Buy price/piece</th>
                            <th class="text-right">Sell price/all</th>
                            <th class="text-right">Buy price/all</th>
                        </tr>
                        @foreach($lost_table as $loot_item)
                            <tr>
                                <td><img src="https://imageserver.eveonline.com/Type/{{$loot_item->ITEM_ID}}_32.png"
                                         alt=""></td>
                                <td>
                                    <a data-toggle="tooltip" title="{{$loot_item->GROUP_NAME}}"
                                       href="{{route('item_single', ["item_id" => $loot_item->ITEM_ID])}}">
                                        {{$loot_item->NAME}}
                                    </a>
                                </td>
                                <td class="text-right">{{$loot_item->COUNT}}</td>
                                @if(stripos($loot_item->NAME, "Blueprint") !== false)
                                    <td class="text-center font-italic" colspan="4">We currently can't estimate
                                        blueprint values (How did you lose one in the abyss???)
                                    </td>
                                    <td class="text-right" data-toggle="tooltip" title="{{$loot_item->TOOLTIP}}">{{number_format($loot_item->DROP_PERCENT*100, 1, ",", " ")}}&nbsp;%
                                    </td>
                                @else
                                    <td class="text-right">{{number_format($loot_item->PRICE_SELL, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->PRICE_BUY, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->SELL_PRICE_ALL, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->BUY_PRICE_ALL, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if(!$run->SURVIVED && $all_data->DEATH_REASON)
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Death details</h5>
                <p class=" mb-0">{{$death_reason}}
                @if($all_data->KILLMAIL)<br><a target="_blank" class="btn btn-outline-secondary mt-2" href="{{$all_data->KILLMAIL}}">Lossmail on zKillboard</a>@endif
                </p>
            </div>
        </div>
    </div>
    @endif
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="font-weight-bold">Average loot values</h4>
                {!! $other->container(); !!}
            </div>
        </div>
    </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="btn-group">
                    <a href="{{route("filtered_list", [
        "tier" => $all_data->TIER,
        "type" => $all_data->TYPE
        ])}}" class="btn btn-outline-secondary">Show all Tier {{$all_data->TIER}} {{$all_data->TYPE}} runs ({{$count_same_type_tier}})</a>
                    @if($all_data->SHIP_ID)
                        <a href="{{route("ship_single", [
        "id" => $count_same_ship
        ])}}" class="btn btn-outline-secondary">Show all runs with {{$run->SHIP_NAME}} ({{$count_same_ship}})</a>
                    @endif
                </div>
            </div>
        </div>
@endsection

@section("scripts")
    {!! $other->script(); !!}
@endsection
