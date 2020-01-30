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
                <a class="nav-link {{"home_mine" == Route::currentRouteName() ? "active" : ""}}" href="{{route("home_mine")}}">My stats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"runs" == Route::currentRouteName() ? "active" : ""}}" href="{{route("runs")}}">All runs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"runs_mine" == Route::currentRouteName() ? "active" : ""}}" href="{{route("runs_mine")}}">My runs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"new" == Route::currentRouteName() ? "active" : ""}}" href="{{route("new")}}">Add
                    run</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{"changelog" == Route::currentRouteName() ? "active" : ""}}" href="{{route("changelog")}}">Changelog</a>
            </li>
        </ul>
        <form class="ml-auto">
            @if(session()->has("login_id"))
                <a href="{{route("logout")}}" class="btn btn-outline-danger my-2 my-sm-0">Log out
                    <strong>{{session()->get("login_name")}}</strong></a>
            @else
                <a href="{{route("auth-start")}}" class="btn btn-outline-success my-2 my-sm-0">SSO Login</a>
            @endif
        </form>
    </div>
</nav>
