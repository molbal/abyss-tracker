@extends("layout.app")
@section("browser-title", $name)
@section("content")
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm">
                <img src="https://images.evetech.net/characters/{{$id}}/portrait?size=128" class="rounded-circle shadow-sm">
                <h4 class="font-weight-bold ">{{$name}}</h4>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="card card-body border-0 shadow-sm mt-3">
                <img src="https://fakeimg.pl/733x400/fff,128/000,255?text=last+runs" alt="">
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="card card-body border-0 shadow-sm mt-3">
                <img src="https://fakeimg.pl/366x96/fff,128/000,255?text=activity+calendar" alt="">
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <img src="https://fakeimg.pl/366x96/fff,128/000,255?text=favorite+ships+chart" alt="">
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <img src="https://fakeimg.pl/366x96/fff,128/000,255?text=survivability+chart" alt="">
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <img src="https://fakeimg.pl/366x96/fff,128/000,255?text=achievements" alt="">
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
            z-index: 50;
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
