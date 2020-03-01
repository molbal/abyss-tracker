@extends("layout.app")
@section("browser-title", "Search")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">Advanced search</h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Most common filters</h5>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Tier</label>
                                <select name="tier" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    @foreach($tiers as $tier)
                                        <option value="{{$tier->TIER}}">{{$tier->TIER}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control select2-nosearch">
                                    <option value="" selected>&nbsp;</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->TYPE}}">{{$type->TYPE}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Ship type</label><img
                                    class="float-right"
                                    src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png" data-toggle="tooltip"
                                    title="Only ships are displayed in this list which have records.">
                                <select name="type" class="form-control select2-default">
                                    <option value="" selected>&nbsp;</option>
                                    @foreach($ships as $ship)
                                        <option value="{{$ship->ID}}">{{$ship->NAME}} ({{$ship->GROUP}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")

    <script type="text/javascript">

        // When ready.
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-0d'
            });
        });
    </script>
@endsection

