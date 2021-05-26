@extends("layout.app")
@section("browser-title", $event->name)
@section("content")

    <div class="row">
        <div class="col-sm-12 mb-3">
            <video autoplay loop muted poster="{{asset("home/1.10.3.jpg")}}" class="w-100 rounded shadow-sm mt-5" style="height: 170px; pointer-events: none;  object-fit: cover;">
                <source src="{{asset("pvp/".$event->slug.".mp4")}}" type="video/mp4">
            </video>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-4 graph-container" style="min-height: 491px" data-load="{{route('pvp.widget.top-kills', ['id' => $event->id])}}">
            &nbsp;
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="card card-body border-0 shadow-sm mb-3">
                <h5 class="font-weight-bold">Most ship wins</h5>
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
@endsection

@section("styles")
    <style type="text/css">
    </style>
@endsection
