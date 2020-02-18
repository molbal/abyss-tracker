@extends("layout.app")
@section("browser-title", "Most used ships")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">{{$name}} overview</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Popularity over the last 3 months <small class="float-right">This graph shows the percentage of Abyss runs using/day using a {{$name}}</small></h5>
                {!! $pop_chart->container() !!}
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    {!! $pop_chart->script() !!}
@endsection
