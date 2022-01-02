@extends("layout.app")
@section("browser-title", "$name")
@section("content")
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm w-100">
                <img src="https://images.evetech.net/types/{{$id}}/render?size=256" class="rounded-circle shadow-sm" style="width: 128px; height:128px">
                <h4 class="font-weight-bold">{{$name}}
                </h4>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Popularity over the last 3 months <small class="float-right">This graph shows the percentage of Abyss runs using/day using a {{$name}}</small></h5>
                {!! $pop_chart->container() !!}
            </div>
            <div class="card-footer">
                @component("components.info-line")
                    Data source: User submissions and Abyss Tracker calculations &middot; Cached for up to 15 minutes
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Ship usage by tier</h5>
                {!! $pop_tiers->container() !!}
            </div>
            <div class="card-footer">
                @component("components.info-line")
                    Data source: User submissions and Abyss Tracker calculations &middot; Cached for up to 15 minutes
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Ship usage by weather</h5>
                {!! $pop_types->container() !!}
            </div>
            <div class="card-footer">
                @component("components.info-line")
                    Data source: User submissions and Abyss Tracker calculations &middot; Cached for up to 15 minutes
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Fits DPS distribution</h5>
                {!! $dps_chart->container() !!}
            </div>
            <div class="card-footer">
                @component("components.info-line")
                    Data source: User submissions and Abyss Tracker calculations &middot; Cached for up to 15 minutes
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most popular fits for {{$name}}</h5>
                @component("components.fits.filter.result-list", ["results" => $fits]) @endcomponent

                <a href="{{route("fit.search", ["SHIP_ID" => $id])}}"  class="text-dark"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/job.png">Show more fits</a>
            </div>
            <div class="card-footer">
                @component("components.info-line")
                    Data source: Abyss Tracker user submissions &middot; Cached for up to 15 minutes
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">

        <div class="col-sm-12">
            @component('components.items.market-history', [
		       'marketHistory' => $priceChart,
		       'itemName' => $name
]) @endcomponent
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-8">
        @component("components.runs.list", ['title' => "Last $name runs", 'items' => $items]) @endcomponent
        </div>

        <div class="col-xs-12 col-sm-4">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Death reasons</h5>
                {!! $death_chart->container() !!}
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">Looting strategy</h5>
                {!! $loot_chart->container() !!}
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    {!! $pop_chart->script() !!}
    {!! $pop_tiers->script() !!}
    {!! $pop_types->script() !!}
    {!! $death_chart->script() !!}
    {!! $loot_chart->script() !!}
    {!! $priceChart->script() !!}
    {!! $dps_chart->script() !!}
@endsection
