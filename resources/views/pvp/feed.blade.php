@extends("layout.app")
@section("browser-title","Kills list - " . $event->name)
@section("content")

    <div class="row">
        @component('pvp.components.video-banner', ['event' => $event]) @endcomponent
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1">
            @forelse($feed as $kill)
                @component($event->display_component, ['event' => $event, 'victim' => $kill]) @endcomponent
            @empty
                <em>Nothing here yet</em>
            @endforelse
            <a class="text-dark" href="{{route('pvp.kills', ['slug' => $event->slug])}}"><img class="tinyicon mr-1"
                                                                                              src="https://img.icons8.com/small/24/{{\App\Http\Controllers\ThemeController::getThemedIconColor()}}/database.png">View
                all kills</a>
        </div>
        {{$feed->links()}}
    </div>
@endsection
