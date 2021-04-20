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
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("search.index" == $currentRoute || "search.index" == $currentRoute)}}/search.png">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"item_all" == $currentRoute ? "active" : ""}}"
                   href="{{route("item_all")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("item_all" == $currentRoute)}}/empty-box.png">Loot table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"leaderboard.index" == $currentRoute ? "active" : ""}}"
                   href="{{route("leaderboard.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == $currentRoute)}}/trophy.png">Leaderboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"ships_all" == $currentRoute ? "active" : ""}}"
                   href="{{route("ships_all")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("ships_all" == $currentRoute)}}/rocket.png">Ships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"fit.index" == $currentRoute ? "active" : ""}}"
                   href="{{route("fit.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit.index" == $currentRoute)}}/job.png">Fits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"tutorials.index" == $currentRoute ? "active" : ""}}"
                   href="{{route("tutorials.index")}}">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("tutorials.index" == $currentRoute)}}/signpost.png">Tutorials</a>
            </li>

            <li class="nav-item dropdown has-megamenu">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("infopage.tier" == $currentRoute)}}/info.png">Overview</a></a>
                <div class="dropdown-menu megamenu fade-down shadow {{\App\Http\Controllers\ThemeController::isDarkTheme() ? "dark" : "light"}}">
                    <div class="container-fluid">
                        <div class="row w-100">
                            <div class="col-lg-2 col-md-6 col-sx-12">
                                <h6 class="mm-head">All weathers</h6>
                                <ul class="list-unstyled">
                                @for($i=0;$i<=6;$i++)
                                        <li><a href="{{route("infopage.tier", ['tier' => $i])}}" class=""><img class="tinyicon mr-2" src="{{asset("tiers/{$i}.png")}}" alt="">@lang("tiers.$i")</a></li>
                                @endfor
                                </ul>
                            </div>

                            @foreach(['Dark','Electrical','Exotic','Firestorm','Gamma'] as $type)
                                <div class="col-lg-2 col-md-6 col-sx-12">
                                    <h6 class="mm-head"><img src="{{asset('types/'.$type.'.png')}}" alt="" class="tinyicon mr-1">{{$type}}</h6>
                                    <ul class="list-unstyled">
                                    @for($i=0;$i<=6;$i++)
                                        <li><a href="{{route("infopage.tier-type", ['tier' => $i, 'type' => $type])}}" class=""><img class="tinyicon mr-2" src="{{asset("tiers/{$i}.png")}}" alt="">@lang("tiers.$i")</a></li>
                                    @endfor
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> <!-- dropdown-mega-menu.// -->
            </li>
            <li class="nav-item dropdown" style="list-style: none">
                <a href="#" class="nav-link dropdown-toggle" id="newsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://img.icons8.com/ios/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == $currentRoute)}}/medical-id.png">Community <sup>({{config("tracker.version")}})</sup></a>
                </a>
                <div class="dropdown-menu fade-down shadow" aria-labelledby="newsDropdown">
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
            @if(\App\Http\Controllers\Auth\AuthController::isLoggedIn())
                <li class="nav-item dropdown" style="list-style: none">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://images.evetech.net/characters/{{\App\Http\Controllers\Auth\AuthController::getLoginId()}}/portrait?size=32" alt="{{session()->get('login_name')}}" class="rounded-circle shadow-sm mr-1" style="border:1px solid #fff;">{{\App\Http\Controllers\Auth\AuthController::getCharName()}}</a>
                    <div class="dropdown-menu fade-down shadow" aria-labelledby="navbarDropdown" style="right: 0 !important; left: unset !important;">
                       <a class="dropdown-item pl-2 {{"new" == $currentRoute ? "active text-dark" : ""}}" href="{{route("new")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("new" == $currentRoute)}}/new-by-copy.png" class="tinyicon mr-1"/>Add run</a>
                        <a class="dropdown-item pl-2 {{"fit_new" == $currentRoute ? "active text-dark" : ""}}" href="{{route("fit_new")}}" ><img src="_icons/fit-new-{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit_new" == $currentRoute)}}.png" class="tinyicon mr-1">New fit</a>
                        <a class="dropdown-item pl-2 {{"runs_mine" == $currentRoute ? "active text-dark" : ""}}" href="{{route("runs_mine")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs_mine" == $currentRoute)}}/bulleted-list.png" class="tinyicon mr-1"/>My runs</a>
                        <a class="dropdown-item pl-2 {{"home_mine" == $currentRoute ? "active text-dark" : ""}}" href="{{route("home_mine")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home_mine" == $currentRoute)}}/positive-dynamic.png" class="tinyicon mr-1"/>My home</a>
                        <a class="dropdown-item pl-2 {{"fit.mine" == $currentRoute ? "active text-dark" : ""}}" href="{{route("fit.mine")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit.mine" == $currentRoute)}}/scan-stock.png" class="tinyicon mr-1"/>My fits</a>
                        <a class="dropdown-item pl-2 {{"profile.index" == $currentRoute ? "active text-dark" : ""}}" href="{{route("profile.index", ["id" => session()->get('login_id')])}}" ><img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("profile.index" == $currentRoute)}}/head-profile.png" class="tinyicon mr-1"/>Public profile</a>
                        @component('layout.navbar-components.logged-in-dropdown-item', ['itemRoute' => "alts.index",'currentRoute' => $currentRoute,'icon' => 'group-foreground-selected']) Alts manager @endcomponent
                        <div class="dropdown-divider"></div>
                        <span class="dropdown-item pl-2 text-muted"><small>Quick char switch</small></span>
                        @forelse(\App\Http\Controllers\Profile\AltRelationController::getAllMyAvailableCharacters() as $char)
                            <a class="dropdown-item pl-2" href="{{route('alts.switch', ['altId' => $char->id])}}"><img src="https://images.evetech.net/characters/{{$char->id}}/portrait?size=32" alt="{{$char->name}}" class="switcher-image" >{{\Illuminate\Support\Str::of($char->name)->limit(12, '...')}}<a>
                            @empty
                            @component('layout.navbar-components.logged-in-dropdown-item', ['itemRoute' => "alts.index",'currentRoute' => $currentRoute,'icon' => 'add-user-female']) Add an alt @endcomponent

                       @endforelse
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item pl-2 {{"settings.index" == $currentRoute ? "active text-dark" : ""}}" href="{{route("settings.index")}}" ><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("settings.index" == $currentRoute)}}/settings.png" class="tinyicon mr-1"/> Settings</a>
                        <a class="dropdown-item pl-2" href="{{route("logout")}}#"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == $currentRoute)}}/logout-rounded.png" class="tinyicon mr-1"/> Log out</a>
                    </div>
                </li>
            @else
                <a href="{{route("auth-start")}}" class="my-sm-0"><img src="{{asset("sso.png")}}" alt="Log in with EVE Online Single sign on" width="195" height="30"></a>
            @endif
        </form>
    </div>
</nav>
