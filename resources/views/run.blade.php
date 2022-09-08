@extends("layout.app")
@section("browser-title", "Run #".$run->ID." details")
@section("content")

    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h4 class="font-weight-bold">Showing the details of <span data-toggle="tooltip"
                                                                  title="Loot value compared to median loot of this tier with the same ship size: {{round($percent)}}%">{{$run_summary}}</span>
            Abyssal run</h4>
        <p class="text-right font-italic text-sm mb-0 pb-0">
            Saved <span data-toggle="tooltip"
                        title="Exact date and time (EVE time): {{$run->CREATED_AT ?? $run->RUN_DATE}}"
                        style="border: 1px dashed #{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}; border-width: 0 0 1px 0">{{\App\Http\Controllers\TimeHelper::timeElapsedString($run->CREATED_AT ?? $run->RUN_DATE)}}</span>
        </p>
    </div>

    @if (!$run->SURVIVED)
        <div class="row my-3">
            <div class="col-md-12">
                <div class="card card-body border-danger shadow-sm text-center p-0">
                    <div class="d-flex justify-content-start m-2">
                        <img src="https://image.eveonline.com/Type/{{!$run->SURVIVED ? "37885" : "34432"}}_64.png"
                             class="" style="width: 48px; height: 48px">
                        <span class="mb-0 h6 text-danger my-2 py-0" style="position: relative;top: 7px">This is a failed run - the ship and the capsule was lost.</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">

        @if(isset($errors))
            @if ($errors->any())
                <div class="col-sm-12">

                    <div class="alert alert-danger border-0 shadow-sm d-flex justify-content-between">
                        <img src="https://img.icons8.com/cotton/64/000000/cancel-2--v1.png">
                        <div style="width: 100%">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    @if($run->PUBLIC)
                        <img src="https://images.evetech.net/characters/{{$run->CHAR_ID}}/portrait?size=64"
                             class="pull-left ml-2 rounded-circle shadow-sm b2w">
                    @else
                        <img src="https://images.evetech.net/characters/1/portrait?size=64"
                             class="pull-left ml-2 rounded-circle shadow-sm b2w">
                    @endif
                    <div class="col">

                        @if($run->PUBLIC)
                            <h2 class="font-weight-bold mb-0"><a class="text-dark"
                                                                 href="{{route('profile.index', ['id' => $run->CHAR_ID])}}">{{$run->NAME}}</a>
                            </h2>
                        @else
                            <h2 class="font-weight-bold mb-0">Private</h2>
                        @endif
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
                             class="pull-left ml-2 rounded-circle shadow-sm b2w">
                    @else
                        <img src="https://imageserver.eveonline.com/Type/34436_64.png"
                             class="pull-left ml-2 rounded-circle shadow-sm b2w">
                    @endif
                    <div class="col">
                        @if($all_data->SHIP_ID)
                            <h2 class="font-weight-bold mb-0"><a class="text-dark"
                                                                 href="{{route("ship_single", ["id" => $all_data->SHIP_ID])}}">{{$run->SHIP_NAME}}</a>
                            </h2>
                        @else
                            <h2 class="font-weight-bold mb-0">Unknown</h2>
                        @endif
                        <small class="text-muted font-weight-bold">Ship type</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    @if ($fit_privacy == "private")
                        <img src="/_icons/search-icons/cloak.png" class="pull-left ml-2 rounded-circle">
                    @else
                        <img src="/_icons/search-icons/ship.png" class="pull-left ml-2 rounded-circle">
                    @endif
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">
                            @if ($fit_privacy == "private")
                                <h2 class="mb-0">Private fit</h2>
                            @else
                                @if($all_data->FIT_ID)
                                    <h2 class="mb-0"><a href="{{route("fit_single", ["id" => $all_data->FIT_ID])}}"
                                                        class="text-dark">{{$fit_name}}</a></h2>
                                @else
                                    <h2 class="mb-0">Unknown fit</h2>
                                @endif
                            @endif
                            <small class="text-muted font-weight-bold">Fit name</small>
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
                        <h2 class="font-weight-bold mb-0"><a class="text-dark"
                                                             href="{{route("search.do", ["type" => $run->TYPE])}}">{{$run->TYPE}}</a>
                        </h2>
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
                        <h2 class="font-weight-bold mb-0"><a class="text-dark"
                                                             href="{{route("search.do", ["tier" => $run->TIER])}}">Tier {{$run->TIER}}</a>
                        </h2>
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
                    <img src="https://image.eveonline.com/Type/434_64.png" class="pull-left ml-2 rounded-circle">
                    <div class="col"><h2 class="font-weight-bold mb-0">
                            @if($all_data->RUNTIME_SECONDS == 0)
                                <span class="">Unknown</span>
                            @else
                                {{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($all_data->RUNTIME_SECONDS)}}
                            @endif</h2>
                        <small class="text-muted font-weight-bold">Run duration</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($all_data->IS_BONUS && $all_data->TIER == 5)
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card card-body border-0 shadow-sm text-center">
                    This run got the bonus room where there is only one room in the deadspace (full of Leshaks) and the
                    origin gate is open by default.
                </div>
            </div>
        </div>
    @endif


    @php
        $all_sell = 0;
        $all_buy = 0;
