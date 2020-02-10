@extends("layout.app")
@section("browser-title", "Add a new run")
@section("content")

    <form action="{{route("store")}}" method="post">
        <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
            <h4 class="font-weight-bold"><img src="https://img.icons8.com/dusk/50/000000/add-file.png"> Add new Abyss
                run
            </h4>
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
                                    <select name="TIER" id="TIER" class="form-control select2-default">
                                        <option {{($prev->TIER ?? null) == 1 ? "selected" : ""}}>1</option>
                                        <option {{($prev->TIER ?? null) == 2 ? "selected" : ""}}>2</option>
                                        <option {{($prev->TIER ?? null) == 3 ? "selected" : ""}}>3</option>
                                        <option {{($prev->TIER ?? null) == 4 ? "selected" : ""}}>4</option>
                                        <option {{($prev->TIER ?? null) == 5 ? "selected" : ""}}>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Did you survive?</label>
                                    <select name="SURVIVED" id="SURVIVED" class="form-control select2-nosearch">
                                        <option value="0">My ship blew up</option>
                                        <option value="1" selected>Survived</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Submit with your name or anonymus?</label>
                                    <select name="PUBLIC" class="form-control select2-default">
                                        <option value="0" {{($prev->PUBLIC ?? 0) == 0 ? "selected" : ""}}>Submit as
                                            anonymus
                                        </option>
                                        <option value="1" {{($prev->PUBLIC ?? 0) == 1 ? "selected" : ""}}>Submit with my
                                            name
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Which day did you do this run?</label>
                                    <input type="text" class="form-control datepicker" name="RUN_DATE" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">What ship did you fly?</label>
                                    <select name="SHIP_ID" class="form-control select2-default">
                                        <option {{($prev->SHIP_ID ?? "") == "" ? "selected" : ""}} value="">I don't
                                            remember / secret
                                        </option>
                                    @foreach($ships as $ship)
                                        <!--  {{$prev->SHIP_ID ?? "undefined"}} vs {{$ship->ID}} -->
                                            <option
                                                value="{{$ship->ID}}" {!! ($prev->SHIP_ID ?? 0) == $ship->ID ? "selected='selected'" : ""!!}>
                                                {{$ship->NAME}} ({{$ship->GROUP}})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold">Timing</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group" id="timer_manual">
                                    <label for="">How long did it take to return from Abyssal deadspace?</label>
                                    <select name="RUN_LENGTH" class="select2-default form-control">
                                        <option value="">I don't remember / secret</option>
                                        @for($sec = 0; $sec <= 1200; $sec += 10)
                                            <option value="{{$sec}}">{{intval($sec/60)}}m {{$sec%60}}s</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold">Loot questions</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="" class="d-flex justify-content-between">
                                        <span>How much loot did you return with? <a href="javascript:void(0)"
                                                                                    id="advanced-loot-view">My cargo
                                            is not empty!</a>
                                            </span>
                                        <span>
                                            <a href="/how-to-loot.gif" target="_blank">How to use?</a>
                                        <img
                                            src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png"
                                            data-toggle="tooltip"
                                            title="Please copy the loot from your inventory (list view!) and paste it here. Please only use English language.">
                                        </span></label>
                                    <div class="alert alert-info border-0 shadow-sm adv">
                                        Please copy and paste your cargohold contents before and after running the filament. The site will compare the two to get which items you looted and which items you used up/lost.
                                    </div>
                                    <div class="text-muted">
                                        Please only copy items here that you looted from the Abyss. If you went into the Proving conduit and destroyed another player's ship, do not paste his loot here!
                                    </div>
                                    <strong class="mt-2 adv">Before cargo:</strong>
                                    <textarea name="LOOT_DETAILED_BEFORE" id="LOOT_DETAILED_BEFORE" rows="4" class="form-control adv"></textarea>
                                    <strong class="mt-2 adv">After cargo:</strong>
                                    <textarea name="LOOT_DETAILED" id="LOOT_DETAILED" rows="4" class="form-control"></textarea>
                                    <p class="text-right">Total value is approximately <strong
                                            id="loot_value">0</strong> ISK
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">How much did you loot?</label>
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
                            <div class="col-sm-4 proving">
                                <div class="form-group">
                                    <label for="">Did the Proving Conduit spawn?</label>
                                    <select name="PVP_CONDUIT_SPAWN" class="form-control select2-nosearch">
                                        <option value="">I don't remember</option>
                                        <option value="1">Yes, it spawned</option>
                                        <option value="0">No, it did not</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 proving">
                                <div class="form-group">
                                    <label for="">Did you go into the PVP room?</label>
                                    <select name="PVP_CONDUIT_SPAWN" class="form-control select2-nosearch">
                                        <option value="">I don't remember</option>
                                        <option value="1">Yes, I went into the PVP room</option>
                                        <option value="0">No, I did not go into the PVP room</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 death">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold">Death details</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Why did you lose your ship?&nbsp;<img
                                        src="https://img.icons8.com/small/16/000000/info.png" data-toggle="tooltip"
                                        title="A lot of reasons can contribute to losing a ship. Select the one you think contributed most to this loss."></label>
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
                                <label for="">If you died you can share your lossmail&nbsp;<img
                                        src="https://img.icons8.com/small/16/000000/info.png" data-toggle="tooltip"
                                        title="Please use a zKillboard link"></label>
                                <input type="text" class="form-control" name="KILLMAIL">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <p>Thank you for your contribution, {{session()->get("login_name")}}</p>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-success">Save run</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("scripts")
    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        }).val("{{date("Y-m-d")}}");

        function setProvingConduit() {
            var tier = $("#TIER").val();
            var $proving = $(".proving");
            switch (tier) {
                case '3':
                case '4':
                case '5':
                    $proving.show();
                    break;
                default:
                    $proving.hide();
                    break;
            }
        }

        function setDeathReason() {
            var death = $("#SURVIVED").val();
            var dth = $(".death");
            switch (death) {
                case '0':
                    dth.show();
                    break;
                default:
                    dth.hide();
                    break;
            }

        }

        $("#LOOT_DETAILED").change(function () {
            $("#loot_value").html("...");
            $.ajax({
                method: "POST",
                url: "{{route("estimate_loot")}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "LOOT_DETAILED": $("#LOOT_DETAILED").val()
                }
            }).done(function (msg) {
                console.log(msg);
                sum = JSON.parse(msg);
                $("#loot_value").html(sum.formatted);
            });

        });

        function advancedView() {
            $("#advanced-loot-view").hide();
            $(".adv").slideDown(230);
        }

        // When ready.
        $(function () {
            setProvingConduit();
            setDeathReason();
            $("#TIER").change(setProvingConduit);
            $("#SURVIVED").change(setDeathReason);
            $("#advanced-loot-view").click(advancedView);

            var $form = $("form");
            $form.submit(function (e) {
            });
        });
    </script>
@endsection

@section("styles")
    <style type="text/css">
        .adv {
            display: none;
        }
    </style>
    @endsection
