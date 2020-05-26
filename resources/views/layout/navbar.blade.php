<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{route("home")}}" data-toggle="tooltip" title="Homepage"><img src="/icon.png" alt=""> {{config("app.name")}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link {{"home" == Route::currentRouteName() ? "active" : ""}}" href="{{route("home")}}">--}}
{{--                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home" == Route::currentRouteName())}}/home-page.png"> Home</a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link {{"runs" == Route::currentRouteName() ? "active" : ""}}" href="{{route("runs")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs" == Route::currentRouteName())}}/database.png"> All runs</a>
            </li>
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
                <a class="nav-link {{"leaderboard.index" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("leaderboard.index")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())}}/trophy.png"> Leaderboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"ships_all" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("ships_all")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("ships_all" == Route::currentRouteName())}}/rocket.png"> Ships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"fit.index" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("fit.index")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit.index" == Route::currentRouteName())}}/job.png"> Fits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"changelog" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("changelog")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == Route::currentRouteName())}}/medical-id.png"> Changelog <sup>(1.5.1)</sup></a>
            </li>
            <li class="nav-item">
                <a href="https://www.patreon.com/veetor" target="_blank" class="nav-link font-weight-bold">
                    <img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/patreon.png"> Patreon</a>
            </li>
        </ul>
            <form class="ml-auto">
            @if(session()->has("login_id"))
                <li class="nav-item dropdown" style="list-style: none">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://images.evetech.net/characters/{{session()->get("login_id")}}/portrait?size=32" alt="{{session()->get('login_name')}}" class="rounded-circle shadow-sm"> {{session()->get('login_name')}}</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item pl-2 {{"new" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("new")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("new" == Route::currentRouteName())}}/new-by-copy.png" class="mr-1"/> Add run</a>
                        <a class="dropdown-item pl-2 {{"fit_new" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("fit_new")}}" ><img src="_icons/fit-new-{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit_new" == Route::currentRouteName())}}.png" style="width: 16px;height: 16px"> New fit</a>
                        <a class="dropdown-item pl-2 {{"runs_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("runs_mine")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs_mine" == Route::currentRouteName())}}/bulleted-list.png" class="mr-1"/> My runs</a>
                        <a class="dropdown-item pl-2 {{"home_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("home_mine")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home_mine" == Route::currentRouteName())}}/positive-dynamic.png" class="mr-1"/> My stats</a>
                        <a class="dropdown-item pl-2 {{"profile.index" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("profile.index", ["id" => session()->get('login_id')])}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("profile.index" == Route::currentRouteName())}}/head-profile.png" class="mr-1"/> My public profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item pl-2 {{"settings.index" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("settings.index")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("settings.index" == Route::currentRouteName())}}/settings.png" class="mr-1"/> Settings</a>
                        <a class="dropdown-item pl-2" href="{{route("logout")}}#"><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == Route::currentRouteName())}}/logout-rounded.png" class="mr-1"/> Log out</a>
                    </div>
                </li>
            @else
                <a href="{{route("auth-start")}}" class="my-sm-0"><img src="https://eve-nt.uk/img/sso_small.png" alt="Log in with EVE Online Single sign on" width="195" height="30"></a>
            @endif
        </form>
    </div>
</nav>
