@php
    $currentRoute = Route::currentRouteName();
@endphp
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{route("home")}}" data-toggle="tooltip" title="Homepage"><img src="/icon.png" alt=""> {{config("app.name")}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link {{"runs" == $currentRoute ? "active" : ""}}" href="{{route("runs")}}">--}}
{{--                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs" == $currentRoute)}}/database.png"> All runs</a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link {{"search.index" == $currentRoute || "search.do" == $currentRoute ? "active" : ""}}"
                   href="{{route("search.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("search.index" == $currentRoute || "search.index" == $currentRoute)}}/search.png">
                Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"item_all" == $currentRoute ? "active" : ""}}"
                   href="{{route("item_all")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("item_all" == $currentRoute)}}/empty-box.png"> Loot table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"leaderboard.index" == $currentRoute ? "active" : ""}}"
                   href="{{route("leaderboard.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == $currentRoute)}}/trophy.png"> Leaderboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"ships_all" == $currentRoute ? "active" : ""}}"
                   href="{{route("ships_all")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("ships_all" == $currentRoute)}}/rocket.png"> Ships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"fit.index" == $currentRoute ? "active" : ""}}"
                   href="{{route("fit.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit.index" == $currentRoute)}}/job.png"> Fits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"tutorials.index" == $currentRoute ? "active" : ""}}"
                   href="{{route("tutorials.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("tutorials.index" == $currentRoute)}}/signpost.png"> Tutorials</a>
            </li>
            <li class="nav-item dropdown {{"infopage.tier" == $currentRoute ? "active" : ""}}" style="list-style: none">
                <a href="#" class="nav-link dropdown-toggle" id="newsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("infopage.tier" == $currentRoute)}}/info.png"> Overview</a>
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
                    <img src="https://img.icons8.com/ios/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == $currentRoute)}}/medical-id.png"> Community <sup>({{config("tracker.version")}})</sup></a>
                </a>
                <div class="dropdown-menu shadow animate slideIn" aria-labelledby="newsDropdown">
                    <a href="{{route("changelog")}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/ios/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/financial-changes.png"> Changelog</a>
                    <a href="{{route("donors.index")}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/like.png"> Donations</a>
                    <a href="{{route('community.discord')}}" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/discord-logo.png"> Join Abyssal Lurkers</a>
                    <div class="dropdown-divider"></div>
                    <a href="https://github.com/molbal/abyss-tracker/issues" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/github.png"> Issue tracker</a>
                    <a href="https://patreon.com/veetor" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/patreon.png"> Patreon</a>
                    <a href="https://uptime.abyss.eve-nt.uk/" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/server-shutdown.png"> Uptime monitor</a>
                </div>
            </li>
        </ul>
            <form class="ml-auto">
            @if(session()->has("login_id"))
                <li class="nav-item dropdown" style="list-style: none">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://images.evetech.net/characters/{{session()->get("login_id")}}/portrait?size=32" alt="{{session()->get('login_name')}}" class="rounded-circle shadow-sm" style="border:1px solid #fff;"> {{session()->get('login_name')}}</a>
                    <div class="dropdown-menu shadow animate slideIn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item pl-2 {{"new" == $currentRoute ? "active text-dark" : ""}}" href="{{route("new")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("new" == $currentRoute)}}/new-by-copy.png" class="tinyicon mr-1"/> Add run</a>
                        <a class="dropdown-item pl-2 {{"fit_new" == $currentRoute ? "active text-dark" : ""}}" href="{{route("fit_new")}}" ><img src="_icons/fit-new-{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit_new" == $currentRoute)}}.png" class="tinyicon mr-1"> New fit</a>
                        <a class="dropdown-item pl-2 {{"runs_mine" == $currentRoute ? "active text-dark" : ""}}" href="{{route("runs_mine")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs_mine" == $currentRoute)}}/bulleted-list.png" class="tinyicon mr-1"/> My runs</a>
                        <a class="dropdown-item pl-2 {{"home_mine" == $currentRoute ? "active text-dark" : ""}}" href="{{route("home_mine")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home_mine" == $currentRoute)}}/positive-dynamic.png" class="tinyicon mr-1"/> My stats</a>
                        <a class="dropdown-item pl-2 {{"profile.index" == $currentRoute ? "active text-dark" : ""}}" href="{{route("profile.index", ["id" => session()->get('login_id')])}}" ><img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("profile.index" == $currentRoute)}}/head-profile.png" class="tinyicon mr-1"/> My public profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item pl-2 {{"settings.index" == $currentRoute ? "active text-dark" : ""}}" href="{{route("settings.index")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("settings.index" == $currentRoute)}}/settings.png" class="tinyicon mr-1"/> Settings</a>
                        <a class="dropdown-item pl-2" href="{{route("logout")}}#"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == $currentRoute)}}/logout-rounded.png" class="tinyicon mr-1"/> Log out</a>
                    </div>
                </li>
            @else
                <a href="{{route("auth-start")}}" class="my-sm-0"><img src="https://eve-nt.uk/img/sso_small.png" alt="Log in with EVE Online Single sign on" width="195" height="30"></a>
            @endif
        </form>
    </div>
</nav>
