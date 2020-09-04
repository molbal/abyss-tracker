@extends("layout.app")
@section("browser-title", $tutorial->name." by ".$tutorial->content_creator->name)
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-9">
            <h4 class="font-weight-bold">{{$tutorial->name}}</h4>
            <div id="video-placeholder" class="w-100">
                &nbsp;
            </div>
            <ol class="msform-steps">
                <li class="is-completed">
                    <a href="#">Alap adatok</a>
                </li>
                <li class="is-active">Káresemény
                    <ul>
                        <li>
                            <a href="#!" class="msform-step-item is-active">
                                <span>Károsult adatai</span>
                                <ion-icon name="arrow-forward-outline" class="ion-icon-sm"></ion-icon>
                            </a>
                        </li>
                        <li>
                                    <span class="msform-step-item">
                                        <span>Részletek</span>
                                            <ion-icon name="arrow-forward-outline" class="ion-icon-sm"></ion-icon>
                                    </span>
                        </li>
                        <li>
                                    <span class="msform-step-item">
                                        <span>Kárigények</span>
                                        <ion-icon name="arrow-forward-outline" class="ion-icon-sm"></ion-icon>
                                    </span>
                        </li>
                    </ul>
                </li>
                <li>Csatolmányok</li>
                <li>Áttekintés</li>
            </ol>
        </div>
        <div class="col-sm-12 col-md-3">
            <h4 class="font-weight-bold">Submit</h4>
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

        }
    </style>
@endsection
@section("scripts")

    <script src="https://www.youtube.com/iframe_api"></script>

    <script>
        $(function () {

            player = new YT.Player('video-placeholder', {
                // width: 600,
                height: 400,
                videoId: 'Xa0Q0J5tOP0',
                playerVars: {
                    color: 'white',
                    playlist: 'taJ60kskkns,FG0fTKAqZ5g'
                },
                events: {
                    onReady: initialize
                }
            });
        });


        function initialize(e){
            console.log("yt init", e);
            // Update the controls on load
            // updateTimerDisplay();
            // updateProgressBar();

            // Clear any old interval.
            // clearInterval(time_update_interval);

            // Start interval to update elapsed time display and
            // the elapsed part of the progress bar every second.
            // time_update_interval = setInterval(function () {
            //     updateTimerDisplay();
            //     updateProgressBar();
            // }, 1000)

        }
    </script>
@endsection
