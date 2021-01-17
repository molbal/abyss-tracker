@extends("layout.app")
@section("browser-title", "Alt characters")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-10">
            <h4 class="font-weight-bold">Alt characters</h4>
        </div>
        <div class="col-md-12">
            ...a
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $(".select2-nosearch-narrow").select2({
                theme: 'bootstrap',
                minimumResultsForSearch: -1,
                width: '25%'
            });
        });
    </script>
@endsection
