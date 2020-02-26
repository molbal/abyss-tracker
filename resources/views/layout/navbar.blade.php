<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{route("home")}}"><img src="/icon.png" alt=""> {{config("app.name")}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link {{"home" == Route::currentRouteName() ? "active" : ""}}" href="{{route("home")}}">Stats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"home_mine" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("home_mine")}}">My stats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"runs" == Route::currentRouteName() ? "active" : ""}}" href="{{route("runs")}}">All
                    runs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"runs_mine" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("runs_mine")}}">My runs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"new" == Route::currentRouteName() ? "active" : ""}}" href="{{route("new")}}">Add
                    run</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Filtered runs
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach(['Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'] as $type)
                        <span href="#" class="dropdown-item">
                            <span>{{$type}}</span>
                            <span class=" d-flex justify-content-between">
                                @for($i=1;$i<=5;$i++)
                                    <a href="{{route("filtered_list", [
                                    "type" => $type,
                                    "tier" => $i
                                    ])}}" class="btn-link text-dark">{{$i}}</a>
                                @endfor
                            </span>
                    </span>
                    @endforeach
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"item_all" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("item_all")}}">Loot table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"ships_all" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("ships_all")}}">Ships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"changelog" == Route::currentRouteName() ? "active" : ""}}"
                   href="{{route("changelog")}}">Changelog <sup>(1.3.3)</sup></a>
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
