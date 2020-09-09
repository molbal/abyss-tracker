@extends("layout.app")
@section("browser-title", "Tutorials")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-9">
            <h4 class="font-weight-bold">Tutorials by {{$content_creator->NAME}}</h4>
                <a href="{{route('tutorials.index')}}" class="text-dark">← Back to all tutorials</a>
                @foreach($tutorials as $tutorial)
                    @component("components.tutorials.list", ['tutorial' => $tutorial]) @endcomponent
                @endforeach
        </div>
        <div class="col-sm-12 col-md-3">

            <div class="card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <img src="https://images.evetech.net/characters/{{$content_creator->CHAR_ID ?? 1}}/portrait?size=128" class="portrait rounded-circle shadow-sm" alt="">
                    <p class="h5 font-weight-bold mb-3 mt-2"><a href="{{route("tutorials.creator", ['id' =>$tutorial->content_creator->id, 'slug' => Str::slug($content_creator->NAME)])}}" class="text-dark">{{$content_creator->NAME}}</a></p>

                    @if($content_creator->DISCORD)
                        <a class="text-dark w-100 text-left d-block" target="_blank" href="{{$content_creator->DISCORD}}">
                            <img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/discord-logo.png" class="ml-0 mr-2 bringupper tinyicon d-inline-block">Discord community</a>
                    @endif
                    @if($content_creator->TWITTER)
                        <a class="text-dark w-100 text-left d-block" target="_blank" href="{{$content_creator->TWITTER}}">
                            <img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/twitter.png" class="ml-0 mr-2 bringupper tinyicon d-inline-block">Twitter feed</a>
                    @endif
                    @if($content_creator->YOUTUBE)
                        <a class="text-dark w-100 text-left d-block" target="_blank" href="{{$content_creator->YOUTUBE}}">
                            <img src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/youtube-play--v1.png" class="ml-0 mr-2 bringupper tinyicon d-inline-block">Youtube channel</a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
@section("styles")
    <style>
        img.tutorial-uploader {
            width:  48px;
            height: 48px;

            border: 2px solid #fff;
            margin-right: 8px;
        }
    </style>
@endsection
{{--@section("scripts")--}}
{{--    <script>--}}

{{--    </script>--}}
{{--@endsection--}}
