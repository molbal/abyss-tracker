@extends("layout.app")
@section("browser-title", "Tutorials")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Tutorials</h4>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                @foreach($tutorials as $tutorial)
                    @component("components.tutorials.list", ['tutorial' => $tutorial]) @endcomponent
                @endforeach
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

    </script>
@endsection
