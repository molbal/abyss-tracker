@extends("layout.app")
@section("browser-title", $ship_name." fit")
@section("content")
    <div class="d-flex justify-content-between align-items-center mb-1 mt-5">
        <span class="fit-header-line">
            <h4 class="font-weight-bold fit-title d-inline-block mb-0">{{$fit->NAME}}</h4>
            @component('components.fits.patch-tag', ['status' => $fit->LAST_PATCH]) @endcomponent
        </span>
        <small class="ml-3" data-toggle="tooltip" title="The fit number uniquely identifies a fit on the Abyss Tracker.">Fit #{{$id}}</small>
    </div>
    @if($id != $lastRevision)
        <div class="card card-body border-info shadow-sm mb-3 p-2">
            <div class="d-flex justify-content-start  align-items-center">
                <img src="https://img.icons8.com/cotton/64/000000/info--v1.png" class="mr-3" style="height: 32px; width: 32px"/>
                <span>
                    This fit has a newer version. To see the changes, go to <a class="font-italic" data-toggle="tab" href="javascript:void(0)" onclick="$('#history_a').tab('show')">History</a> or <a class="font-italic" href="{{route('fit_single', ['id' => $lastRevision])}}">jump to the latest revision</a>.
                </span>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-8">

            @if (session()->has('message') || (isset($errors) && $errors->any()))
                <div class="wizard-message border-{{session('messageType', 'danger')}} mb-3" style="border-width: 0 0 0 3px; border-style: solid">
                    <div>
                        {!! config('new-fit-wizard.images.'.session('messageType', 'danger')) !!}
                    </div>
                    <div>
                        <h4>Message</h4>
                        {{ session('message') }}
                        <ul style="list-style: none" class="p-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if(strtoupper($fit->STATUS) == "DONE" && intval(json_decode($fit->STATS)->offense->weaponDps) == 0)
                <div class="card card-body border-warning shadow-sm mb-3 p-2">
                    <div class="d-flex justify-content-start align-items-center">
                        {!! config('new-fit-wizard.images.alert') !!}
                        <span>
                        This fit's weapon DPS is 0. Maybe the submitter forgot to load ammo before uploading the fit or this fit only relies on drones.
                        </span>
                    </div>
                </div>
            @endif
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Modules</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eft">Export</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#history" id="history_a">History</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#questions">Questions {{$questions->count() > 0 ? '('.$questions->count().')' : ''}}</a></li>
                @if (\App\Http\Controllers\Auth\AuthController::isItMe($fit->CHAR_ID))
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#settings"><span class="text-danger">Settings</span></a></li>
                @endif
            </ul>
            <div class="card card-body border-0 shadow-sm pt-3">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        @component("components.fits.display-structured", ['fit' => $fit, 'fit_quicklook' => $fit_quicklook, 'ship_name' => $ship_name, 'ship_price' => $ship_price, 'items_price' => $items_price]) @endcomponent
                    </div>
                    <div id="eft" class="tab-pane fade">
                        <h5 class="font-weight-bold">Export fit</h5>
                        @component("components.info-line", ['class' => 'mb-3 mt-1'])
                            On the left side of the ingame fitting window, click the wrench icon. Then at the bottom left of the page click 'Import &amp; Export' then 'Import from clipboard' to import this fit to EVE Online.
                        @endcomponent
                        <textarea class="w-100 form-control readonly" rows="20" readonly="readonly" onclick="this.focus();this.select()" style="font-family: 'Fira Code', 'Consolas', monospace">{{$fit->RAW_EFT}}</textarea>
                        <hr>
                        <a href="{{$eveworkbenchLink}}" class="text-dark" rel="nofollow" target="_blank">Export fit to Eve Workbench</a>
                    </div>
                    <div id="history" class="tab-pane fade">
                        <h5 class="font-weight-bold">History</h5>
                        @component("components.fits.history-full", ['history' => $history]) @endcomponent
                    </div>
                    <div id="questions" class="tab-pane fade">
                        <h5 class="font-weight-bold">Questions &amp; Answers</h5>
                        @component("components.fits.comments", ['fit' => $fit, 'questions' => $questions]) @endcomponent
                    </div>
                    @if (\App\Http\Controllers\Auth\AuthController::isItMe($fit->CHAR_ID))
                        <div id="settings" class="tab-pane fade">
                            <h5 class="font-weight-bold">Fit privacy</h5>
                            @component("components.fits.settings", ['fit' => $fit]) @endcomponent
                        </div>
                    @endif
                </div>

            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Maximum suggested Abyssal difficulty</h5>
                @component('components.fits.recommendations', ['recommendations' => $recommendations]) @endcomponent
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Description</h5>
                {!! $embed !!}
                <div class="text-justify">
                    {!! $description ?? "<p class='py-2 text-center text-italic'>No description provided</p>" !!}
                </div>
{{--                <p class="text-right text-small">--}}
{{--                    - {{$fit->SUBMITTED}}--}}
{{--                </p>--}}
            </div>
            @if($fit->VIDEO_LINK)
                <div class="card-footer">
                    <a class="text-dark" href="{{$fit->VIDEO_LINK}}" target="_blank"><img src="https://img.icons8.com/small/24/eeeeee/signpost.png" class="tinyicon mr-2">Video guide</a>
                </div>
            @endif
        </div>
        <div class="col-sm-4">
            <div class="card card-body shadow-sm border-0 text-center">
                @component('components.fits.fit-uploader', ["fit" => $fit, "char_name" => $char_name, 'eve_workbench_url' => $eve_workbench_url]) @endcomponent
            </div>
            @component('components.fits.ship-type', ['fit' => $fit, 'ship_name' => $ship_name, 'ship_type' => $ship_type]) @endcomponent
            @if(strtoupper($fit->STATUS) == "DONE")
                @component('components.fit_stats', ["stats" => $fit->STATS]) @endcomponent
            @elseif(strtoupper($fit->STATUS) == "QUEUED")
                <div class="card card-body border-warning shadow-sm text-center mt-3">
                    <div class="mb-0">
                        <img src="{{asset('loader.png')}}" style="width: 64px; height: 64px"/>
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
            <div class="card card-body border-0 shadow-sm p-0 rounded-b-none">
                <div class="h-300px graph-container">{!! $popularity->container() !!}</div>
            </div>
            <div class="card-footer">
                @component('components.info-line')
                    Data source: Abyss Tracker, public and private abyss runs by all characters. The graph refreshes once in 15 minutes.
                @endcomponent
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-8">
            @component("components.runs.list", ['title' => "Runs with this fit (".$runs->total().")", 'items' => $runs]) @endcomponent
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

            <div class="card card-body border-0 shadow-sm p-0 mt-3 rounded-b-none">
                <h5 class="font-weight-bold mb-2 p-3">Loot strategy with this fit</h5>
                <div class="h-400px graph-container">{!! $loots->container() !!}</div>
            </div>
            <div class="card-footer">
                @component('components.info-line')
                    Data source: Abyss Tracker, user submissions.
                @endcomponent
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
        <p>THere are {{count($fitIdsAll)}} almost identical fits to this one (which are counted against loot and popularity statistics). {{count($fitIdsAll)-count($fitIdsNonPrivate)}} are private so the list below shows {{count($fitIdsNonPrivate)}} fits:</p>
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
    <script src="{{asset('js/fit.js')}}" type="text/javascript"></script>
@endsection
