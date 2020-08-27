<div class="d-flex justify-content-between cursor-pointer hover-underline"
     data-toggle="collapse"
     data-target="{{$target}}">
    <h5 class="font-weight-bold"><img src="/_icons/search-icons/{{$icon}}.png" alt="{{$icon}} icon" class="card-header-icon mr-1">{{$slot}}</h5>
    <img
        src="https://img.icons8.com/ios-glyphs/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/resize-vertical.png"
        class="card-toggle">

</div>
