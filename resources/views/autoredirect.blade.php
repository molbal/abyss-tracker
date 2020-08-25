@extends("layout.app")
@section("browser-title", "Error")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-8 offset-md-2">
            <div class="card card-body shadow-sm border-0">
                <div class="d-flex justify-content-start">
                    <img src="https://img.icons8.com/wired/128/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/circled-right-2.png" style="width: 64px;height: 64px;"/>
                    <div>
                        <h4 class="font-weight-bold">{{$title}}</h4>
                        {{$message}}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{$redirect}}" class="text-dark">Redirect now</a>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script>
        $(function () {
            setTimeout(function () {
                window.location = '{{$redirect}}';
            }, {{$timeout ?? 3000}});
        });
    </script>
@endsection
