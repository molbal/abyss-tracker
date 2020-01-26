@extends("layout.app")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold">Recorded abyssal run by {!! $run->PUBLIC ? $run->NAME : "<em>Anonymus</em>" !!} - {{$run->RUN_DATE}}</h4>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="types/{{$run->TYPE}}.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{$run->TYPE}}</h2>
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
                        <h2 class="font-weight-bold mb-0">Tier {{$run->TIER}}</h2>
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
                    <img src="https://imageserver.eveonline.com/Type/15331_64.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{$run->SURVIVED ? "Survived" : "Exploded"}}</h2>
                        <small class="text-muted font-weight-bold">Survived</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="font-weight-bold">Survival of {{$run->TYPE}} tier {{$run->TIER}}</h4>
                {!! $survival->container(); !!}
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="font-weight-bold">Loot value comparision</h4>
                {!! $other->container(); !!}
            </div>
        </div>
    </div>

@endsection

@section("scripts")
{!! $survival->script(); !!}
{!! $other->script(); !!}
@endsection
