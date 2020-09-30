@extends("layout.app")
@section("browser-title", "Fits")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Fits</h4>
        <a href="{{route("fit_new")}}" class="btn btn-outline-secondary">Add new fit</a>
    </div>
    <div class="row mt-3">
        <div class="col-sm-3">
            @component("components.collapse.collapsible-card", ["title" => "Displaying ".$results->count()." fits", 'show' => true, 'icon' => 'runs-search.search'])
                <p>With the following filters:</p>
                @forelse($filters as $filter)
                    <span class="badge badge-secondary m-1 text-wrap" style="font-size: 0.9em">{{$filter}}</span>
                    @empty
                    <p>No filter applied</p>
                @endforelse
            @endcomponent

            <div class="card card-body border-0 shadow-sm mt-3 p-0">
                <a href="{{route("fit.index")}}" class="btn btn-primary">New search</a>
            </div>

        </div>
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Result list</h5>
                @component("components.fits.filter.result-list", ["runs-search.results" => $results])@endcomponent
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

        .vertical-align-top {
            vertical-align: top;
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
