@extends("layout.app")
@section("browser-title", "Error")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-8 offset-md-2 mt-5 text-center">
            <img src="{{\App\Http\Controllers\ThemeController::getGlitchIcon()}}" alt="" style="height: 160px;" class="mb-3">
            <div class="card mb-5 text-left shadow">
                <div class="card-header">
                    Not found
                </div>
                <div class="card-body shadow-sm border-0 mb-0">
                    <p class="lead mb-0 pb-0">Error 404</p>
                </div>
                <div class="card-footer shadow-sm d-flex justify-content-between">
                    <a href="{{route("home")}}" class="text-dark text-left w-25 d-inline-block">Go to homepage</a>
                    <a target="_blank" href="{{route('community.discord')}}" class="text-dark text-center w-25 d-inline-block">Get help on Discord</a>
                    <a target="_blank" href="https://github.com/molbal/abyss-tracker/issues/new?assignees=&labels=&template=bug_report.md&title=" class="text-dark text-right w-25 d-inline-block">Submit bug</a>
                </div>
            </div>
        </div>
    </div>
    <div class="my-5">&nbsp;</div>
    <div class="my-5">&nbsp;</div>
@endsection
