@extends("layout.app")
@section("browser-title", "Search")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">Advanced search</h4>
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
