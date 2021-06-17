<div class="card card-body border-0 shadow-sm rounded-t mb-3">
    <h5 class="font-weight-bold">Most kills by corporation</h5>
    <table class="table w-100 table-sm table-responsive-sm mb-0">
        @foreach($topKills as $kill)
            @component('pvp.components.top-kill-corporation', ['item' => $kill, 'i' => $loop->iteration, 'event' => $event]) @endcomponent
        @endforeach
    </table>
</div>
{{--<div class="card-footer rounded-b mb-3 ">--}}
{{--    <span>--}}
{{--        <a href="{{route('pvp.top-kills', ['slug' => $event->slug])}}" class="text-dark" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/windows/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/winners-medal.png"/>Full leaderboard</a>--}}
{{--    </span>--}}
{{--</div>--}}