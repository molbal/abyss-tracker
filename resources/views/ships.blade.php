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
                {!! $cruiser_chart->container() !!}
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">List of used cruisers</h5>
                <table class="table table-sm table-responsive-sm">
                    <tr>
                        <th colspan="2">Ship name</th>
                        <th class="text-right">Use count</th>
                    </tr>
                    @foreach($query_cruiser as $cruiser)
                        <tr>
                            <td><img src="https://imageserver.eveonline.com/Type/{{$cruiser->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" alt=""></td>
                            <td>{{$cruiser->NAME}}</td>
                            <td class="text-right">{{$cruiser->RUNS}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most used frigates</h5>
                {!! $frigate_chart->container() !!}
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">List of used frigates</h5>
                <table class="table table-sm table-responsive-sm">
                    <tr>
                        <th colspan="2">Ship name</th>
                        <th class="text-right">Use count</th>
                    </tr>
                    @foreach($query_frigate as $cruiser)
                        <tr>
                            <td><img src="https://imageserver.eveonline.com/Type/{{$cruiser->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" alt=""></td>
                            <td>{{$cruiser->NAME}}</td>
                            <td class="text-right">{{$cruiser->RUNS}}</td>
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
