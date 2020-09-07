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
        <div class="col-sm-12 col-md-3">
            <h4 class="font-weight-bold">Creator</h4>
            <div class="card card-body border-0 shadow-sm w-100">
                <p class="text-justify mb-0 pb-0">If you know a tutorial that the community could benefit from, please submit it and I'll add it on my earliest convenience. Uploaders are always credited.</p>
            </div>
            <div class="card-footer shadow-sm">
                <a href="{{config("tracker.submit-tutorial")}}" target="_blank" class="text-dark"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/clock.png" class="mr-1 bringupper tinyicon">Submit new video</a>
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
