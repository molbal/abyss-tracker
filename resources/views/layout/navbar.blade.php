<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{route("home")}}" data-toggle="tooltip" title="Homepage"><img src="/icon.png" alt=""> {{config("app.name")}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link {{"runs" == Route::currentRouteName() ? "active" : ""}}" href="{{route("runs")}}">--}}
{{--                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs" == Route::currentRouteName())}}/database.png"> All runs</a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link {{"search.index" == Route::currentRouteName() || "search.do" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("search.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("search.index" == Route::currentRouteName() || "search.index" == Route::currentRouteName())}}/search.png">
                Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"item_all" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("item_all")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("item_all" == Route::currentRouteName())}}/empty-box.png"> Loot table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"leaderboard.index" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("leaderboard.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())}}/trophy.png"> Leaderboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"ships_all" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("ships_all")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("ships_all" == Route::currentRouteName())}}/rocket.png"> Ships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"fit.index" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("fit.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit.index" == Route::currentRouteName())}}/job.png"> Fits</a>
            </li>
            <li class="nav-item dropdown {{"infopage.tier" == Route::currentRouteName() ? "active" : ""}}" style="list-style: none">
                <a href="#" class="nav-link dropdown-toggle" id="newsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("infopage.tier" == Route::currentRouteName())}}/info.png"> Overview</a>
                </a>
                <div class="dropdown-menu shadow animate slideIn" aria-labelledby="newsDropdown">
                    <a href="{{route("infopage.tier", ['tier' => 1])}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/info.png"> Calm <small class="bringupper">(Tier 1)</small></a>
                    <a href="{{route("infopage.tier", ['tier' => 2])}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/info.png"> Agitated <small class="bringupper">(Tier 2)</small></a>
                    <a href="{{route("infopage.tier", ['tier' => 3])}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/info.png"> Fierce <small class="bringupper">(Tier 3)</small></a>
                    <a href="{{route("infopage.tier", ['tier' => 4])}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/info.png"> Raging <small class="bringupper">(Tier 4)</small></a>
                    <a href="{{route("infopage.tier", ['tier' => 5])}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/info.png"> Chaotic <small class="bringupper">(Tier 5)</small></a>
                </div>
            </li>
            <li class="nav-item dropdown" style="list-style: none">
                <a href="#" class="nav-link dropdown-toggle" id="newsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://img.icons8.com/ios/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == Route::currentRouteName())}}/medical-id.png"> Community <sup>({{config("tracker.version")}})</sup></a>
                </a>
                <div class="dropdown-menu shadow animate slideIn" aria-labelledby="newsDropdown">
                    <a href="{{route("changelog")}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/ios/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/financial-changes.png"> Changelog</a>
                    <a href="{{route("donors.index")}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/like.png"> Donations</a>
                    <a href="{{route('community.discord')}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/discord-logo.png"> Join Abyssal Lurkers</a>
                    <div class="dropdown-divider"></div>
                    <a href="https://github.com/molbal/abyss-tracker/issues" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/github.png"> Issue tracker</a>
                    <a href="https://patreon.com/veetor" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/patreon.png"> Patreon</a>
                </div>
            </li>
        </ul>
            <form class="ml-auto">
            @if(session()->has("login_id"))
                <li class="nav-item dropdown" style="list-style: none">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://images.evetech.net/characters/{{session()->get("login_id")}}/portrait?size=32" alt="{{session()->get('login_name')}}" class="rounded-circle shadow-sm" style="border:1px solid #fff;"> {{session()->get('login_name')}}</a>
                    <div class="dropdown-menu shadow animate slideIn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item pl-2 {{"new" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("new")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("new" == Route::currentRouteName())}}/new-by-copy.png" class="tinyicon mr-1"/> Add run</a>
                        <a class="dropdown-item pl-2 {{"fit_new" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("fit_new")}}" ><img src="_icons/fit-new-{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit_new" == Route::currentRouteName())}}.png" class="tinyicon mr-1"> New fit</a>
                        <a class="dropdown-item pl-2 {{"runs_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("runs_mine")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs_mine" == Route::currentRouteName())}}/bulleted-list.png" class="tinyicon mr-1"/> My runs</a>
                        <a class="dropdown-item pl-2 {{"home_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("home_mine")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home_mine" == Route::currentRouteName())}}/positive-dynamic.png" class="tinyicon mr-1"/> My stats</a>
                        <a class="dropdown-item pl-2 {{"profile.index" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("profile.index", ["id" => session()->get('login_id')])}}" ><img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("profile.index" == Route::currentRouteName())}}/head-profile.png" class="tinyicon mr-1"/> My public profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item pl-2 {{"settings.index" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("settings.index")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("settings.index" == Route::currentRouteName())}}/settings.png" class="tinyicon mr-1"/> Settings</a>
                        <a class="dropdown-item pl-2" href="{{route("logout")}}#"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == Route::currentRouteName())}}/logout-rounded.png" class="tinyicon mr-1"/> Log out</a>
                    </div>
                </li>
            @else
                <a href="{{route("auth-start")}}" class="my-sm-0"><img src="https://eve-nt.uk/img/sso_small.png" alt="Log in with EVE Online Single sign on" width="195" height="30"></a>
            @endif
        </form>
    </div>
</nav>
