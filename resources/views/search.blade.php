@extends("layout.app")
@section("browser-title", "Search")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">Advanced search</h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Most common filters</h5>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Tier</label>
                                <select name="tier" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    @foreach($tiers as $tier)
                                        <option value="{{$tier->TIER}}">{{$tier->TIER}}</option>
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
                                <label>Exact ship type</label><img
                                    class="float-right"
                                    src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png" data-toggle="tooltip"
                                    title="Ships with 0 runs are hidden from this list">
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
                                    <option value="1">Cruiser sized ships</option>
                                    <option value="0">Frigate sized ships</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body shadow-sm border-0 mt-3">
                <h5 class="font-weight-bold">Timing filters</h5>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
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
                                    <input name="min_run_length_m" id="run_length_minute" class="form-control" value="00" />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">m</span>
                                    </div>
                                    <input name="min_run_length_s" id="run_length_second" class="form-control" value="00" />
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
                                    <input name="max_run_length_m" id="run_length_minute" class="form-control" value="20" />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">m</span>
                                    </div>
                                    <input name="max_run_length_s" id="run_length_second" class="form-control" value="00" />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            }, function(start, end, label) {
                $(".daterange").val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                $("#datarangestart").val(start.format("YYYY-MM-DD"));
                $("#datarangestop").val(end.format("YYYY-MM-DD"));
            });
        });
    </script>
@endsection

