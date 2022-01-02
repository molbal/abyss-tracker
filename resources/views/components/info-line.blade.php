<div class="d-flex w-100 justify-content-start align-items-baseline {{$class ?? ""}}">
<span class="tinyicon"><img
    src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png" class="tinyicon mr-2">
    </span>
    <span class="text-small text-justify">{!! $slot !!}</span>

</div>
