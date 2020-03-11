@extends("layout.app")
@section("browser-title", "Error")
@section("content")
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm">
                <img src="https://images.evetech.net/characters/{{$id}}/portrait?size=128" class="rounded-circle shadow-sm">
                <h4 class="font-weight-bold ">{{$name}}</h4>
            </div>
        </div>
    </div>
@endsection

@section("styles")
    <style type="text/css">
        #banner {
            background: url("/profile.jpg");
            background-size: cover;
            display: flex;
            height: 128px;
            border-radius: 8px 8px 0 0;
            align-items: center;
        }

        #banner > img {
            border: 3px solid {{App\Http\Controllers\ThemeController::getThemedBorderColor()}};
            position: relative;
            top:32px;
            left: 32px;
        }

        #banner > h4 {
            color: #fff;
            text-shadow: 0 2px 0 rgba(0,0,0,0.8);
            position: relative;
            top:32px;
            left: 64px;
            text-transform: uppercase;
            font-size: 26px;
        }
    </style>
@endsection
