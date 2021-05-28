@extends("layout.app")
@section("browser-title", "Leaderboard - " .  $event->name)
@section("content")

    <div class="row">
        @component('pvp.components.video-banner', ['event' => $event]) @endcomponent
    </div>
    <div class="row">
        <div class="col-md-10 offset-md-1 col-lg-6 offset-lg-3">
            <div class="card card-body border-0 shadow-sm rounded-t">
                <h5 class="font-weight-bold">Most kills</h5>
                <table class="table w-100 table-sm table-responsive-sm mb-0">
                    @foreach($topKills as $kill)
                        @component('pvp.components.top-kill', ['item' => $kill, 'i' => $loop->iteration+($topKills->perPage()*($topKills->currentPage()-1))]) @endcomponent
                    @endforeach
                </table>
            </div>
            <div class="card-footer rounded-b mb-3 ">
                {{$topKills->links()}}
            </div>

        </div>
    </div>
@endsection
