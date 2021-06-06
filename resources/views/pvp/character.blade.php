@extends("layout.app")
@section("browser-title",$character->name . " - " . $event->name)
@section("content")
    <div class="my-5">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm">
                <img src="https://images.evetech.net/characters/{{$character->id}}/portrait?size=128" class="rounded-circle shadow-sm">
                <h4 class="font-weight-bold ">{{$character->name}}<small> in {{$event->name}}</small></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="card card-body border-0 shadow-sm mb-0 rounded-b-none">
                <h5 class="font-weight-bold">Ship usage</h5>
                <div class="graph-container h-300px">{!! $topShipsChart->container() !!}</div>
            </div>
            <div class="card-footer mb-3 rounded-t-none shadow-sm">
                @component('components.info-line') Data collected from zKillboard, using character lossmails and killmails  @endcomponent
            </div>
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

            <h5 class="font-weight-bold">Feed </h5>
            @forelse($feed as $kill)
                {{--                {{$kill->character->id}} vs {{$character->id}}--}}
                @component($event->display_component, ['event' => $event, 'victim' => $kill, 'loss' => $kill->character_id == $character->id]) @endcomponent
            @empty
                <em>Nothing
                    here yet</em>
            @endforelse
        </div>
    </div>

@endsection

@section('scripts')
    {!! $topShipsChart->script() !!}
    {!! $topWeaponsChart->script() !!}
    {!! $winRateChart->script() !!}
@endsection
