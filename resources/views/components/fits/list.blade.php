@extends("layout.app")
@section("browser-title", "Fits")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Fits</h4>
        <a href="{{route("fit_new")}}" class="text-dark"><img src="_icons/fit-new-{{App\Http\Controllers\ThemeController::getThemedIconColor()}}.png" class="tinyicon mr-1">New fit</a>
    </div>
    <div class="row mt-3">
        <div class="col-sm-3">
            <form action="{{route('fit.search')}}" method="POST" id="filters">
                {{csrf_field()}}
            @component("components.collapse.collapsible-card", ["title" => "Abyss target", 'show' => true, 'icon' => 'abyss'])
                <div class="form-group">
                    <label for="TYPE">Abyss type</label>
                    <select name="TYPE" id="select_TYPE" class="form-control select2-nosearch">
                        <option value="">Any</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Dark">Dark</option>
                        <option value="Exotic">Exotic</option>
                        <option value="Firestorm">Firestorm</option>
                        <option value="Gamma">Gamma</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="TIER">Abyss tier</label>
                    <select name="TIER" id="select_TIER" class="form-control select2-nosearch">
                        <option value="">Any</option>
                        <option value="0">0 or harder</option>
                        <option value="1">1 or harder</option>
                        <option value="2">2 or harder</option>
                        <option value="3">3 or harder</option>
                        <option value="4">4 or harder</option>
                        <option value="5">5 or harder</option>
                        <option value="6">6</option>
                    </select>
                </div>
            @endcomponent

            @component("components.collapse.collapsible-card", ["title" => "Basic data", 'icon' => 'basic'])
                <div class="form-group">
                    <label for="CHAR_ID">Creator</label>
                    <select name="CHAR_ID" id="select_CHAR_ID" class="form-control select2-character">
                        <option value="">Anyone</option>
                        @foreach($users as $user)
                            <option
                                value="{{$user->CHAR_ID}}">{{$user->NAME}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="NAME">Fit name</label>
                    <input type="text" name="NAME" class="form-control">
                </div>
                <div class="form-group">
                    <label for="CHEAPER_THAN">Cheaper than</label>
                    <select name="CHEAPER_THAN" id="select_CHEAPER_THAN" class="form-control select2-nosearch">
                        <option value="">-</option>
                        <option value="50">50M ISK</option>
                        <option value="100">100M ISK</option>
                        <option value="150">150M ISK</option>
                        <option value="250">250M ISK</option>
                        <option value="300">300M ISK</option>
                        <option value="500">500M ISK</option>
                        <option value="750">750M ISK</option>
                        <option value="1000">1B ISK</option>
                        <option value="1500">1.5B ISK</option>
                        <option value="2000">2B ISK</option>
                    </select>
                </div>
                    <div class="form-group">
                        <label for="MIN_USES">Minimum uses</label>
                        <input type="number" name="MIN_USES" class="form-control" value="0">
                    </div>
            @endcomponent

            @component("components.collapse.collapsible-card", ["title" => "Ships", 'icon' => 'ship'])
                <div class="form-group">
                    <label for="SHIP">Ship hull
                        @component("components.info-toggle")
                            For optimal results only use Ship, Class or Size selectors. Set the other options to 'Any'
                        @endcomponent</label>
                    <select name="SHIP_ID" id="select_SHIP_ID" class="form-control select2-default">
                        <option value="" selected>Any</option>
                        @foreach($ships as $ship)
                            <option
                                value="{{$ship->ID}}">{{$ship->NAME}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="SHIP_GROUP">Ship class</label>
                    <select name="SHIP_GROUP" id="select_SHIP_GROUP" class="form-control select2-default">
                        <option value="" selected>Any</option>
                        @foreach($shipGroups as $group)
                            <option
                                value="{{$group->GROUP}}">{{$group->GROUP}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="SHIP_IS_CRUISER">Ship size</label>
                    <select name="SHIP_IS_CRUISER" id="select_SHIP_IS_CRUISER" class="form-control select2-default">
                        <option value="" selected>Any</option>
                        <option value="1">Cruiser</option>
                        <option value="0">Frigate</option>
                    </select>
                </div>
            @endcomponent


            @component("components.collapse.collapsible-card", ["title" => "Offense", 'icon' => 'offense'])
                @component("components.fits.filter.tag-selector") TagDroneCentric @endcomponent
                @component("components.fits.filter.tag-selector") TagEnergyWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagHybridWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagMissileWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagPrecursorWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagProjectileWeapons @endcomponent
            @endcomponent

            @component("components.collapse.collapsible-card", ["title" => "Defense", 'icon' => 'defense'])
                @component("components.fits.filter.tag-selector") TagArmorActive @endcomponent
                @component("components.fits.filter.tag-selector") TagShieldActive @endcomponent
                @component("components.fits.filter.tag-selector") TagShieldPassive @endcomponent
                @component("components.fits.filter.tag-selector") TagStrongCapacitor @endcomponent
            @endcomponent

            @component("components.collapse.collapsible-card", ["title" => "Propulsion", 'icon' => 'propulsion'])
                @component("components.fits.filter.tag-selector") TagAfterburner @endcomponent
                @component("components.fits.filter.tag-selector") TagMicrowarpdrive @endcomponent
            @endcomponent

            @component("components.collapse.collapsible-card", ["title" => "Ordering", 'icon' => 'order-by'])
                    <div class="form-group">
                        <label for="ORDER_BY">Order by</label>
                        <select name="ORDER_BY" class="form-control select2-default">
                            <option value="RUNS_COUNT" selected>Popularity</option>
                            <option value="fits.PRICE">Price</option>
                            <option value="Submitted">Upload time</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ORDER_BY_ORDER">Direction</label>
                        <select name="ORDER_BY_ORDER" class="form-control select2-default">
                            <option value="asc">Ascending</option>
                            <option value="desc" selected>Descending</option>
                        </select>
                    </div>
            @endcomponent

                <div class="card card-body border-0 shadow-sm mt-3 p-0">
                    <button type="button" class="btn btn-primary" id="doFilter">Filter this list</button>
                </div>
                <div class="card card-body border-0 shadow-sm mt-3 p-0">
                    <button type="submit" class="btn btn-secondary" data-toggle="tooltip" title="You can use this link for sharing searches">Results to new tab</button>
                </div>
                <div class="card card-body border-0 shadow-sm mt-3 p-0">
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload(true)">Reset form</button>
                </div>
        </form>
        </div>
        <div class="col-sm-9" id="results">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Showing all fits</h5>
                @component("components.fits.filter.result-list", ["results" => $results])@endcomponent
            </div>
            <div class="card-footer">
                {{$results->links()}}
            </div>
        </div>
    </div>
@endsection
@section("styles")
    <style>
        .tag-selector {
            font-size: 20px;
            font-weight: bold;
            text-decoration: none !important;
            border-radius: 100%;
            display: inline-block;
            width: 20px;
            height: 20px;
            cursor: pointer;
            border: 2px solid rgba(0, 0, 0, 0);
            text-align: center;
        }

        .card-header-icon {
            width: 24px;
            height: 24px;
            margin-right: 4px;
        }

        .tinyicon {
            width: 12px;
            height: 12px;
            margin-right: 4px;
        }

        .tag-selector:hover {
            background: rgba(127, 127, 127, 0.5);
            border: 2px solid rgba(127, 127, 127, 0.5);
        }

        .tag-selector > span {
            position: relative;
            top: -6px;
        }

        .tag-selector.active {
            background: #e3342f;
            color: #fff;
            border: 2px solid #e3342f;
            border-radius: 100%;
        }

        table.table.table-sm td {
            border: 0 solid transparent;
        }

        .moveabitdown {
            position: relative;
            top: 3px
        }

        .moveabitup {
            position: relative;
            top: -3px
        }

        .movealilbitup {
            position: relative;
            top: -1px
        }

        .vertical-align-top {
            vertical-align: top;
        }
    </style>
@endsection
@section("scripts")
    <script>
        window.fit_search_ajax = '{{route("fit.search.ajax")}}';

        function toggleTag(slot, value, ths) {
            var _this = $(ths);
            console.log(ths, _this);
            let input = $("#" + slot);
            var cv = input.val();

            _this.parent().find("span").removeClass("active");
            if (cv === "") {
                console.log("initial");
                input.val(value);
                _this.addClass('active');
            } else if (cv === value) {
                console.log("equals ", cv, value);
                input.val("");
                _this.removeClass('active');
            } else {
                console.log("different ", cv, value);
                input.val(value);
                _this.addClass('active');
            }
        };
    </script>
    <script src="{{asset("js/fits.js")}}" type="text/javascript"></script>
@endsection
