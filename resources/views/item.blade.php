@extends("layout.app")
@section("browser-title", $item->NAME)
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">
                <img src="https://imageserver.eveonline.com/Type/{{$item->ITEM_ID}}_64.png"> {{$item->NAME}}
                <a href="{{route("item_group", ["group_id" => $item->GROUP_ID])}}" class="btn float-right btn-outline-secondary group_link">{{$item->GROUP_NAME}}</a>
            </h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row"><img src="https://img.icons8.com/cotton/64/000000/box--v2.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($item->PRICE_SELL, 0, ",", " ")}} ISK</h2>
                        <small class="text-muted font-weight-bold">Cheapest sell order</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/cotton/64/000000/empty-box.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($item->PRICE_BUY, 0, ",", " ")}} ISK</h2>
                        <small class="text-muted font-weight-bold">Most expensive buy order</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/cotton/64/000000/percentage--v1.png" class="pull-left ml-2">
                    <div class="col">
                        <h5 class="font-weight-bold mb-0">{{round($drops["sum"]->DROPPED_COUNT_SUM/max(1,$drops["sum"]->RUNS_COUNT_SUM)*100, 2)}} %</h5>
                        <small class="text-muted font-weight-bold"> {{$drops["sum"]->DROPPED_COUNT_SUM}} / {{$drops["sum"]->RUNS_COUNT_SUM}} drop rate</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            @if(isset($drops["Dark"]))
            <div class="card card-body border-info shadow-sm">
                <h5 class="font-weight-bold">Drops rates</h5>
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        @for($t=0;$t<=6;$t++)
                        <th class="text-center"><img src="/tiers/{{$t}}.png" style="height: 16px;width: 16px;" alt=""> Tier {{$t}}</th>
                            @endfor
                    </tr>
                    </thead>
                    <tbody>
                        @foreach(['Electrical','Dark','Exotic','Firestorm','Gamma','All'] as $type)
                            <tr>
                                @if($type != "All")
                                    <td class="font-weight-bold"><img src="/types/{{$type}}.png" style="height: 32px;width: 32px;" alt=""> {{$type}}</td>
                                @else
                                    <td class="font-weight-bold"><img src="https://image.eveonline.com/Type/33011_32.png" style="height: 32px;width: 32px;" alt=""> All types</td>
                                @endif
                                @for($tier=0;$tier<=6;$tier++)
                                <td class="text-center {{($drops[$type][$tier]->RUNS_COUNT ?? 0) < 10 ? 'text-black-50' : ''}}">
                                    @if(($drops[$type][$tier]->RUNS_COUNT ?? 0) == 0)
                                        <span class="text-black-50">?</span>
                                        <br>
                                        <span class="text-small">0 / 0</span>
                                    @else
                                        <span class="estimate-confident">{{min(100,round(($drops[$type][$tier]->DROPPED_COUNT ?? 0)/($drops[$type][$tier]->RUNS_COUNT ?? 1)*100, 2))}}% </span>
                                        <br>
                                        <span class="text-small">{{min(($drops[$type][$tier]->RUNS_COUNT ?? 0), ($drops[$type][$tier]->DROPPED_COUNT ?? 0))}} / {{($drops[$type][$tier]->RUNS_COUNT ?? 1)}}</span>
                                    @endif
                                </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                @elseif(DB::table("detailed_loot")->where("ITEM_ID", $item->ITEM_ID)->exists())
                    <div class="alert alert-warning mb-3 border-0 shadow-sm">
                        <img src="https://img.icons8.com/cotton/32/000000/under-construction--v2.png"> Drop rates for this item will be calculated during the next downtime.
                    </div>
                @else
                    <div class="alert mb-3 border-danger shadow-sm">
                        @component('components.info-line')
                            Drop rates for this item will not be calculated, because this is not an item that drops from the Abyss.
                        @endcomponent
                    </div>
            @endif
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <p>
                Prices for this item were updated <strong>{{($ago_price)}}</strong> with Jita data. Drop rates are updated every 24 hours.
            </p>
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Historic data</h4>
        <p>Daily drop rates and market details</p>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm px-0 pt-0 pb-2">
                <h5 class="font-weight-bold p-3">Market history</h5>
                <div class="h-400px graph-container">{{$marketHistory->container()}}</div>
            </div>
            <div class="card-footer">
                @component("components.info-line")
                Data source: ESI &middot; Cached for up to 12 hours &middot; Data displays Forge region aggregates
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm px-0 pt-0 pb-2">
                <h5 class="font-weight-bold p-3">Drop history</h5>
                <div class="h-400px graph-container">{{$volumeHistory->container()}}</div>
            </div>
            <div class="card-footer">
                @component("components.info-line")
                    Data source: Abyss Tracker &middot; Cached for up to 12 hours
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm p-3">
                <h5 class="font-weight-bold">Item description</h5>
                <p class="text-justify mb-0">{!! $item->DESCRIPTION !!}</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card card-body border-0 shadow-sm p-3">
                <h5 class="font-weight-bold">External links</h5>
                <small class="text-uppercase font-weight-bold">Market websites</small>
                <ul class="pl-0 list-unstyled">
                    <li class="ml-0"><a href="https://www.adam4eve.eu/commodity.php?typeID={{$item->ITEM_ID}}" rel="nofollow" target="_blank">Adam4Eve</a></li>
                    <li class="ml-0"><a href="https://www.eveworkbench.com/market/sell/{{$item->ITEM_ID}}" rel="nofollow" target="_blank">Eve Workbench</a></li>
                    <li class="ml-0"><a href="https://evemarketer.com/types/{{$item->ITEM_ID}}" rel="nofollow" target="_blank">Eve Marketer</a></li>
                    <li class="ml-0"><a href="https://market.fuzzwork.co.uk/station/60003760/type/{{$item->ITEM_ID}}/" rel="nofollow" target="_blank">Fuzzwork Marketdata</a></li>
                </ul>
                <small class="text-uppercase font-weight-bold">Misc</small>
                <ul class="pl-0 list-unstyled">
                    <li class="ml-0"><a href="https://everef.net/type/{{$item->ITEM_ID}}" rel="nofollow" target="_blank">Eve ref</a></li>
                </ul>
            </div>
        </div>
    </div>


@endsection


@section("scripts")
    {{$marketHistory->script()}}
    {{$volumeHistory->script()}}
@endsection

@section("styles")
    <style>
        a.group_link {
            position: relative;
            top: 8px;
        }

        .estimate-confident {
            font-size: 1.35rem;
        }
    </style>
@endsection
