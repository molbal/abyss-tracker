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
                @component("components.fit_group", ["items" => $fit_quicklook["high"], "section" => "High slot modules"])@endcomponent
                @component("components.fit_group", ["items" => $fit_quicklook["mid"], "section" => "Mid slot modules"])@endcomponent
                @component("components.fit_group", ["items" => $fit_quicklook["low"], "section" => "Low slot modules"])@endcomponent
                @component("components.fit_group", ["items" => $fit_quicklook["rig"], "section" => "Rigs"])@endcomponent
                @component("components.fit_group", ["items" => $fit_quicklook["other"], "section" => "Drones or cargo"])@endcomponent
{{--                <pre>{{print_r($fit_quicklook, 1)}}</pre>--}}
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection
