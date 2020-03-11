<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{route("home")}}"><img src="/icon.png" alt=""> {{config("app.name")}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link {{"home" == Route::currentRouteName() ? "active" : ""}}" href="{{route("home")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home" == Route::currentRouteName())}}/home-page.png"> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"runs" == Route::currentRouteName() ? "active" : ""}}" href="{{route("runs")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs" == Route::currentRouteName())}}/database.png"> All runs</a>
            </li>
            @if(session()->has("login_id"))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/user--v1.png"> My account</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{"new" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("new")}}">Add run</a>
                        <a class="dropdown-item {{"runs_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("runs_mine")}}">My runs</a>
                        <a class="dropdown-item {{"home_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("home_mine")}}">My stats</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route("logout")}}#">Log out</a>
                    </div>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{"search.index" == Route::currentRouteName() || "search.do" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("search.index")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("search.index" == Route::currentRouteName() || "search.do" == Route::currentRouteName())}}/search.png">
                Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"item_all" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("item_all")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("item_all" == Route::currentRouteName())}}/empty-box.png"> Loot table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"ships_all" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("ships_all")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("ships_all" == Route::currentRouteName())}}/rocket.png"> Ships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"changelog" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("changelog")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == Route::currentRouteName())}}/medical-id.png"> Changelog <sup>(DEV)</sup></a>
            </li>
        </ul>
        <form class="ml-auto">
            @if(session()->has("login_id"))
                <a href="{{route("logout")}}" class="btn btn-outline-danger my-2 my-sm-0">Log out
                    <strong>{{session()->get("login_name")}}</strong></a>
            @else
                <a href="{{route("auth-start")}}" class="my-sm-0"><img src="https://eve-nt.uk/img/sso_small.png" alt=""></a>
            @endif
        </form>
    </div>
</nav>
