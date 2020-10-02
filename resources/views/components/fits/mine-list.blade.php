@extends("layout.app")
@section("browser-title", "Fits")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">My fits</h4>
        <a href="{{route("fit_new")}}" class="text-dark"><img src="_icons/fit-new-{{App\Http\Controllers\ThemeController::getThemedIconColor()}}.png" class="tinyicon mr-1">New fit</a>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12" id="results">
            <div class="card card-body border-0 shadow-sm pb-0">
                <h5 class="font-weight-bold">My fits</h5>
                <p>Here is a list of all the fits you submitted</p>
                @component("components.fits.filter.result-list", ["results" => $results, "admin" => true])@endcomponent
            </div>
{{--            <div class="card-footer">--}}
{{--                {{$results->links()}}--}}
{{--            </div>--}}
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
