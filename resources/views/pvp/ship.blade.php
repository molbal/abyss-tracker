@extends("layout.app")
@section("browser-title",$ship->name . " - " . $event->name)
@section("content")
    <div class="my-5">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm">
                <img src="https://imageserver.eveonline.com/Render/{{$ship->id}}_256.png" class="rounded-circle shadow-sm h-100px">
                <h4 class="font-weight-bold ">{{$ship->name}}<small> in {{$event->name}}</small></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="card card-body border-0 shadow-sm mb-0 rounded-b-none">
                <h5 class="font-weight-bold">Weapons usage</h5>
                <div class="graph-container h-300px">{!! $topWeaponsChart->container() !!}</div>
            </div>
            <div class="card-footer mb-3 rounded-t-none shadow-sm">
                @component('components.info-line') Data collected from zKillboard, using character killmails  @endcomponent
            </div>
            <div class="card card-body border-0 shadow-sm mb-0 rounded-b-none">
                <h5 class="font-weight-bold">Win rate</h5>
                <div class="graph-container h-300px">{!! $winRateChart->container() !!}</div>
            </div>
            <div class="card-footer mb-3 rounded-t-none shadow-sm">
                @component('components.info-line') Data collected from zKillboard, using character lossmails and killmails  @endcomponent
            </div>
        </div>
        <div class="col-md-12 col-lg-8">
            <h5 class="font-weight-bold">Kills &amp; losses</h5>
            @forelse($feed as $kill)
                @component($event->display_component, ['event' => $event, 'victim' => $kill, 'loss' => $kill->ship_type_id == $ship->id]) @endcomponent
            @empty
                <em>Nothing
                    here yet</em>
            @endforelse
        </div>
    </div>


@endsection

@section('scripts')
{{--    {!! $topShipsChart->script() !!}--}}
    {!! $topWeaponsChart->script() !!}
    {!! $winRateChart->script() !!}
@endsection
