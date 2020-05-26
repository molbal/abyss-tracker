@extends("layout.app")
@section("browser-title", "Most used ships")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Most used ships</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most used cruisers</h5>
                <div class="graph-container h-400px">{!! $cruiser_chart->container() !!}</div>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">List of used cruisers</h5>
                <table class="table table-sm table-responsive-sm">
                    <tr>
                        <th colspan="2">Ship name</th>
                        <th class="text-right">Use count</th>
                    </tr>
                    @foreach($query_cruiser as $ship)
                        <tr>
                            <td class="text-center"><img src="https://imageserver.eveonline.com/Type/{{$ship->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" style="border: 1px solid #fff; width: 24px; height: 24px" alt=""></td>
                            <td><a href="{{route("ship_single", ["id" => $ship->SHIP_ID])}}" class="text-dark" data-toggle="tooltip" title="Open {{$ship->NAME}} summary">{{$ship->NAME}}</a></td>
                            <td><a href="{{route("fit.search", ["SHIP_GROUP" => $ship->GROUP ?? "unknown group"])}}" class="text-dark" data-toggle="tooltip" title="Show {{$ship->GROUP ?? "unknown group"}} fits">{{$ship->GROUP ?? "unknown group"}}</a></td>
                            <td class="text-right">{{$ship->RUNS}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most used frigates</h5>
                <div class="graph-container h-400px">{!! $frigate_chart->container() !!}</div>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">List of used frigates</h5>
                <table class="table table-sm table-responsive-sm">
                    <tr>
                        <th colspan="2">Ship name</th>
                        <th class="text-right">Use count</th>
                    </tr>
                    @foreach($query_frigate as $ship)
                        <tr>
                            <td class="text-center"><img src="https://imageserver.eveonline.com/Type/{{$ship->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" style="border: 1px solid #fff; width: 24px; height: 24px" alt=""></td>
                            <td><a href="{{route("ship_single", ["id" => $ship->SHIP_ID])}}" class="text-dark" data-toggle="tooltip" title="Open {{$ship->NAME}} summary">{{$ship->NAME}}</a></td>
                            <td><a href="{{route("fit.search", ["SHIP_GROUP" => $ship->GROUP ?? "unknown group"])}}" class="text-dark" data-toggle="tooltip" title="Show {{$ship->GROUP ?? "unknown group"}} fits">{{$ship->GROUP ?? "unknown group"}}</a></td>
                            <td class="text-right">{{$ship->RUNS}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    {!! $cruiser_chart->script() !!}
    {!! $frigate_chart->script() !!}
@endsection
