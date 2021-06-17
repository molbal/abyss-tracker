@extends("layout.app")
@section("browser-title","Event list")
@section("content")

    <div class="row">
        @component('pvp.components.video-banner', ['event' => null]) @endcomponent
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-8 offset-lg-2">
            <div class="card card-body border-0 rounded-b-none mb-0">

                <h5 class="font-weight-bold">Event list</h5>

            <table class="table w-100">
                <tr>
                    <th>Name</th>
                    <th class="text-right">Recorded kills</th>
                    <th>Event start</th>
                    <th>Event finish</th>
                </tr>
            @forelse($feed as $event)
                    <tr>
                        <th><a href="{{route('pvp.get', ['slug' => $event->slug])}}">{{$event->name}}</a></th>
                        <th class="text-right">{{$event->kills_count}}</th>
                        <th>{{\Carbon\Carbon::parse($event->created_at)->toDateString()}}</th>
                        <th>{{\Carbon\Carbon::parse($event->updated_at)->toDateString()}}</th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <em class="py-4">Nothing here yet</em>
                        </td>
                    </tr>
            @endforelse
            </table>
        </div>
    </div>
        {{$feed->links()}}
    </div>
@endsection
