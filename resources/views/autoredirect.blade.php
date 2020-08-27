@extends("layout.app")
@section("browser-title", "Redirecting...")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-8 offset-md-2">
            <div class="card card-body shadow-sm border-0 p-0">
                <div id="pb-outer" class="">
                    <div id="pb-inner">&nbsp;</div>
                </div>
                <div class="d-flex justify-content-start p-3">
                    <img src="https://img.icons8.com/wired/128/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/circled-right-2.png" style="width: 64px;height: 64px;" class="mr-3"/>
                    <div>
                        <h4 class="font-weight-bold">{{$title}}</h4>
                        {{$message}}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{$redirect}}" class="text-dark" id="redirect"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/advance.png"/><span>Redirect now</span></a>
            </div>
        </div>
    </div>
@endsection
@section("styles")
    <style>
        #pb-outer {
            width: 100%;
            height: 3px;
            margin: 0;
            padding: 0;
            border: 0;
        }

        #pb-inner {
            width: 100%;
            height: 2px;
            margin: 0;
            padding: 0;
            background: #dc3545;
            border: 1px solid #992833;
            border-width: 0 0 1px 0;
        }
    </style>

@endsection
@section("scripts")
<script>
        $(function () {
            setTimeout(function () {
                    window.location = '{{$redirect}}';
            }, {{$timeout ?? 3000}});

            $("#pb-inner").animate({
                width: '0px'
            }, {{$timeout ?? 3000}}, function () {
                $('#redirect').find('span').html("Redirecting...");
            });
        });
    </script>
@endsection
