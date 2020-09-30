@extends("layout.app")
@section("browser-title", "Search")
@section("content")
    <form action="{{route("search.do")}}" method="get">
        {{csrf_field()}}

    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">Advanced search</h4>
        </div>

        @if(isset($errors))
            @if ($errors->any())
                <div class="col-sm-12 alert alert-danger border-0 shadow-sm d-flex justify-content-between">
                    <img src="https://img.icons8.com/cotton/48/000000/cancel-2--v1.png" style="width: 48px;height: 48px">
                    <div style="width: 100%">
                        <span class="ml-3">Please fix the following errors before submitting your search</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endif
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/32/000000/rocket.png"> Most common filters</h5>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Tier</label>
                                <select name="tier" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    @foreach($tiers as $tier)
                                        <option value="{{$tier->TIER}}">@lang ("tiers.".$tier->TIER) (Tier {{$tier->TIER}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->TYPE}}">{{$type->TYPE}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Exact ship type</label>
                                @component("components.info-toggle") Ships with 0 runs are hidden from this list @endcomponent
                                <select name="ship_id" class="form-control select2-default">
                                    <option value="" selected>&nbsp;</option>
                                    @foreach($ships as $ship)
                                        <option value="{{$ship->ID}}">{{$ship->NAME}} ({{$ship->GROUP}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Hull size</label>
                                <select name="hull_size" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    <option value="{{\App\Http\Controllers\Misc\Enums\ShipHullSize::CRUISER}}">{{ucfirst(\App\Http\Controllers\Misc\Enums\ShipHullSize::CRUISER)}} size</option>
                                    <option value="{{\App\Http\Controllers\Misc\Enums\ShipHullSize::DESTROYER}}">{{ucfirst(\App\Http\Controllers\Misc\Enums\ShipHullSize::DESTROYER)}} size</option>
                                    <option value="{{\App\Http\Controllers\Misc\Enums\ShipHullSize::FRIGATE}}">{{ucfirst(\App\Http\Controllers\Misc\Enums\ShipHullSize::FRIGATE)}} size</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body shadow-sm border-0 mt-3">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/32/000000/time.png"> Timing filters</h5>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">Run at</label>
                                <input type="text" class="form-control daterange">
                                <input type="hidden" id="datarangestart" name="run_date_start">
                                <input type="hidden" id="datarangestop" name="run_date_end">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Minimum runtime</label>
                                <div class="input-group">
                                    <input name="min_run_length_m" id="run_length_minute" class="form-control"/>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">m</span>
                                    </div>
                                    <input name="min_run_length_s" id="run_length_second" class="form-control"/>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Maximum runtime</label>
                                <div class="input-group">
                                    <input name="max_run_length_m" id="run_length_minute" class="form-control"/>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">m</span>
                                    </div>
                                    <input name="max_run_length_s" id="run_length_second" class="form-control"/>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body shadow-sm border-0 mt-3">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/32/000000/thriller.png"> Survival filters</h5>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Survived?</label>
                                <select name="survived" id="survived" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    <option value="1">Survived</option>
                                    <option value="0">Exploded</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Proving conduit spawned?</label>
                                <select name="proving_had" id="proving_had" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">PVP room usage?</label>
                                <select name="proving_used" id="proving_used" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    <option value="1">Yes, went into PVP room</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Death reason filter</label>
                                <select name="death_reason" id="death_reason" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    <option value="TIMEOUT">{{$bc->getDeathReasonQQuickBark('TIMEOUT')}}</option>
                                    <option value="TANK_FAILED">{{$bc->getDeathReasonQQuickBark('TANK_FAILED')}}</option>
                                    <option value="CONNECTION_DROP">{{$bc->getDeathReasonQQuickBark('CONNECTION_DROP')}}</option>
                                    <option value="PILOTING_MISTAKE">{{$bc->getDeathReasonQQuickBark('PILOTING_MISTAKE')}}</option>
                                    <option value="PVP_DEATH">{{$bc->getDeathReasonQQuickBark('PVP_DEATH')}}</option>
                                    <option value="OVERHEAT_FAILURE">{{$bc->getDeathReasonQQuickBark('OVERHEAT_FAILURE')}}</option>
                                    <option value="EXPERIMENTAL_FIT">{{$bc->getDeathReasonQQuickBark('EXPERIMENTAL_FIT')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-body shadow-sm border-0 mt-3">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/32/000000/bank-safe.png"> Looting filters</h5>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Minimum loot value</label>
                                <div class="input-group">
                                    <input name="loot_min" id="loot_min" class="form-control" value=""/>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">ISK</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Maximum loot value</label>
                                <div class="input-group">
                                    <input name="loot_max" id="loot_max" class="form-control" value=""/>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">ISK</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">Loot strategy</label>
                                <select name="loot_strategy" id="loot_strategy" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    <option value="BIOADAPTIVE_ONLY">{{$bc->getLootStrategyDescription('BIOADAPTIVE_ONLY')}}</option>
                                    <option value="BIOADAPTIVE_PLUS_SOME_CANS">{{$bc->getLootStrategyDescription('BIOADAPTIVE_PLUS_SOME_CANS')}}</option>
                                    <option value="BIOADAPTIVE_PLUS_MOST_CANS">{{$bc->getLootStrategyDescription('BIOADAPTIVE_PLUS_MOST_CANS')}}</option>
                                    <option value="BIOADAPTIVE_PLUS_ALL_CANS">{{$bc->getLootStrategyDescription('BIOADAPTIVE_PLUS_ALL_CANS')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="mt-3">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
        </div>
    </div>

@endsection

@section("scripts")

    <script type="text/javascript">

        // When ready.
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-0d'
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