$lost_sell = 0;
$lost_buy = 0;
    @endphp

    <x-section-head>Loot info</x-section-head>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-body border-0 shadow-sm">
                <table class="table table-hover table-sm table-responsive-sm">
                    <tr>
                        <td colspan="8">
                            <h5 class="font-weight-bold">Items looted
                                <x-info-toggle>Jita prices were used to calculate the loot.</x-info-toggle>
                                <small class="float-right">{{$loot_type}}</small>
                            </h5>
                        </td>
                    </tr>
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
                    @if(count($loot_table) > 0)
                        @foreach($loot_table as $loot_item)
                            @php
                                $all_sell += $loot_item->SELL_PRICE_ALL;
                                $all_buy += $loot_item->BUY_PRICE_ALL;
                            @endphp
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
                                    <td class="text-right" data-toggle="tooltip"
                                        title="{{$loot_item->TOOLTIP}}">{{number_format($loot_item->DROP_PERCENT*100, 2, ",", " ")}}
                                        &nbsp;%
                                    </td>
                                @else
                                    <td class="text-right">{{number_format($loot_item->PRICE_SELL, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->PRICE_BUY, 0, ",", " ")}}&nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->SELL_PRICE_ALL, 0, ",", " ")}}
                                        &nbsp;ISK
                                    </td>
                                    <td class="text-right">{{number_format($loot_item->BUY_PRICE_ALL, 0, ",", " ")}}
                                        &nbsp;ISK
                                    </td>
                                    <td class="text-right" data-toggle="tooltip"
                                        title="{{$loot_item->TOOLTIP}}">{{number_format($loot_item->DROP_PERCENT*100, 2, ",", " ")}}
                                        &nbsp;%
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                    @elseif($run->LOOT_ISK)
                        <tr>
                            <td colspan="8">
                                <p class="m-5 text-center font-italic">Unfortunately we do not have information about
                                    exact
                                    loot.</p></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="8">
                                <p class="m-5 text-center font-italic">Unfortunately no loot could be gathered from this
                                    run.</p></td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="5" class="text-right font-weight-bold">Total:</td>
                        <td class="text-right font-weight-bold">{{number_format($all_sell, 0, ",", " ")}}&nbsp;ISK
                        </td>
                        <td class="text-right font-weight-bold">{{number_format($all_buy, 0, ",", " ")}}&nbsp;ISK
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <h5 class="font-weight-bold mt-2">Items consumed or lost
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Name</th>
                        <th class="text-right">Count</th>
                        <th class="text-right">Sell price/piece</th>
                        <th class="text-right">Buy price/piece</th>
                        <th class="text-right">Sell price/all</th>
                        <th class="text-right">Buy price/all</th>
                        <th>&nbsp;</th>
                    </tr>
                    @foreach($lost_table as $loot_item)
                        @php
                            $lost_sell += $loot_item->SELL_PRICE_ALL;
                            $lost_buy += $loot_item->BUY_PRICE_ALL;
                        @endphp
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
                            @else
                                <td class="text-right">{{number_format($loot_item->PRICE_SELL, 0, ",", " ")}}&nbsp;ISK
                                </td>
                                <td class="text-right">{{number_format($loot_item->PRICE_BUY, 0, ",", " ")}}&nbsp;ISK
                                </td>
                                <td class="text-right">{{number_format($loot_item->SELL_PRICE_ALL, 0, ",", " ")}}&nbsp;ISK
                                </td>
                                <td class="text-right">{{number_format($loot_item->BUY_PRICE_ALL, 0, ",", " ")}}&nbsp;ISK
                                </td>
                                <td>&nbsp;</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-right font-weight-bold">Total:</td>
                        <td class="text-right font-weight-bold text-danger">-{{number_format($lost_sell, 0, ",", " ")}}
                            &nbsp;ISK
                        </td>
                        <td class="text-right font-weight-bold text-danger">-{{number_format($lost_buy, 0, ",", " ")}}
                            &nbsp;ISK
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <h5 class="font-weight-bold">Profit</h5>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="5">&nbsp;</th>
                        <th class="text-right font-weight-bold">Sell prices</th>
                        <th class="text-right font-weight-bold">Buy prices</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">Total income:</td>
                        <td class="text-right">{{number_format($all_sell, 0, " ", " ")}} ISK</td>
                        <td class="text-right">{{number_format($all_buy, 0, " ", " ")}} ISK</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">Total expenses:</td>
                        <td class="text-right">-{{number_format($lost_sell, 0, " ", " ")}} ISK</td>
                        <td class="text-right">-{{number_format($lost_buy, 0, " ", " ")}} ISK</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-right" colspan="5">Profit</td>
                        <td class="font-weight-bold text-right">{{number_format($all_sell-$lost_sell, 0, " ", " ")}}
                            ISK
                        </td>
                        <td class="font-weight-bold text-right">{{number_format($all_buy-$lost_buy, 0, " ", " ")}}ISK
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @if(!$run->SURVIVED && $all_data->DEATH_REASON)
        <div class="row mt-3">
            <div class="col-md-12 col-sm-12">
                <div class="card card-body border-0 shadow-sm">
                    <h5 class="font-weight-bold">Death details</h5>
                    <p class=" mb-0">{{$death_reason}}
                        @if($all_data->KILLMAIL)
                            <br><a target="_blank" class="btn btn-outline-secondary mt-2"
                                   href="{{$all_data->KILLMAIL}}">Lossmail on zKillboard</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($telemetry)
        @component('components.section-head', [
                            'link_url' => "https://abyssal.space/telemetry/".$telemetry['AbyssalSpaceID']."/",
                            'link_external',
                            'link_text' => 'View all details on Abyssal Space Telemetry'])
            Telemetry summary
        @endcomponent
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card card-body border-0 shadow-sm">
                    <ul class="bookmarks">
                        @forelse($telemetry['Rooms'] as $i => $room)
                            <x-telemetry.room  :i="$i" :room="$room" />
                        @empty
                            <li class="bookmark">
                                <span class="bookmark-label">
                        No room spawn information provided in Telemetry summary.
                                </span>
                            </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    @endif

    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-head-bell" data-toggle="tab" href="#tab-bell" role="tab"
                       aria-controls="home" aria-selected="true">Tier {{$all_data->TIER}} loot distribution chart</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-head-legacy" data-toggle="tab" href="#tab-legacy" role="tab"
                       aria-controls="profile" aria-selected="false">Bar chart</a>
                </li>
            </ul>
            <div class="card card-body border-0 shadow-sm top-left-no-round">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-bell" role="tabpanel"
                         aria-labelledby="tab-head-bell">
                        <div class="graph-container h-400px">
                            {!! $bell->container(); !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-legacy" role="tabpanel" aria-labelledby="tab-head-legacy">
                        <div class="graph-container h-400px">
                            {!! $other->container(); !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12 text-right">
            @if(session()->get('login_id') == $all_data->CHAR_ID)
                <a href="{{route('new')}}" class="text-dark">Add new run</a> &centerdot;
                <a href="{{route('run.change_privacy', ['id' => $id, 'privacy' => $all_data->PUBLIC ? 'private' : 'public'])}}"
                   class="text-dark"><img
                        src="https://img.icons8.com/officexs/16/000000/key-security.png"> Make
                    run {{$all_data->PUBLIC ? 'private' : 'public'}}</a> &centerdot;
                <a href="{{route('run_delete', ['id' => $id])}}" class="text-danger"><img
                        src="https://img.icons8.com/officexs/16/000000/delete-sign.png"> Delete</a>
            @elseif(!$reported)
                <a href="javascript:void(0)" id="flag" class="text-danger"><img
                        src="https://img.icons8.com/officexs/16/000000/filled-flag2.png"> Flag for review</a>
            @elseif($reported_message)
                <p><img src="https://img.icons8.com/officexs/16/000000/filled-flag2.png"> This run was flagged for
                    manual review with the following reason: <em>{{$reported_message}}</em>. It will be reviewed soon.
                </p>
            @endif
        </div>
    </div>

@endsection

@section("scripts")

    @component("components.flag_modal", ["id" => $id])
    @endcomponent
    {!! $bell->script(); !!}
    {!! $other->script(); !!}

    <script type="text/javascript">
        function flag() {
            $("#flag_modal").modal({});
        }

        $(function () {
            $("#flag").click(flag);
        });

        $('#tab-head-bell').on('shown.bs.tab', function (e) {
            console.log("tab-bell", "shown.bs.tab");
            window.{{$bell->id}}.resize();
        });
        $('#tab-head-legacy').on('shown.bs.tab', function (e) {
            console.log("tab-legacy", "shown.bs.tab");
            window.{{$other->id}}.resize();
        });
    </script>
@endsection
@section("styles")
    <style>
        td {
            border: 0 !important;
        }
    </style>
@endsection
