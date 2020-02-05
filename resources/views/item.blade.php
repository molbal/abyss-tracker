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
                    <img src="https://img.icons8.com/dotty/64/000000/time.png" class="pull-left ml-2">
                    <div class="col">
                        <h5 class="font-weight-bold mb-0">{{$item->PRICE_LAST_UPDATED}}</h5>
                        <small class="text-muted font-weight-bold">Price updated</small>
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
{{--    <div class="row mt-3">--}}
{{--        <div class="col-sm-12">--}}
{{--            <div class="alert alert-info mb-3 border-0 shadow-sm">--}}
{{--                <img src="https://img.icons8.com/android/16/000000/info.png"> Where we work with less than 10 runs the data is displayed in grey instead of black. This data is refreshed once in 90 minutes, because it takes a lot of time to calculate it.--}}
{{--            </div>--}}
{{--            <div class="card card-body border-info shadow-sm">--}}
{{--                <h5 class="font-weight-bold">Drops {{round($drop_rate/$max_runs*100, 2)}}% of the time ({{$drop_rate}} out of {{$max_runs}})</h5>--}}
{{--                <table class="table table-sm table-striped">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>&nbsp;</th>--}}
{{--                        @for($t=1;$t<=5;$t++)--}}
{{--                        <th class="text-center"><img src="/tiers/{{$t}}.png" style="height: 16px;width: 16px;" alt=""> Tier {{$t}}</th>--}}
{{--                            @endfor--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        @for($i=0;$i<5;$i++)--}}
{{--                            <tr>--}}
{{--                                <td class="font-weight-bold"><img src="/types/{{$drops->get($i*5)->TYPE}}.png" style="height: 32px;width: 32px;" alt=""> {{$drops->get($i*5)->TYPE}}</td>--}}
{{--                                @for($j=0;$j<5;$j++)--}}
{{--                                <td class="text-center {{$drops->get($i*5+$j)->MAX_RUNS < 10 ? 'text-black-50' : ''}}">--}}
{{--                                    @if($drops->get($i*5+$j)->MAX_RUNS == 0)--}}
{{--                                        <span class="text-black-50">?</span>--}}
{{--                                        <br>--}}
{{--                                        <span class="text-small">0 / 0</span>--}}
{{--                                        @else--}}
{{--                                        <span class="estimate-confident">{{round($drops->get($i*5+$j)->DROP_RATE/$drops->get($i*5+$j)->MAX_RUNS*100, 2)}}% </span>--}}
{{--                                        <br>--}}
{{--                                        <span class="text-small">{{$drops->get($i*5+$j)->DROP_RATE}} / {{$drops->get($i*5+$j)->MAX_RUNS}}</span>--}}
{{--                                    @endif--}}
{{--                                </td>--}}
{{--                                @endfor--}}
{{--                            </tr>--}}
{{--                        @endfor--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

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
