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
    @if($item->DESCRIPTION && 0)
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm">
                    <h5 class="font-weight-bold">Item description</h5>
                    <p class="text-justify mb-0">{!! $item->DESCRIPTION !!}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-sm-12">
            @if(isset($drops["Dark"]))
                <div class="alert alert-info mb-3 border-0 shadow-sm">
                    <img src="https://img.icons8.com/android/16/000000/info.png"> Where we work with less than 10 runs the data is displayed in grey instead of black. This data is refreshed once in 90 minutes, because it takes a lot of time to calculate it.
                </div>
            <div class="card card-body border-info shadow-sm">
                <h5 class="font-weight-bold">Drops rates</h5>
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        @for($t=1;$t<=5;$t++)
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
                                @for($tier=1;$tier<=5;$tier++)
                                <td class="text-center {{$drops[$type][$tier]->RUNS_COUNT < 10 ? 'text-black-50' : ''}}">
                                    @if($drops[$type][$tier]->RUNS_COUNT == 0)
                                        <span class="text-black-50">?</span>
                                        <br>
                                        <span class="text-small">0 / 0</span>
                                    @else
                                        <span class="estimate-confident">{{round($drops[$type][$tier]->DROPPED_COUNT/$drops[$type][$tier]->RUNS_COUNT*100, 2)}}% </span>
                                        <br>
                                        <span class="text-small">{{$drops[$type][$tier]->DROPPED_COUNT}} / {{$drops[$type][$tier]->RUNS_COUNT}}</span>
                                    @endif
                                </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                @else

                <div class="alert alert-warning mb-3 border-0 shadow-sm">
                    <img src="https://img.icons8.com/cotton/32/000000/under-construction--v2.png"> Drop rates for this item will be calculated during the next downtime.
                </div>
            @endif
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <p>
                Prices for this item were updated <strong>{{($ago_price)}}</strong> with Jita data. Drop rates were last updated <strong>{{$ago_drop}}</strong> with data from the run loot data. Every run submission triggers a price update for its loot items older than 24 hours. Drop rates are updated every day around downtime.
            </p>
        </div>
    </div>

@endsection


@section("scripts")
    <script type="text/javascript">
    </script>
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
