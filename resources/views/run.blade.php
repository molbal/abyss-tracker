@extends("layout.app")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold">Recorded abyssal run by {!! $run->PUBLIC ? $run->NAME : "<em>Anonymus</em>" !!}
            - {{$run->RUN_DATE}}</h4>
    </div>
    <div class="row">
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
                        src="https://img.icons8.com/small/16/000000/info.png" data-toggle="tooltip"
                        title="Jita prices were used to calculate loot value"></h5>
                @if(count($loot_table) > 0)
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
                                    <td class="text-center font-italic" colspan="4">We currently can't estimate blueprint values</td>
                                @else
                                    <td class="text-right">{{number_format($loot_item->PRICE_SELL, 0, ",", " ")}}ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->PRICE_BUY, 0, ",", " ")}}ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->SELL_PRICE_ALL, 0, ",", " ")}}
                                        ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->BUY_PRICE_ALL, 0, ",", " ")}}
                                        ISK
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
{{--    @if($run->)--}}
        <div class="row mt-3">

        </div>
        <div class="row mt-3">
            <div class="col-md-6 col-sm-12">
                <div class="card card-body border-0 shadow-sm">
                    <h4 class="font-weight-bold">Survival of {{$run->TYPE}} tier {{$run->TIER}}</h4>
                    {!! $survival->container(); !!}
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card card-body border-0 shadow-sm">
                    <h4 class="font-weight-bold">Loot value comparision</h4>
                    {!! $other->container(); !!}
                </div>
            </div>
        </div>

@endsection

@section("scripts")
    {!! $survival->script(); !!}
    {!! $other->script(); !!}
@endsection
