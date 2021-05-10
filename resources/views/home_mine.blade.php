@extends("layout.app")
@section("browser-title", "My stats (".session()->get("login_name").")")
@section("content")

    {{--    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">--}}
    {{--        <h4 class="font-weight-bold"><img--}}
    {{--                src="https://images.evetech.net/characters/{{session()->get("login_id")}}/portrait?size=64" alt=""--}}
    {{--                class="rounded-circle shadow-sm"> Stats for {{session()->get("login_name")}}</h4>--}}
    {{--    </div>--}}

    <div class="row mt-4">
        <div class="col-sm-12 col-md-9">
            <div id="banner" class="shadow-sm">
                <img src="https://images.evetech.net/characters/{{\App\Http\Controllers\Auth\AuthController::getLoginId()}}/portrait?size=128" class="rounded-circle shadow-sm">
                <h4 class="font-weight-bold justify-content-between w-100">{{\App\Http\Controllers\Auth\AuthController::getCharName()}}<small
                        class="ml-2" style="font-size: 1rem">{{$character_type}} character</small></h4>
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            <div id="quicklinks" class="shadow-sm">
                <a href="{{route("new")}}" class="font-weight-bold  h4 mb-0">New run</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs justify-content-end mt-4">
                @foreach($years as $y)
                    <li class="nav-item">
                        <a class="nav-link {{$y == $year ? "active" : ""}}" href="{{route('home.year-redirect', ['year' => $y])}}">{{$y}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="card card-body border-0 shadow-sm mb-0 rounded-b-none">
                <h5 class="font-weight-bold mb-2">Activity</h5>
                <div class="graph-container h-160px activity">
                    {!! $activity_chart->container(); !!}
                </div>
            </div>
            <div class="card-footer border-0 shadow-sm mb-4 rounded-t-none">
                @component('components.info-line')
                    @if($is_main)
                        The more runs you or your alts ({{$chars->pluck('name')->implode(', ')}}) made any given day, the greener that day will be in the calendar.
                    @else
                        The more runs you made any given day, the greener that day will be in the calendar.
                    @endif
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                @if($is_main)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-toggle="tab" href="#overview" role="tab">Overview</a>
                    </li>
                    @foreach($chars as $char)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-toggle="tab" href="#char_{{$char->id}}" id="char_head_{{$char->id}}" role="tab">{{$char->name}}</a>
                        </li>
                    @endforeach
                @else
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-toggle="tab" href="#char_{{\App\Http\Controllers\Auth\AuthController::getLoginId()}}"
                           role="tab">{{\App\Http\Controllers\Auth\AuthController::getCharName()}}</a>
                    </li>
                @endif
                <li class="nav-item ml-auto">
                    <a class="nav-link" data-toggle="tooltip" title="Manage alts" href="{{route('alts.index')}}"><img
                            src="https://img.icons8.com/small/24/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/group-foreground-selected.png"
                            class="tinyicon mr-1"/></a>
                </li>
            </ul>

            <div class="card card-body border-0 shadow-sm top-left-no-round p-3">
                @if($is_main)


                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 p-3">
                                    <h5>Runs count</h5>
                                    <div class="graph-container w-100 h-300px">
                                        {!!  $runs_count_ov->container()!!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 p-3">
                                    <span class="w-100 mb-2 d-flex justify-content-between align-content-center">
                                        <h5 class="mb-0">Average loot</h5>
                                        <small>(M ISK)</small>
                                    </span>
                                    <div class="graph-container w-100 h-300px">
                                        {!!  $avg_loot_ov->container()!!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 p-3">
                                    <span class="w-100 mb-2 d-flex justify-content-between align-content-center">
                                        <h5 class="mb-0">Survival ratio</h5>
                                        <small>(%)</small>
                                    </span>
                                    <div class="graph-container w-100 h-300px">
                                        {!!  $survival_ov->container()!!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 p-3">
                                    <span class="w-100 mb-2 d-flex justify-content-between align-content-center">
                                        <h5 class="mb-0">Total loot</h5>
                                        <small>(M ISK)</small>
                                    </span>
                                    <div class="graph-container w-100 h-300px">
                                        {!!  $sum_loot_ov->container()!!}
                                    </div>
                                </div>
                            </div>

                            @component('components.info-line')
                                These charts were generated by data you submitted for {{$chars->pluck('name')->implode(', ')}}
                            @endcomponent
                        </div>

                        @foreach($chars as $char)
                            @component('components.personal-home.char-tab', ['char' => $char,'my_runs' => $my_runs,'my_avg_loot' => $my_avg_loot,'my_sum_loot' => $my_sum_loot,'my_survival_ratio' => $my_survival_ratio,'timeline_charts' => $timeline_charts]) @endcomponent
                        @endforeach
                    </div>

                @else
                    <div class="tab-content">
                        @component('components.personal-home.char-tab', ['char' => $chars->firstWhere('id', \App\Http\Controllers\Auth\AuthController::getLoginId()),'my_runs' => $my_runs,'my_avg_loot' => $my_avg_loot,'my_sum_loot' => $my_sum_loot,'my_survival_ratio' => $my_survival_ratio,'timeline_charts' => $timeline_charts, 'show' => true]) @endcomponent
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Last submitted runs ({{$last_runs->total()}} total)</h5>
                <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Character</th>
                        <th>Ship name</th>
                        <th>Abyss type</th>
                        <th>Abyss tier</th>
                        <th class="text-right">Loot value</th>
                        <th class="text-right">Run saved at</th>
                        <th class="text-right" colspan="2">Duration</th>
                    </tr>
                    @foreach($last_runs as $item)
                        @component("components.runs.row-personal", ['item' => $item]) @endcomponent
                    @endforeach
                </table>
            </div>
            <div class="card-footer">
                {!! $last_runs->links() !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-0">Show loot from date</h5>
                <small class="text-muted mb-3">for {{\App\Http\Controllers\Auth\AuthController::getCharName()}}</small>

                <div class="input-group mb-3">
                    <input type="text" class="form-control daterange">

                    <div class="input-group-append">
                        <button type="button" id="loot_show" class="btn btn-outline-primary">Show</button>
                    </div>
                </div>
                <input type="hidden" id="datarangestart" name="from">
                <input type="hidden" id="datarangestop" name="to">
            </div>
        </div>
    </div>
@endsection

@section("styles")
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">
    <style type="text/css">

        div.asslicker {
            height: 18px;
        }

        p.asslicker-new-run {
            height: 1rem;
            line-height: 1rem;
        }

        img.portrait-new-run {
            position: relative;
            top: -20px;
            /*left: -35px;*/
            /*margin-right: -24px;*/
            border: 2px solid #fff;
            height: 48px;
            width: 48px;
        }
    </style>
@endsection

@section("scripts")
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    {!! $activity_chart->script(); !!}
    @foreach($timeline_charts as $id => $c)
        <!-- {{$id}} {{$chars->firstWhere('id', $id)->name}} for {{$c->id}} -->
        {!! $c->script() !!}
    @endforeach
    @if($is_main)
        <!-- runs_count_ov -->
        {!!  $runs_count_ov->script()!!}
        <!-- avg_loot_ov -->
        {!!  $avg_loot_ov->script()!!}
        <!-- survival_ov -->
        {!!  $survival_ov->script()!!}
        <!-- sum_loot_ov -->
        {!!  $sum_loot_ov->script()!!}
    @endif
    <script type="text/javascript">
        @foreach($chars as $char)
        @if (isset($timeline_charts[$char->id]->id))
        $('#char_head_{{$char->id}}').on('shown.bs.tab', function (e) {
            console.log("shown ", {{$char->id}});
            window.{{$timeline_charts[$char->id]->id}}.resize();
        });
        @endif
        @endforeach

        $(function () {

            $("#loot_show").click(function () {
                var from = $("#datarangestart").val() ? $("#datarangestart").val() : "now";
                var to = $("#datarangestop").val() ? $("#datarangestop").val() : "now";

                window.location = '/char/{{\App\Http\Controllers\Auth\AuthController::getLoginId()}}/loot/' + from + "/" + to
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
