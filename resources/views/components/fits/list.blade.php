@extends("layout.app")
@section("browser-title", "Fits")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Fits</h4>
    </div>
    <div class="row mt-3">
        <div class="col-sm-3">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Filter</h5>

            </div>
        </div>
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Result list</h5>

            </div>
        </div>
    </div>
@endsection
@section("styles")
    <style>
    </style>
@endsection
@section("scripts")
    <script>
        $(function () {
        });
    </script>
@endsection
