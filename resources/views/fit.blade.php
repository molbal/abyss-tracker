@extends("layout.app")
@section("browser-title", $ship_name." fit by ".$char_name)
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold">{{$ship_name}} fit: {{$fit->NAME}} by <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}">{{$char_name}}</a></h4>
        <p class="text-right text-sm mb-0 pb-0">
            Saved at: {{$fit->SUBMITTED}}
        </p>
    </div>
    <div class="row">
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold"><img src="https://imageserver.eveonline.com/Type/{{$fit->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" alt=""> {{$fit->NAME}}</h5>
                <table class="table table-responsive-sm table-sm w-100 mb-4">
                    @component("components.fit_group", ["items" => $fit_quicklook["high"], "section" => "High slot modules"])@endcomponent
                    @component("components.fit_group", ["items" => $fit_quicklook["mid"], "section" => "Mid slot modules"])@endcomponent
                    @component("components.fit_group", ["items" => $fit_quicklook["low"], "section" => "Low slot modules"])@endcomponent
                    @component("components.fit_group", ["items" => $fit_quicklook["rig"], "section" => "Rigs"])@endcomponent
                    @component("components.fit_group", ["items" => $fit_quicklook["other"], "section" => "Drones & cargo"])@endcomponent
                    <tr>
                        <td colspan="3" class="font-weight-bold text-right">Total: {{number_format($fit->PRICE, 0, ","," ")}} ISK</td>
                    </tr>
                </table>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Description</h5>
                <div class="text-justify">
                    {!! $description !!}
                </div>
                <p class="text-right">
                    - by <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}">{{$char_name}} <img
                            src="https://images.evetech.net/characters/{{$fit->CHAR_ID}}/portrait?size=32" alt="" style="width: 24px; height: 24px"
                            class="rounded-circle shadow-sm"></a>
                </p>
            </div>

        </div>
        <div class="col-sm-3">
            @if(strtoupper($fit->STATUS) == "DONE")
                @component('components.fit_stats', ["stats" => $fit->STATS])@endcomponent
            @elseif(strtoupper($fit->STATUS) == "QUEUED")
                <div class="card card-body border-warning shadow-sm text-center">
                    <div class="mb-0">
                        <img src="https://img.icons8.com/cotton/64/000000/clock-settings.png" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Calculating stats</h5>
                        <p class="mb-0">Please reload this page in a few minutes once we have calculated its stats.</p>
                    </div>
                </div>
            @else
                <div class="card card-body border-warning shadow-sm text-center">
                    <div class="mb-0">
                        <img src="https://img.icons8.com/cotton/64/000000/cancel--v1.png" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Error</h5>
                        <p class="mb-0">The EFT fit is probably broken or we have an error in the system and could not calculate stats</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section("styles")
    <style>
        .bringupper {
            position: relative;
            top: -2px;
        }

        .table td, .table th {
            border-top: 0 solid transparent !important;
        }
    </style>
@endsection
