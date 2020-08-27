<div class="leaderboard-first mb-2">
    <img src="https://images.evetech.net/characters/{{$item->CHAR_ID}}/portrait?size=128" alt="" style="" class="rounded-circle shadow-sm portrait">
    <img src="https://img.icons8.com/material-sharp/96/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/crown.png" class="crown"/>
{{--    <div class="d-flex justify-content-between p-1 pb-0 mb-0">--}}
        <p class="lead mb-0"><a href="{{route("profile.index", ["id" => $item->CHAR_ID])}}" class="{{session()->get("login_id") == $item->CHAR_ID ? "text-danger" : "text-dark"}}">{{$item->NAME}}</a></p>
        <span class="d-block" @if($item->COUNT==420||$item->COUNT==69) data-toggle="tooltip" title="Nice"  @endif>{{$item->COUNT}} runs</span>
{{--    </div>--}}
</div>
