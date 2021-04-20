<a class="dropdown-item pl-2 {{$itemRoute == $currentRoute ? "active text-dark" : ""}}" href="{{route($itemRoute)}}"><img
        src="https://img.icons8.com/{{$iconType ?? "small"}}/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor($itemRoute == $currentRoute)}}/{{$icon}}.png" class="tinyicon mr-1"/>{{$slot}}</a>
