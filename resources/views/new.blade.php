@extends("layout.app")
@section("browser-title", "Add a new run")
@section("content")

    <form action="{{route("store")}}" method="post">
        <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
            <h4 class="font-weight-bold"><img src="https://img.icons8.com/dusk/50/000000/add-file.png" class="titleicon">Add new Abyss run</h4>
        </div>
        @if(isset($errors))
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm d-flex justify-content-between">
                    <img src="https://img.icons8.com/cotton/64/000000/cancel-2--v1.png">
                    <div style="width: 100%">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endif
        @if(isset($message))
            <div class="alert alert-info">{{$message}}</div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm">
                    <h5 class="font-weight-bold">General information</h5>

                    {{csrf_field()}}
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Abyss Type</label>
                                    <select name="TYPE" class="form-control select2-default">
                                        <option
                                            {{($prev->TYPE ?? null)== "Electrical" ? "selected" : ""}} value="Electrical">
                                            Electrical
                                        </option>
                                        <option {{($prev->TYPE ?? null)== "Dark" ? "selected" : ""}} value="Dark">Dark
                                        </option>
                                        <option {{($prev->TYPE ?? null)== "Exotic" ? "selected" : ""}} value="Exotic">
                                            Exotic
                                        </option>
                                        <option
                                            {{($prev->TYPE ?? null)== "Firestorm" ? "selected" : ""}} value="Firestorm">
                                            Firestorm
                                        </option>
                                        <option {{($prev->TYPE ?? null)== "Gamma" ? "selected" : ""}} value="Gamma">
                                            Gamma
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Abyss Tier</label>
                                    <select name="TIER" id="TIER" class="form-control select2-default" required>
                                        @for($i=0;$i<7;$i++)
                                            <option {{($prev->TIER ?? null) == $i ? "selected" : ""}} value="{{$i}}">@lang("tiers.$i") (T{{$i}})</option>
                                        @endfor
                                        <option value="{{config("tracker.constants.bonus-room")}}">T5 Special Room</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Which cans did you loot?</label>
                                    <select name="LOOT_TYPE" id="" class="form-control select2-nosearch">
                                        <option {{($prev->LOOT_TYPE ?? "") == "" ? "selected" : ""}} value="">I don't
                                            remember / secret
                                        </option>
                                        <option
                                            {{($prev->LOOT_TYPE ?? "") == "BIOADAPTIVE_ONLY" ? "selected" : ""}} value="BIOADAPTIVE_ONLY">
                                            Just the bioadaptive cache
                                        </option>
                                        <option
                                            {{($prev->LOOT_TYPE ?? "") == "BIOADAPTIVE_PLUS_SOME_CANS" ? "selected" : ""}} value="BIOADAPTIVE_PLUS_SOME_CANS">
                                            Bioadaptive cache + some extraction
                                            nodes
                                        </option>
                                        <option
                                            {{($prev->LOOT_TYPE ?? "") == "BIOADAPTIVE_PLUS_MOST_CANS" ? "selected" : ""}} value="BIOADAPTIVE_PLUS_MOST_CANS">
                                            Bioadaptive cache + most extraction
                                            nodes
                                        </option>
                                        <option
                                            {{($prev->LOOT_TYPE ?? "") == "BIOADAPTIVE_PLUS_ALL_CANS" ? "selected" : ""}} value="BIOADAPTIVE_PLUS_ALL_CANS">
                                            Bioadaptive cache + all extraction
                                            nodes
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 d-none">
                                <div class="form-group">
                                    <label for="">Which day did you do this run?</label>
                                    <input type="text" class="form-control datepicker" name="RUN_DATE" value="{{date("Y-m-d")}}" required>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Did you survive?</label>
                                    <select name="SURVIVED" id="SURVIVED" class="form-control select2-nosearch">
                                        <option value="0">My ship blew up</option>
                                        <option value="1" selected>Survived</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label for="vessel">What ship/fit did you use?</label>
                                    <select type="text" class="form-control" id="vessel" name="vessel">
                                        <option value="{{$last_selected['id']}}">{{$last_selected['text']}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold">Timing
                        <img
                            class="float-right tinyicon"
                            src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png"  data-toggle="tooltip"
                            title="The EVE Api can return which system you are in. If you start the
                                    stopwatch the site will look up your location every 10 seconds. This way we will
                                    know the last time you were outside Abyss space, and also the first time when you
                                    return."></h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group" id="timer_manual">
                                    <label for="">How long did it take to return from Abyssal deadspace? <br><small>If you don't remember, or its opsec, just leave the fields empty.</small></label>

                                    <div class="input-group">
                                        <input name="RUN_LENGTH_M" id="run_length_minute" class="form-control" />
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">minute </span>
                                        </div>
                                        <input name="RUN_LENGTH_S" id="run_length_second" class="form-control" />
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">second</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="timer_auto">
                                    <small class="text-capitalize font-weight-bold text-danger pt-0">OFF</small>
                                    <p class="h1">00:00</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($stopwatch)
                                    <p class="mb-1 sw_status" id="stopwatch_enabled">Stopwatch is enabled for your account. To turn it on, click the <strong>Start stopwatch</strong> text at the bottom of this panel.</p>
                                    <p class="starting sw_status">
                                        The stopwatch is currently on standby, waiting for you to enter the Abyss. <br>
                                        <small>The stopwatch and timer is updated every 3 to 10 seconds.</small>
                                    </p>
                                    <p class="running sw_status">
                                        Good luck in the Abyss. The timer is ticking and it will automatically stop when you exit.<br>
                                        <small>The stopwatch and timer is updated every 3 to 10 seconds.</small>
                                    </p>
                                    <p class="finished sw_status">
                                        You have exited the Abyss, the run is over, the timer is stopped.<br>
                                        <small>Congratulations!</small>
                                    </p>
                                    <p class="error sw_status">
                                        <small class="text-danger">Error</small><br>
                                        There was something wrong with the ESI responses so your ESI token was removed. Please authenticate again. Please enable the stopwatch again<br>
                                        <a href="{{route("auth-scoped-start")}}" class="btn btn-sm btn-outline-primary mb-1">Re-enable stopwatch</a>
                                    </p>
                                    <p class="standby sw_status">
                                        The stopwatch is ready to start.<br>
                                        <a href="javascript:void(0)" class="text-dark" id="start_sw_2"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sport-stopwatch.png" class="mr-1 tinyicon"/>Start stopwatch</a>
                                    </p>
                                <div id="browser-notifications">
                                    <hr>

                                    @component("components.info-line")
                                        <a href="javascript:void(0)" id="browser-notifications-enable" class="text-dark">To enable browser notifications for the stopwatch please click here</a>
                                    @endcomponent
                            </div>

                                @else
                                    <p class="mb-1">To automatically measure how much time a run takes please enable the
                                        API access so we can check your location.
                                    </p>
                                    @component("components.info-line")
                                        @lang("tracker.stopwatch.note")
                                    @endcomponent
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    @if($stopwatch)
                        <a href="javascript:void(0)" class="text-dark" id="start_sw"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sport-stopwatch.png" class="mr-1 tinyicon"/>Start stopwatch</a>
                    @else
                        <a href="{{route("auth-scoped-start")}}" data-toggle="tooltip" title="This will reload this page!" class="text-dark" id="enable_sw"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sport-stopwatch.png" class="mr-1 tinyicon"/>Enable stopwatch</a>
                    @endif
                    <a href="javascript:void(0)" class="text-dark" id="stop_stopwatch"><img src="{{asset("_icons/stop-stopwatch-".App\Http\Controllers\ThemeController::getThemedIconColor().".svg")}}" alt="" class="mr-1 tinyicon">Switch to manual entry</a>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm mt-3 pb-2">
                    <h5 class="font-weight-bold">Loot</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-0 pb-0">
                                    <div class="alert alert-info border-0 shadow-sm adv">
                                        Please copy and paste your cargohold contents before and after running the
                                        filament. The site will compare the two to get which items you looted and which
                                        items you used up/lost.
                                    </div>
                                    @component("components.info-line", ['class' => "mb-2"])
                                        Please only copy items here that you looted from the Abyss. Make sure to copy from list view, not grid view. English localization only.
                                    @endcomponent
                                    <strong class="mt-2 adv">Before cargo:</strong>
                                    <textarea name="LOOT_DETAILED_BEFORE" id="LOOT_DETAILED_BEFORE" rows="4"
                                              class="form-control adv">{{$last_loot}}</textarea>
                                    <strong class="mt-2 adv">After cargo:</strong>
                                    <textarea name="LOOT_DETAILED" id="LOOT_DETAILED" rows="4"
                                              class="form-control"></textarea>
                                    <p class="text-right pt-1 mb-0">Total value is approximately <strong
                                            id="loot_value">0</strong> ISK
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 proving d-none">
                                <div class="form-group d-none">
                                    <label for="">Did the Proving Conduit spawn?</label>
                                    <select name="PVP_CONDUIT_SPAWN" class="form-control select2-nosearch">
                                        <option value="0">No, it did not</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 proving d-none">
                                <div class="form-group d-none">
                                    <label for="">Did you go into the PVP room?</label>
                                    <select name="PVP_CONDUIT_USED" class="form-control select2-nosearch">
                                        <option value="0" selected>No, I did not go into the PVP room</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="javascript:void(0)" id="advanced-loot-view" class="text-dark"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/empty-box.png" class="mr-1 tinyicon"/>My cargo is not empty!</a><span id="middot-1" class="d-inline-block mx-2">&middot;</span>
                    <a href="{{route("settings.index")}}" class="text-dark" data-toggle="tooltip" title="1.5.5 brought a new Remember Cargo toggle" target="_blank"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/settings.png" class="mr-1 tinyicon"/>Open settings</a>
                </div>
            </div>

            <div class="col-sm-12 death">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold">Death details</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Why did you lose your ship? </label>
                                <select name="DEATH_REASON" id="" class="form-control select2-nosearch">
                                    <option value="">I don't remember / secret</option>
                                    <option value="TIMEOUT">Timer ran out</option>
                                    <option value="TANK_FAILED">My tank could not handle the DPS</option>
                                    <option value="CONNECTION_DROP">Connection dropped</option>
                                    <option value="PILOTING_MISTAKE">I made a grave piloting mistake</option>
                                    <option value="PVP_DEATH">I went into the PVP room and lost</option>
                                    <option value="OVERHEAT_FAILURE">I overheated a critical module too much</option>
                                    <option value="EXPERIMENTAL_FIT">I tried an experimental fit and it didn't work
                                    </option>
                                    <option value="OTHER">Something else</option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                                <label for="">zKillboard link @component("components.info-toggle") Please only use a zKillboard link @endcomponent </label>
                                <input type="text" class="form-control" name="KILLMAIL">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm container mt-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="font-weight-bold">Privacy</h5>
                            <p>Please select what information should be visible about your run</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 p-1">
                            <div class="pickerInputGroup">
                                <input id="privacy-public" name="PUBLIC" value="1" type="radio" {{($prev->PUBLIC ?? 0) == 1 ? "checked=''" : ""}}/>
                                <label for="privacy-public">
                                    <p class="mb-1 font-weight-bold text-uppercase">Public</p>
                                    <p class="mb-1 text-small">The loot and statistics will be visible along with your name. This run will be listed in your <a target="_blank" href="{{route("profile.index", ['id' => session()->get("login_id")])}}" data-toggle="tooltip" title="Opens in a new tab">public profile</a> if its not hidden in
                                        <a href="{{route('settings.index')}}" target="_blank" data-toggle="tooltip" title="Opens in a new tab">privacy settings</a>.</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 p-1">
                            <div class="pickerInputGroup">
                                <input id="privacy-private" name="PUBLIC" value="0" type="radio" {{($prev->PUBLIC ?? 0) == 0 ? "checked=''" : ""}}/>
                                <label for="privacy-private">
                                    <p class="mb-1 font-weight-bold text-uppercase">Anonym</p>
                                    <p class="mb-1 text-small">The loot and statistics will be visible, but your name will be hidden. This will not be listed in your <a target="_blank" href="{{route("profile.index", ['id' => session()->get("login_id")])}}" data-toggle="tooltip" title="Opens in a new tab">public profile</a>, ever.</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <div class="d-flex justify-content-start asslicker">
                        <img src="https://images.evetech.net/characters/{{session()->get("login_id")}}/portrait?size=64" alt="{{session()->get('login_name')}}" class="rounded-circle shadow-sm portrait-new-run">
                        <p class="mb-0 asslicker-new-run"><span class="lead d-inline-block mr-1">o7</span>Thank you for your contribution, great <strong>{{session()->get("login_name")}}</strong></p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button type="submit" name="submit" value="view-details" class="btn btn-outline-success disable-all-on-click">Save run and view details</button>
                        <button type="submit" name="submit" value="new-run" class="btn btn-outline-success disable-all-on-click">Save run and return to this screen</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("scripts")
    <script type="text/javascript">
        window.check_status_url = "{{route("stopwatch_get", ["charId" => session()->get("login_id", 0)])}}";
        window.start_stopwatch_url = "{{route("stopwatch_start", ["charId" => session()->get("login_id")])}}";
        window.loot_detailed_url = "{{route("estimate_loot")}}";
        window.fit_newrun_select = '{{route("fit.newrun.select")}}';
        window.csrf_token = '{{csrf_token()}}';
        window.start_stopwatch_ = {{$stopwatch ? "true" : "false"}};
        window.advanced_open_ = {{$advanced_open ? "true" : "false"}};
    </script>
    <script type="text/javascript" src="{{asset("js/new-run.js")}}?version={{config("tracker.version")}}"></script>
@endsection

@section("styles")
    <style type="text/css">
        .adv {
            display: none;
        }

        div.asslicker {
            height: 18px;
        }
        p.asslicker-new-run {
            height: 1rem;
            line-height: 1rem;
        }
        img.portrait-new-run {
            position: relative;
            top: -20px;
            left: -35px;
            margin-right: -24px;
            border: 2px solid #fff;
            height: 48px;
            width: 48px;
        }
    </style>
@endsection
