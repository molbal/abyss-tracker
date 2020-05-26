@extends("layout.app")
@section("browser-title", $name)
@section("content")
    @if(session()->has('login_id') && session()->get('login_id') == $id)
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card card-body border-info shadow-sm d-flex justify-content-between flex-row" style="align-items: center">
                    <img src="https://img.icons8.com/cotton/64/000000/data-encryption.png" style="width:64px; height: 64px" />
                    <p class="m-0 p-0 text-center">
                        This is your public profile so you see every detail. To see how a guest sees this page, open it in a private window, and to edit the privacy of these panels, click <a target="_blank" href="{{route("settings.index")}}">settings</a>
                    </p>
                </div>
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm">
                <img src="https://images.evetech.net/characters/{{$id}}/portrait?size=128" class="rounded-circle shadow-sm">
                <h4 class="font-weight-bold ">{{$name}}<small>'s public profile</small></h4>
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
                            <th class="text-right" colspan="1">Submitted</th>
                            <th>&nbsp;</th>
                        </tr>
                        @forelse($last_runs as $item)
                            <tr class="action-hover-only">
                                <td>
                                    {!!$item->SHIP_NAME ? ($item->IS_CRUISER ? '<img src="/overview/cruiser.png"  width="10" height="10" data-toggle="tooltip" title="Cruiser run">' : '<img src="/overview/frigate.png" width="10" height="10" data-toggle="tooltip" title="Frigate run">') : '' !!}
                                    {!! $item->SURVIVED ? '' : '<img src="/dead.png" width="12" height="12"  data-toggle="tooltip" title="Run railed, ship and capsule lost"/>' !!}
                                </td>
                                <td>
                                    @if($item->SHIP_ID === null)
                                        <em class="font-italic text-black-50 ">Unknown</em>
                                    @else
                                        <img src="https://imageserver.eveonline.com/Type/{{$item->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" height="24px" width="24px"
                                             alt="">&nbsp;
                                        <a class="text-dark" href="{{route("search.do", ["ship_id" => $item->SHIP_ID])}}">{{$item->SHIP_NAME}}</a>
                                    @endif
                                </td>
                                <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark"
                                                                                                                    href="{{route("search.do", ["type" => $item->TYPE])}}">{{$item->TYPE}}</a>
                                </td>
                                <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark"
                                                                                                                    href="{{route("search.do", ["tier" => $item->TIER])}}">{{$item->TIER}}</a>
                                </td>
                                <td class="text-right">{{number_format($item->LOOT_ISK, 0, " "," ")}} ISK</td>
                                <td class="text-right">{{date("Y-m-d H:i:s", strtotime($item->CREATED_AT))}}</td>
                                <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}" title="Open" style="width: 16px;height: 16px"><img
                                            src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/view-file.png"></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"><p class="py-4 text-center"><img src="https://img.icons8.com/cotton/32/000000/empty-box.png" style="position: relative;top:-4px"/>
                                        <em>No runs yet</em></p></td>
                            </tr>
                        @endforelse
                    </table>
                </div>
                <div class="card-footer">
                    {{$last_runs->links()}}
                </div>
            @endcomponent
            @component("components.restricted", ["title" => "Detailed loot summary","public" => $access["LOOT"], 'icon_size' => 32])
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold mb-2">All loot from the last 7 days</h5>
                    <div>
                    @php
                        $ps = 0;
                        $pb = 0;
                    @endphp
                    @forelse($loot as $l)
                        @php
                            $ps += $l->PRICE_SELL*$l->COUNT;
                            $pb += $l->PRICE_BUY*$l->COUNT;
                        @endphp
                        @component('components.inventory_item', ['item' => $l]) @endcomponent
                    @empty
                        <p class="py-4 text-center"><img src="https://img.icons8.com/cotton/32/000000/empty-box.png" style="position: relative;top:-4px; width:32px; height: 32px" /> <em>No loot</em></p>
                    @endforelse
                    </div>
                </div>
                <div class="card-footer text-right">
                    <p>Total buy price: {{number_format($pb, 0, ".", " ")}} ISK <br> Total sell price: {{number_format($ps, 0, ".", " ")}} ISK</p>
                </div>
            @endcomponent
        </div>
        <div class="col-sm-12 col-md-4">
            @component("components.restricted", ["title" => "Runs count","public" => $access["TOTAL_RUNS"]])
                <div class="card card-body shadow-sm border-0 mt-3">
                    <div class="row">
                        <img src="https://img.icons8.com/dusk/64/000000/counter.png"style="width:64px; height: 64px"  class="pull-left ml-2">
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
                        <img src="https://img.icons8.com/dusk/64/000000/treasure-chest.png" style="width:64px; height: 64px" class="pull-left ml-2">
                        <div class="col">
                            <h2 class="font-weight-bold mb-0">{{number_format($my_sum_loot/1000000, 0, ",", " ")}}</h2>
                            <small class="text-muted font-weight-bold">Total loot (Million ISK)</small>
                        </div>
                    </div>
                </div>
                <div class="card card-body shadow-sm border-0 mt-3">
                    <div class="row">
                        <img src="https://img.icons8.com/dusk/64/000000/average-2.png" style="width:64px; height: 64px" class="pull-left ml-2">
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
                        <img src="https://img.icons8.com/dusk/64/000000/web-shield.png"  tyle="width:64px; height: 64px" class="pull-left ml-2">
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
                        <div class="graph-container h-400px">
                        {!! $favoriteShipsChart->container(); !!}
                        </div>
                    </div>
                @endcomponent
                @component("components.restricted", ["title" => "Loot query","public" => $access["LOOT"]])
                    <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold mb-2">Show loot from date</h5>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control daterange">

                            <div class="input-group-append">
                                <button type="button" id="loot_show" class="btn btn-outline-primary">Show</button>
                            </div>
                        </div>
                        <input type="hidden" id="datarangestart" name="from">
                        <input type="hidden" id="datarangestop" name="to">
                    </div>
                @endcomponent
        </div>
    </div>
@endsection

@section("styles")
    <style>

        .tooltip, .tooltip-inner {
            width: 360px;
            max-width: 360px;
        }
    </style>
@endsection
@section("scripts")
    {!! $favoriteShipsChart->script(); !!}

    <script type="text/javascript">
        // When ready.
        $(function () {

            $("#loot_show").click(function () {
                var from = $("#datarangestart").val() ? $("#datarangestart").val() : "now";
                var to = $("#datarangestop").val() ? $("#datarangestop").val() : "now";

                window.location = '/char/{{$id}}/loot/'+from+"/"+to
            });

            $(".daterange").daterangepicker({
                "autoUpdateInput": false,
                "timePicker": false,
                "autoApply": true,
                "showCustomRangeLabel": true,
                "alwaysShowCalendars": true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function (start, end, label) {
                $(".daterange").val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                $("#datarangestart").val(start.format("YYYY-MM-DD"));
                $("#datarangestop").val(end.format("YYYY-MM-DD"));
            });
        });
    </script>
@endsection
