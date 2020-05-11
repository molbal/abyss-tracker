@extends("layout.app")
@section("browser-title", "Fits")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Fits</h4>
    </div>
    <div class="row mt-3">
        <div class="col-sm-3">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Abyss target</h5>
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
            </div>

            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Ship type
                    @component("components.info-toggle")
                        For optimal results only use one of these options. Set the others to "Any"
                    @endcomponent
                </h5>
                <div class="form-group">
                    <label for="SHIP">Ship hull</label>
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
            </div>


            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Offense</h5>
                @component("components.fits.filter.tag-selector") TagDroneCentric @endcomponent
                @component("components.fits.filter.tag-selector") TagEnergyWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagHybridWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagMissileWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagPrecursorWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagProjectileWeapons @endcomponent
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Defense</h5>
                @component("components.fits.filter.tag-selector") TagArmorActive @endcomponent
                @component("components.fits.filter.tag-selector") TagProjectileWeapons @endcomponent
                @component("components.fits.filter.tag-selector") TagShieldPassive @endcomponent
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Propulsion</h5>
                @component("components.fits.filter.tag-selector") TagAfterburner @endcomponent
                @component("components.fits.filter.tag-selector") TagMicrowarpdrive @endcomponent
            </div>

            <div class="card card-body border-0 shadow-sm mt-3 p-0">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
        </div>
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Result list</h5>
                <table class="table table-sm">
                    <tr>
                        <td>&nbsp;</td>
                        <td class="text-muted text-left">Name</td>
                        <td class="text-muted text-right">Total DPS</td>
                        <td class="text-muted text-right">Total tank</td>
                        <td class="text-muted text-right">Max speed</td>
                        <td class="text-muted text-right">Total cost</td>
                    </tr>
                    @forelse($results as $row)
                        @component("components.fits.filter.result-row", ["row" => $row])@endcomponent
                    @empty
                        <tr>
                            <td>Empty</td>
                        </tr>
                    @endforelse
                </table>
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

        table.table.table-sm td{
            border: 0 solid transparent;
        }
    </style>
@endsection
@section("scripts")
    <script>
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
        });
    </script>
@endsection
