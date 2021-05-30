@extends("layout.app")
@section("browser-title", "Killmail of ".$victim->character->name."'s ".$victim->ship_type->name." in ".$victim->pvp_event->name)
@section("content")

    <div class="row">
        @component('pvp.components.video-banner', ['event' => $victim->pvp_event]) @endcomponent
    </div>
    <div class="d-flex justify-content-between align-items-center mb-1 mt-5">
        <span class="fit-header-line">
            <h4 class="font-weight-bold fit-title d-inline-block mb-0">{{$victim->character->name}}'s {{$victim->ship_type->name}}</h4>
        </span>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Modules</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eft">Export</a></li>
            </ul>

            <div class="card card-body border-0 shadow-sm pt-3">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
{{--                        @component("components.fits.display-structured", ['fit' => $fit, 'fit_quicklook' => $fit_quicklook, 'ship_name' => $ship_name, 'ship_price' => $ship_price, 'items_price' => $items_price]) @endcomponent--}}
                    </div>
                    <div id="eft" class="tab-pane fade">
                        <h5 class="font-weight-bold">Export fit</h5>
                        @component("components.info-line", ['class' => 'mb-3 mt-1'])
                            On the left side of the ingame fitting window, click the wrench icon. Then at the bottom left of the page click 'Import &amp; Export' then 'Import from clipboard' to import this fit to EVE Online.
                        @endcomponent
                        <textarea class="w-100 form-control readonly" rows="20" readonly="readonly" onclick="this.focus();this.select()" style="font-family: 'Fira Code', 'Consolas', monospace">{{$fit->RAW_EFT ?? "TODO"}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card card-body shadow-sm border-0 text-center">
                @component('pvp.components.fit.victim', ["victim" => $victim]) @endcomponent
            </div>
            @component('pvp.components.fit.ship-type', ["victim" => $victim]) @endcomponent
        </div>
    </div>
@endsection
