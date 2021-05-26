@extends("layout.app")
@section("browser-title", $event->name)
@section("content")

    <div class="row">
        @component('pvp.components.video-banner', ['event' => $event]) @endcomponent
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-4 graph-container" style="min-height: 491px" data-load="{{route('pvp.widget.top-kills', ['id' => $event->id])}}">
            &nbsp;
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="card card-body border-0 shadow-sm mb-3">
                <h5 class="font-weight-bold">Most ship wins</h5>
                <div class="graph-container h-400px">{!! $topShipsChart->container() !!}</div>
            </div>
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
@endsection

@section("styles")
    <style type="text/css">
    </style>
@endsection
