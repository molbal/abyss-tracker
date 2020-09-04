@extends("layout.app")
@section("browser-title", "Tutorials")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-9">
            <h4 class="font-weight-bold">Tutorials</h4>
                @foreach($tutorials as $tutorial)
                    @component("components.tutorials.list", ['tutorial' => $tutorial]) @endcomponent
                @endforeach
        </div>
        <div class="col-sm-12 col-md-3">
            <h4 class="font-weight-bold">Submit</h4>
            <div class="card card-body border-0 shadow-sm w-100">
                <p class="text-justify mb-0 pb-0">If you know a tutorial that the community could benefit from, please submit it and I'll add it on my earliest convenience. Uploaders are always credited.</p>
            </div>
            <div class="card-footer shadow-sm">
                <a href="{{config("tracker.submit-tutorial")}}" target="_blank" class="text-dark"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/clock.png" class="mr-1 bringupper tinyicon">Submit new video</a>
            </div>
        </div>

    </div>
@endsection
@section("styles")
    <style>
        img.tutorial-uploader {
            width:  48px;
            height: 48px;

            border: 2px solid #fff;
            margin-right: 8px;
        }
    </style>
@endsection
{{--@section("scripts")--}}
{{--    <script>--}}

{{--    </script>--}}
{{--@endsection--}}
