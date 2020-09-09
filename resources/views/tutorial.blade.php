@extends("layout.app")
@section("browser-title", $tutorial->name." by ".$tutorial->content_creator->name)
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-9">
            <h4 class="font-weight-bold">{{$tutorial->name}}</h4>
            <div class="alert alert-info alert-dismissible fade show text-justify" role="alert">
                <strong>A word of advice:</strong> Abyssal deadspace can be run in countless ways. A single tutorial cannot cover all methods.
                There might be a solution better suited to your preferences, wallet, or skills so watch other tutorials or read other guides before you buy something expensive.
                Don't fly a ship you cannot afford to lose and fly safe o7
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="video-placeholder" class="w-100 rounded shadow">
                &nbsp;
            </div>
            <div class="container p-0">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card card-body border-0 shadow-sm mt-3">
                            <h5 class="font-weight-bold">Description</h5>
                            {!! $description !!}
                        </div>
                        <div class="card card-body border-0 shadow-sm mt-3">
                            <h5 class="font-weight-bold">Related fits</h5>
                            @component("components.fits.filter.result-list", ["results" => $fits])@endcomponent
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-sm-12 col-md-3">
            <h4 class="font-weight-bold">Creator</h4>
            <div class="card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <img src="https://images.evetech.net/characters/{{$tutorial->content_creator->CHAR_ID ?? 1}}/portrait?size=128" class="portrait rounded-circle shadow-sm" alt="">
                    <p class="h5 font-weight-bold mb-3 mt-2"><a href="{{route("tutorials.creator", ['id' =>$tutorial->content_creator->id, 'slug' => Str::slug($tutorial->content_creator->NAME)])}}" class="text-dark">{{$tutorial->content_creator->NAME}}</a></p>

                    @if($tutorial->content_creator->DISCORD)
                        <a class="text-dark w-100 text-left d-block" target="_blank" href="{{$tutorial->content_creator->DISCORD}}">
                            <img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/discord-logo.png" class="ml-0 mr-2 bringupper tinyicon d-inline-block">Discord community</a>
                    @endif
                    @if($tutorial->content_creator->TWITTER)
                        <a class="text-dark w-100 text-left d-block" target="_blank" href="{{$tutorial->content_creator->TWITTER}}">
                            <img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/twitter.png" class="ml-0 mr-2 bringupper tinyicon d-inline-block">Twitter feed</a>
                    @endif
                    @if($tutorial->content_creator->YOUTUBE)
                        <a class="text-dark w-100 text-left d-block" target="_blank" href="{{$tutorial->content_creator->YOUTUBE}}">
                            <img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/youtube-play--v1.png" class="ml-0 mr-2 bringupper tinyicon d-inline-block">Youtube channel</a>
                    @endif
                </div>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Votes</h5>
                <div class="text-center">
                    <a class="text-dark" href="{{route("tutorials.vote", ['id'=>$tutorial->id, 'vote' => 'plus'])}}" data-toggle="tooltip" title="Click to vote up"><img src="https://img.icons8.com/small/48/38c172/thumb-up.png" class="mr-1 bringupper smallicon">{{$tutorial->positive}}</a>
                    <span class="mx-1">&middot;</span>
                    <a class="text-dark" href="{{route("tutorials.vote", ['id'=>$tutorial->id, 'vote' => 'minus'])}}" data-toggle="tooltip" title="Click to vote down"><img src="https://img.icons8.com/small/48/f6993f/thumbs-down--v2.png" class="mr-1 bringupper smallicon">{{$tutorial->negative}}</a>
                </div>
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold">Bookmarks</h5>
                <ul class="bookmarks">
                    @forelse($embed->getParsedBookmarks() as $bookmark)
                        <li class="bookmark">
                        <span class="bookmark-label" data-second="{{$bookmark->timeSeconds}}" data-second-next="{{$bookmark->timeSecondsNext}}">
                            <a href="javascript:void(0)" class="text-dark font-weight-bold seeker">{{$bookmark->timeFormatted}}<span class="mx-1">&middot;</span>{{$bookmark->label}}</a>
                            <img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/circled-play.png" class="mx-1 bringupper bookmark-play-icon d-inline-block">
                        </span>
                        </li>
                    @empty
                        <li class="bookmark">
                            <span class="bookmark-label">This tutorial has no bookmarks</span>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
@endsection
@section("styles")
    <style>
        #video-placeholder {
            min-height: 500px;
        }
    </style>
@endsection
@section("scripts")

    <script src="https://www.youtube.com/iframe_api"></script>

    <script>
        $(function () {

            window.YT.ready(function() {
                player = new YT.Player('video-placeholder', {
                    height: 500,
                    videoId: '{{$embed->getId()}}',
                    playerVars: {
                        color: 'white',
                        autoplay: 1,
                        controls: 1,
                        modestbranding: 1,
                        enablejsapi: 1
                    },
                    events: {
                        onReady: initialize
                    }
                });
            });


            $(".seeker").click(function () {
                player.seekTo($(this).parent().data("second")+1);
                // setTimeout(updateBookmarks, 100);
            });

        });

        function updateBookmarks() {
            var currentTime = player.getCurrentTime();
            console.log(currentTime);
            var hasPlaying = false;
            $(".bookmark-label").each(function() {
                var bookmarkTime = $(this).data("second");
                var bookmarkTimeNext = $(this).data("second-next");
                if (bookmarkTime < currentTime && bookmarkTimeNext < currentTime) {
                    $(this).addClass("played").removeClass("playing").removeClass("upcoming");
                }
                else if (bookmarkTime < currentTime && bookmarkTimeNext >= currentTime) {
                    $(this).removeClass("played").addClass("playing").removeClass("upcoming");
                }
                else {
                    $(this).removeClass("played").removeClass("playing").addClass("upcoming");
                }
            })
        }
        function initialize(e){
            setInterval(updateBookmarks, 333);
        }
    </script>
@endsection
