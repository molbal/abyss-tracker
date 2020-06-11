@extends("layout.app")
@section("browser-title", sprintf("%s difficulty overview",__("tiers.".$tier)))

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-10">
            <h4 class="font-weight-bold">
                <div class="icon-wrapper shadow">
                    <img src="/tiers/{{$tier}}.png" alt="@lang("tiers.".$tier) filament icon" class="page-top-icon">
                </div>
                @lang("tiers.".$tier) difficulty overview</h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <div class="row">
                    <img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath("cruiser")}}" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">XX.XX M ISK</h2>
                        <small class="text-muted font-weight-bold">Most probable loot value (Cruisers)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <div class="row">
                    <img src="{{\App\Http\Controllers\ThemeController::getShipSizeIconPath("frigate")}}" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">XX.XX M ISK</h2>
                        <small class="text-muted font-weight-bold">Most probable loot value (Frigates)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    <style>
        .icon-wrapper {
            width: 72px;
            height: 72px;
            display: inline-block;
            border: 2px solid #fff;
            padding: 0;
            border-radius: 50%;
        }
        img.page-top-icon {
            width: 66px;
            height: 66px;
            padding: 0;
            margin: 3px 4px 3px 1px;
        }
    </style>

@endsection
@section('scripts')
    <script>
        $(function () {

            $(".select2-nosearch-narrow").select2({
                theme: 'bootstrap',
                minimumResultsForSearch: -1,
                width: '25%'
            });
        });
    </script>
@endsection
