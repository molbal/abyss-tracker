@extends("layout.app")
@section("browser-title", $ship_name." fit")
@section("content")
    <div class="d-flex justify-content-between align-items-center mb-1 mt-5">
        <h4 class="font-weight-bold fit-title">{{$fit->NAME}}</h4><small class="ml-3">Fit #{{$id}}</small>
    </div>
    <div class="row">
        <div class="col-sm-8">

            @if(strtoupper($fit->STATUS) == "DONE" && intval(json_decode($fit->STATS)->offense->weaponDps) == 0)
                <div class="card card-body border-warning shadow-sm mb-3">
                    <div class="d-flex justify-content-start">
                        <img src="https://img.icons8.com/cotton/64/000000/error--v1.png" class="mr-3"/>
                        <span>
                        This fit's weapon DPS is 0. Maybe the submitter forgot to load ammo before uploading the fit or this fit only relies on drones.
                        </span>
                    </div>
                </div>
            @endif
{{--            <ul class="nav nav-tabs" id="myTab" role="tablist">--}}
{{--                <li class="nav-item" role="presentation">--}}
{{--                    <a class="nav-link active" id="tab-head-distribution" data-toggle="tab" href="#tab-distribution" role="tab" aria-controls="home" aria-selected="true">Loot values</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item" role="presentation">--}}
{{--                    <a class="nav-link" id="tab-head-activity" data-toggle="tab" href="#tab-activity" role="tab" aria-controls="profile" aria-selected="false">Abyss activity (daily)</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Modules</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eft">Export</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#history">History</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#render3d">3D</a></li>
                @if (session()->get("login_id", -1) == $fit->CHAR_ID)
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#settings"><span class="text-danger">Settings</span></a></li>
                @endif
            </ul>
            <div class="card card-body border-0 shadow-sm pt-3">


                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <table class="table table-responsive-sm table-sm w-100 mb-4">
                            @component("components.fit_group", ["items" => $fit_quicklook["high"], "section" => "High slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["mid"], "section" => "Mid slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["low"], "section" => "Low slot modules"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["rig"], "section" => "Rigs"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["drone"], "section" => "Drones"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["ammo"], "section" => "Ammunition"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["booster"], "section" => "Boosters"])@endcomponent
                            @component("components.fit_group", ["items" => $fit_quicklook["cargo"], "section" => "Other cargo and implants"])@endcomponent
                            <tr>
                                <td colspan="3" class="font-weight-bold text-right">Total without ship: {{number_format($items_price, 0, ","," ")}} ISK</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-left text-uppercase font-weight-bold">Ship</td>
                            </tr>
                            <tr>
                                <td style="width: 36px;">
                                    <img src="https://imageserver.eveonline.com/Type/{{$fit->SHIP_ID}}_64.png" alt="{{$ship_name}} icon" class="fit-item-icon">
                                </td>
                                <td>
                                    {{$ship_name}}
                                </td>
                                <td class="text-right">
                                    {{number_format($ship_price, 0, ",", " ")}} ISK
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="font-weight-bold text-right">Total: {{number_format($ship_price+$items_price, 0, ","," ")}} ISK</td>
                            </tr>
                        </table>
                    </div>
                    <div id="eft" class="tab-pane fade">
                        <h5 class="font-weight-bold">Export fit</h5>
                        @component("components.info-line", ['class' => 'mb-3 mt-1'])
                            On the left side of the ingame fitting window, click the wrench icon. Then at the bottom left of the page click 'Import &amp; Export' then 'Import from clipboard' to import this fit to EVE Online.
                        @endcomponent
                        <textarea class="w-100 form-control readonly" rows="20" readonly="readonly" onclick="this.focus();this.select()"
                                  style="font-family: 'Fira Code', 'Consolas', fixed">{{$fit->RAW_EFT}}</textarea>
                    </div>
                    <div id="history" class="tab-pane fade">
                        <h5 class="font-weight-bold">History</h5>
                        <table class="table table-sm w-100">
                            <tr>
                                <th>Datetime</th>
                                <th>Event</th>
                                <th>Fit version</th>
                            </tr>
                            @forelse($history as $item)
                                @component("components.fits.fithistory", ['item'=>$item]) @endcomponent
                            @empty
                                <tr>
                                   <td colspan="3">
                                       <p class="py-5 text-center font-italic text-muted">No fit history available</p>
                                   </td>
                                </tr>
                            @endforelse
                        </table>
                        <hr>
                        @component("components.info-line")
                            @lang("fits.records-notice", ['date' => config("tracker.fit.logs.initial-date")])
                        @endcomponent
                    </div>
                    <div id="render3d" class="tab-pane fade">
                        <h5 class="font-weight-bold">3D view</h5>
                        TBA
                    </div>
                    @if (session()->get("login_id", -1) == $fit->CHAR_ID)
                        <div id="settings" class="tab-pane fade">
                            <h5 class="font-weight-bold">Fit privacy</h5>
                            <p class="mb-3">You submitted this fit so you can delete it or modify its privacy.</p>
                            <div class="btn-group mb-2 d-block">
                                <a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'public'])}}" class="btn btn-outline-secondary">Set privacy to 'Public'
                                </a><a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'incognito'])}}" class="btn btn-outline-secondary">Set privacy to 'Anonym'
                                </a><a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'private'])}}" class="btn btn-outline-secondary">Set privacy to 'Private'
                                </a>
                            </div>
                            <h5 class="font-weight-bold mt-5">Upgrade fit</h5>
                            <p class="mb-3">To upgrade a fit's version</p>
                            <div class="btn-group mb-2 d-block">
                                <a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'public'])}}" class="btn btn-outline-secondary">Set privacy to 'Public'
                                </a><a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'incognito'])}}" class="btn btn-outline-secondary">Set privacy to 'Anonym'
                                </a><a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'private'])}}" class="btn btn-outline-secondary">Set privacy to 'Private'
                                </a>
                            </div>
                            <h5 class="font-weight-bold text-danger mt-5">Danger zone</h5>
                            <p>If you want to delete this fit, you may click the red link: <a href="{{route("fit.delete", ['id' => $fit->ID])}}" class="text-danger">Delete fit</a></p>


                        </div>
                    @endif
                </div>

            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Maximum suggested Abyssal difficulty</h5>
                <table class="w-100 table-sm">
                    <tr>
                        @foreach(['DARK','ELECTRICAL','EXOTIC','FIRESTORM','GAMMA'] as $type)
                            <td class="text-center" style="width: 20%">
                                <p class="h3 mb-1">
                                    @if($recommendations->$type == 0)
                                        <img src="_icons/unavailable.png" class="smallicon" alt="Nope" data-toggle="tooltip" title="Not recommended for any {{strtolower($type)}} runs">
                                        @else
                                        {{$recommendations->$type}}
                                    @endif
                                </p>
                                <img src="types/{{ucfirst(strtolower($type))}}.png"  class="tinyicon" alt=""> {{ucfirst(strtolower($type))}}
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Description</h5>
                {!! $embed !!}
                <div class="text-justify">
                    {!! $description ?? "<p class='py-2 text-center text-italic'>No description provided</p>" !!}
                </div>
                <p class="text-right text-small">
                    - {{$fit->SUBMITTED}}
                </p>
            </div>
            @if($fit->VIDEO_LINK)
                <div class="card-footer">
                    <a class="btn btn-outline-info" href="{{$fit->VIDEO_LINK}}" target="_blank">Video guide</a>
                </div>
            @endif
        </div>
        <div class="col-sm-4">
            <div class="card card-body shadow-sm border-0 text-center">
                @if($fit->PRIVACY == 'public')
                    <div class="text-small">
                        <img src="https://images.evetech.net/characters/{{$fit->CHAR_ID}}/portrait?size=256" alt="{{$char_name}}"  id="char_prof">
                        <br>
                        <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="h5 font-weight-bold text-dark mb-1 d-inline-block">{{$char_name}} </a>
                        <br>
                        <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="text-muted mx-1 ">profile</a> &centerdot;
                        <a href="{{route("fit.search", ['CHAR_ID' => $fit->CHAR_ID])}}" class="text-muted mx-1 ">fits</a> &centerdot;
                        <a href="https://zkillboard.com/character/{{$fit->CHAR_ID}}/" target="_blank" class="text-muted mx-1 ">killboard</a> &centerdot;
                        <a href="{{$eve_workbench_url}}" target="_blank" class="text-muted mx-1 ">eve workbench</a>
                    </div>
                @else
                    <p class="mb-0">This is an anonym fit, so its uploader is hidden.</p>
                @endif
            </div>
            <div class="card card-body shadow-sm border-0 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="" style="width: 191px; text-align: center;">
                            <img src="https://images.evetech.net/types/{{$fit->SHIP_ID}}/render?size=128"
                                 id="ship_prof">
                            <br>
                            <div>
                                <h2 class="font-weight-bold mb-0 mt-3" style="line-height: 1.6rem">
                                    <a class="text-dark" href="{{route("ship_single", ["id" => $fit->SHIP_ID])}}">{{$ship_name}}</a>
                                </h2>
                                <small class="text-muted font-weight-bold">{{$ship_type}}</small>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="infolinks text-small">
                            <li><a href="{{route('ship_single', ['id' => $fit->SHIP_ID])}}" class="text-muted">ship usage</a></li>
                            <li><a href="{{route('fit.search', ['SHIP_ID' => $fit->SHIP_ID])}}" class="text-muted">ship fits</a></li>
                            <li><a href="https://zkillboard.com/ship/{{$fit->SHIP_ID}}/" target="_blank" class="text-muted">killboard</a></li>
                            <li><a href="https://www.eveworkbench.com/fitting/search?q={{$ship_name}}" target="_blank" class="text-muted">eve wbench</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @if(strtoupper($fit->STATUS) == "DONE")
                @component('components.fit_stats', ["stats" => $fit->STATS])@endcomponent
            @elseif(strtoupper($fit->STATUS) == "QUEUED")
                <div class="card card-body border-warning shadow-sm text-center mt-3">
                    <div class="mb-0">
                        <img src="https://img.icons8.com/cotton/64/000000/clock-settings.png" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Calculating stats</h5>
                        <p class="mb-0">Please reload this page in a few minutes once we have calculated its stats.</p>
                    </div>
                </div>
            @else
                <div class="card card-body border-warning shadow-sm text-center mt-3">
                    <div class="mb-0">
                        <img src="https://img.icons8.com/cotton/64/000000/cancel--v1.png" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Error</h5>
                        <p class="mb-0">The EFT fit is probably broken or we have an error in the system and could not calculate stats</p>
                    </div>
                </div>
            @endif


        </div>
    </div>


    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">{{$fit->NAME}} usage</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm p-0">
                <h5 class="font-weight-bold mb-2 p-3">Popularity over the last 3 months <small class="float-right">This graph shows the percentage of Abyss runs using/day using a this fit</small></h5>
                <div class="h-300px graph-container">{!! $popularity->container() !!}</div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-8">
            @component("components.runs.list", ['title' => "Runs with this fit", 'items' => $runs]) @endcomponent
        </div>

        <div class="col-xs-12 col-sm-4">

            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Fit performance</h5>
                <p class="mb-0">The information below was calculated from {{$runsCountAll}} user submitted runs (displayed left).</p>
            </div>
            @forelse($breaksEven as $info)
                @component("components.fits.ds.break-even", ['info'=>$info, 'price' => $fit->PRICE]) @endcomponent
            @empty
                <div class="card card-body border-0 shadow-sm text-center text-justify mt-3">
                    <p class="mb-0">Nothing submitted yet to calculate stats from.</p>
                </div>
            @endforelse

            <div class="card card-body border-0 shadow-sm p-0 mt-3">
                <h5 class="font-weight-bold mb-2 p-3">Loot strategy with this fit</h5>
                <div class="h-400px graph-container">{!! $loots->container() !!}</div>
            </div>

        </div>
    </div>


    @if (count($fitIdsAll) > 1)
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Almost identical fits</h4>
            @component("components.info-toggle")
                Fits with the same modules fitted to their high, mid, and low slots + same rigs are counted 'Almost identical'. This section only shows up if there are identical fits.
            @endcomponent
    </div>

    <div class="card card-body border-0 shadow-sm mt-3">
        <p>This fit has {{count($fitIdsAll)}} almost identical fits (which are counted against loot and popularity statistics). Out of these fits, {{count($fitIdsNonPrivate)}} are not set to private:</p>
        @component("components.fits.filter.result-list", ["results" => $similars]) @endcomponent
        @if($fitIdsAll > $fitIdsNonPrivate)
            <p class="italic mb-0">+ {{(count($fitIdsAll) - count($fitIdsNonPrivate))}} hidden fit(s).</p>
        @endif
    </div>
    @endif


@endsection
@section("styles")
    <link rel="stylesheet" href="{{asset("css/fit-only.css")}}">
@endsection
@section("scripts")
    {!! $popularity->script() !!}
    {!! $loots->script() !!}
@endsection
