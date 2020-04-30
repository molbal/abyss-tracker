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
            <li class="nav-item dropdown" style="list-style: none">
                <a class="nav-link dropdown-toggle" href="#" id="navbarShipDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("ships_all" == Route::currentRouteName())}}/rocket.png"> Ships</a>
                <div class="dropdown-menu" aria-labelledby="navbarShipDropdown">
                    <a class="dropdown-item pl-2 {{"new" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("new")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("new" == Route::currentRouteName())}}/rocket.png" class="mr-1"/> Ships</a>
                    <a class="dropdown-item pl-2 {{"runs_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("fit_new")}}" ><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                        width="16" height="16"
                        viewBox="0 0 172 172"
                        style="fill:#{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit_new" == Route::currentRouteName())}};"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                            <path d="M0,172v-172h172v172z" fill="none" stroke="none"></path><g id="original-icon" fill="#{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit_new" == Route::currentRouteName())}}" stroke="none" opacity="0" visibility="hidden"><path d="M86,17.2c-37.9948,0 -68.8,30.8052 -68.8,68.8c0,12.36107 3.3024,23.93667 9.0128,33.96427c8.686,-8.686 21.28213,-21.28213 29.12533,-29.12533c-5.762,-11.40933 -5.42373,-23.42067 4.99947,-33.84387c9.83267,-9.83267 23.46653,-13.04907 35.95947,-9.9588l-21.76373,21.76373l5.73333,22.93333l22.93333,5.73333l21.76373,-21.76373c3.09027,12.49293 -0.12613,26.1268 -9.9588,35.95947c-10.4232,10.4232 -22.43453,10.75573 -33.84387,4.99947c-7.00613,7.00613 -20.10107,20.10107 -29.12533,29.12533c10.0276,5.70467 21.6032,9.0128 33.96427,9.0128c37.9948,0 68.8,-30.8052 68.8,-68.8c0,-37.9948 -30.8052,-68.8 -68.8,-68.8z"></path></g><g id="subtracted-icon" fill="#000000" stroke="none"><path d="M52.03573,145.7872c8.38387,-8.38387 20.28115,-20.28115 27.54542,-27.54542c-0.86004,3.73615 -1.31449,7.62739 -1.31449,11.62489c0,9.03816 2.32307,17.53317 6.40475,24.92058c-11.86185,-0.22792 -22.96818,-3.50023 -32.63569,-9.00004zM124.96373,75.70293l-3.1954,3.1954c-11.63667,1.83387 -21.98031,7.55647 -29.65883,15.79571l-11.84283,-2.96071l-5.73333,-22.93333l21.76373,-21.76373c-12.49293,-3.09027 -26.1268,0.12613 -35.95947,9.9588c-10.4232,10.4232 -10.76147,22.43453 -4.99947,33.84387c-7.8432,7.8432 -20.43933,20.43933 -29.12533,29.12533c-5.7104,-10.0276 -9.0128,-21.6032 -9.0128,-33.96427c0,-37.9948 30.8052,-68.8 68.8,-68.8c37.55098,0 68.07934,30.08973 68.78743,67.47152c-7.38745,-4.08175 -15.88253,-6.40485 -24.92076,-6.40485c-1.45784,0 -2.90155,0.06044 -4.32876,0.17895c-0.15794,-0.919 -0.34937,-1.83386 -0.57418,-2.74268z"></path></g><g fill="#000000" stroke="none"><g id="Layer_1"><path d="M129.86667,89.73333c-22.16507,0 -40.13333,17.96827 -40.13333,40.13333c0,22.16507 17.96827,40.13333 40.13333,40.13333c22.16507,0 40.13333,-17.96827 40.13333,-40.13333c0,-22.16507 -17.96827,-40.13333 -40.13333,-40.13333zM147.06667,135.6h-11.46667v11.46667c0,3.17053 -2.56853,5.73333 -5.73333,5.73333c-3.1648,0 -5.73333,-2.5628 -5.73333,-5.73333v-11.46667h-11.46667c-3.1648,0 -5.73333,-2.5628 -5.73333,-5.73333c0,-3.17053 2.56853,-5.73333 5.73333,-5.73333h11.46667v-11.46667c0,-3.17053 2.56853,-5.73333 5.73333,-5.73333c3.1648,0 5.73333,2.5628 5.73333,5.73333v11.46667h11.46667c3.1648,0 5.73333,2.5628 5.73333,5.73333c0,3.17053 -2.56853,5.73333 -5.73333,5.73333z"></path></g><g id="Layer_1" opacity="0"><path d="M129.86667,78.26667c-28.5004,0 -51.6,23.0996 -51.6,51.6c0,28.5004 23.0996,51.6 51.6,51.6c28.5004,0 51.6,-23.0996 51.6,-51.6c0,-28.5004 -23.0996,-51.6 -51.6,-51.6z"></path></g></g><path d="M89.73333,170v-80.26667h80.26667v80.26667z" id="overlay-drag" fill="#ff0000" stroke="none" opacity="0"></path></g></svg>" class="mr-1"/> Fits</a>
                 </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"changelog" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("changelog")}}">
                    <img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == Route::currentRouteName())}}/medical-id.png"> Changelog <sup>(1.4.2)</sup></a>
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
                        <a class="dropdown-item pl-2 {{"new" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("new")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("new" == Route::currentRouteName())}}/job.png" class="mr-1"/> New fit</a>
                        <a class="dropdown-item pl-2 {{"runs_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("runs_mine")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs_mine" == Route::currentRouteName())}}/bulleted-list.png" class="mr-1"/> My runs</a>
                        <a class="dropdown-item pl-2 {{"home_mine" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("home_mine")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home_mine" == Route::currentRouteName())}}/positive-dynamic.png" class="mr-1"/> My stats</a>
                        <a class="dropdown-item pl-2 {{"profile.index" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("profile.index", ["id" => session()->get('login_id')])}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("profile.index" == Route::currentRouteName())}}/head-profile.png" class="mr-1"/> My public profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item pl-2 {{"settings.index" == Route::currentRouteName() ? "active text-dark" : ""}}" href="{{route("settings.index")}}" ><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("settings.index" == Route::currentRouteName())}}/settings.png" class="mr-1"/> Settings</a>
                        <a class="dropdown-item pl-2" href="{{route("logout")}}#"><img src="https://img.icons8.com/ios-glyphs/16/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == Route::currentRouteName())}}/logout-rounded.png" class="mr-1"/> Log out</a>
                    </div>
                </li>
            @else
                <a href="{{route("auth-start")}}" class="my-sm-0"><img src="https://eve-nt.uk/img/sso_small.png" alt=""></a>
            @endif
        </form>
    </div>
</nav>
