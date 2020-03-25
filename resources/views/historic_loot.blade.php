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
                        <p class="py-4 text-center"><img src="https://img.icons8.com/cotton/32/000000/empty-box.png" style="position: relative;top:-4px"/> <em>No loot</em></p>
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
                        <div class="col">g
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

@section("scripts")
    {!! $favoriteShipsChart->script(); !!}

    <script type="text/javascript">
        // When ready.
        $(function () {

            $("#loot_show").click(function () {
                window.location = '/char/loot/'+$("#datarangestart").val()+"/"+$("#datarangestop").val();
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
            border: 3px solid{{App\Http\Controllers\ThemeController::getThemedBorderColor()}};
            position: relative;
            top: 0;
            left: 32px;
            z-index: 50;
        }

        #banner > h4 {
            color: #fff;
            text-shadow: 0 2px 0 rgba(0, 0, 0, 0.8);
            position: relative;
            top: 10px;
            left: 64px;
            text-transform: uppercase;
            font-size: 26px;
        }
    </style>
@endsection
