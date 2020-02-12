@extends("layout.app")
@section("browser-title", "My stats (".session()->get("login_name").")")
@section("content")

    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold"><img
                src="https://images.evetech.net/characters/{{session()->get("login_id")}}/portrait?size=64" alt=""
                class="rounded-circle shadow-sm"> Stats for {{session()->get("login_name")}}</h4>
    </div>


    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/counter.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{$my_runs}}</h2>
                        <small class="text-muted font-weight-bold">Runs so far</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/average-2.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($my_avg_loot/1000000, 2, ".", " ")}}</h2>
                        <small class="text-muted font-weight-bold">Average loot (Million ISK)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/treasure-chest.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($my_sum_loot/1000000, 0, ",", " ")}}</h2>
                        <small class="text-muted font-weight-bold">Total loot (Million ISK)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/web-shield.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{sprintf("%1.2f", $my_survival_ratio)}} %</h2>
                        <small class="text-muted font-weight-bold">Survival ratio</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card card-body border-0 shadow-sm my-4">
                <h5 class="font-weight-bold mb-2">Average loot per day</h5>
                {!! $personal_chart_loot->container(); !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-body border-0 shadow-sm my-4">
                <h5 class="font-weight-bold mb-2">Approximate ISK/hour</h5>
                {!! $personal_isk_per_hour->container(); !!}
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-6">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Last 30 days</h5>
                <table class="table table-responsive-sm table-sm">
                    <tr>
                        <th>Day</th>
                        <th class="text-right">Runs #</th>
                        <th class="text-right">Avg loot</th>
                        <th class="text-right">All loot</th>
                    </tr>
                    @forelse($activity_daily as $data)
                        <tr>
                            <td>{{$data[0]->RUN_DATE}}</td>
                            <td class="text-right">{{$data[0]->COUNT}}</td>
                            <td class="text-right">{{round($data[0]->AVG/1000000 ?? 0, 2)}}{{$data[0]->AVG ? 'M' : ''}}
                                ISK
                            </td>
                            <td class="text-right">{{round($data[0]->SUM/1000000 ?? 0, 2)}}{{$data[0]->AVG ? 'M' : ''}}
                                ISK
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No data yet</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group col-md-4">
                <a href="{{route("runs_mine")}}" class="btn btn-outline-secondary">My runs</a>
                <a href="{{route("new")}}" class="btn btn-outline-secondary">Add new run</a>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    {!! $personal_chart_loot->script(); !!}
    {!! $personal_isk_per_hour->script(); !!}
@endsection
