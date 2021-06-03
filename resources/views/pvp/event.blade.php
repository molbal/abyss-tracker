@extends("layout.app")
@section("browser-title", $event->name)
@section("content")

    <div class="row">
        @component('pvp.components.video-banner', ['event' => $event]) @endcomponent
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="graph-container" style="min-height: 491px" data-load="{{route('pvp.widget.top-kills', ['id' => $event->id])}}">&nbsp;</div>
            <div class="card card-body border-0 shadow-sm mb-0 rounded-b-none">
                <h5 class="font-weight-bold">Ship meta</h5>
                <div class="graph-container h-300px">{!! $topShipsChart->container() !!}</div>
            </div>
            <div class="card-footer mb-3 rounded-t-none shadow-sm">
                @component('components.info-line') Data collected from zKillboard feed @endcomponent
            </div>

            <div class="card card-body border-0 shadow-sm mb-0  rounded-b-none">
                <h5 class="font-weight-bold">Weapon meta</h5>

                <div class="graph-container h-300px">{!! $topWeaponsChart->container() !!}</div>
            </div>
            <div class="card-footer mb-3 rounded-t-none shadow-sm">
                @component('components.info-line') Data collected from zKillboard feed @endcomponent
            </div>
        </div>

        <div class="col-md-12 col-lg-8">
            @forelse($feed as $kill)
                @component($event->display_component, ['event' => $event, 'victim' => $kill]) @endcomponent
            @empty
                <em>Nothing here yet</em>
            @endforelse
            <a class="text-dark" href="{{route('pvp.kills', ['slug' => $event->slug])}}"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/database.png">View all kills</a>
        </div>
    </div>

@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('[data-load]').each(function (index, value) {
                const element = $(value);
                element.load(element.data('load'));
            });
        });
    </script>
    {!! $topShipsChart->script() !!}
    {!! $topWeaponsChart->script() !!}
@endsection

@section("styles")
    <style type="text/css">

    </style>
@endsection

