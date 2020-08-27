@extends("layout.app")
@section("browser-title", "Fits")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Fits</h4>
        <a href="{{route("fit_new")}}" class="btn btn-outline-secondary">Add new fit</a>
    </div>
    <div class="row mt-3">
        <div class="col-sm-3">
            <form action="{{route('fit.search')}}" method="POST" id="filters">
                {{csrf_field()}}
            @component("components.collapse.collapsible-card", ["title" => "Abyss target", 'show' => true, 'icon' => 'abyss'])
                <div class="form-group">
                    <label for="TYPE">Abyss type</label>
                    <select name="TYPE" class="form-control select2-nosearch">
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
                    <select name="TIER" class="form-control select2-nosearch">
                        <option value="">Any</option>
                        <option value="1">1 or harder</option>
                        <option value="2">2 or harder</option>
                        <option value="3">3 or harder</option>
                        <option value="4">4 or harder</option>
                        <option value="5">5</option>
                    </select>
                </div>
            @endcomponent

            @component("components.collapse.collapsible-card", ["title" => "Basic data", 'icon' => 'basic'])
                <div class="form-group">
                    <label for="CHAR_ID">Creator</label>
                    <select name="CHAR_ID" class="form-control select2-character">
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
                        <select name="CHEAPER_THAN" class="form-control select2-nosearch">
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
            @endcomponent

            @component("components.collapse.collapsible-card", ["title" => "Ships", 'icon' => 'ship'])
                <div class="form-group">
                    <label for="SHIP">Ship hull
                        @component("components.info-toggle")
                            For optimal results only use Ship, Class or Size selectors. Set the other options to 'Any'
                        @endcomponent</label>
                    <select name="SHIP_ID" class="form-control select2-default">
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
                    <select name="SHIP_GROUP" class="form-control select2-default">
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
                    <select name="SHIP_IS_CRUISER" class="form-control select2-default">
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
                        <label for="ORDER_BY">Ship size</label>
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
                            <option value="desc">Descending</option>
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
        function filterList() {
            var filters = $("form#filters").serializeArray();
            $("#doFilter").attr("disabled", "disabled").addClass("disabled");
            $.post('{{route("fit.search.ajax")}}', filters, function(a) {
                $("#results").css("opacity", "0.01").html(a).animate({opacity:1}, 250);
            })
            .fail(function() {
                alert("Sorry, something went wrong while searching");
            })
            .always(function() {
                $("#doFilter").removeAttr("disabled").removeClass("disabled");
            });
        }


        function formatState (state) {
            var $state = $(state);
            return $state;
        }

        $(".select2-character").select2({
            theme: 'bootstrap',
            templateResult: function (state) {
                console.log(state);
                if (!state.id) { return state.text; }
                if (state.element.value.toLowerCase() === "0") {
                    return $('<span class="text-center">'+state.text+'</span>');
                }
                var $state = $(
                    '<span><img style="width: 24px; height: 24px" src="https://images.evetech.net/characters/' +  state.element.value.toLowerCase() +
                    '/portrait?size=32" class="rounded-circle shadow-sm movealilbitup" /> ' +
                    state.text +     '</span>'
                );
                return $state;
            },
            width: '100%',
        });


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
        }

        $(function () {
            $("#doFilter").click(filterList);
        });
    </script>
@endsection
