<div class="card card-body border-0 shadow-sm mb-3">
<div class="d-flex w-100 justify-start mb-0">
    <img src="https://images.evetech.net/characters/{{$tutorial->content_creator->CHAR_ID ?? 1}}/portrait?size=128" class="tutorial-uploader rounded-circle shadow-sm" alt="">
    <div class="w-100">
        <a href="{{route("tutorials.get", ['id' => $tutorial->id, 'slug' => Str::slug($tutorial->name)])}}" class="h4 text-dark">{{$tutorial->name}}</a><span
            class="float-right">
        <span data-toggle="tooltip" title="Number of upvotes"><img src="https://img.icons8.com/small/24/38c172/thumb-up.png" class="mr-1 bringupper tinyicon">{{$tutorial->positive}}</span>
        <span class="mx-1">&middot;</span>
        <span data-toggle="tooltip" title="Number of downvotes"><img src="https://img.icons8.com/small/24/f6993f/thumbs-down--v2.png" class="mr-1 bringupper tinyicon">{{$tutorial->negative}}</span>
    </span><br>
        <a href="{{route("tutorials.creator", ['id' =>$tutorial->content_creator->id, 'slug' => Str::slug($tutorial->content_creator->NAME)])}}" class="text-dark">Created
            by {{$tutorial->content_creator->NAME}}</a>
        @if($tutorial->tier)
            <span class="mx-1">&middot;</span>
            <span class="inforow"><a href="{{route("infopage.tier", ['tier' => $tutorial->tier])}}" class="text-dark"><img src="tiers/{{$tutorial->tier}}.png"
                                                                                                                           alt="{{$tutorial->tier}} tier"
                                                                                                                           class="tinyicon bringupper mr-1">@lang("tiers.".$tutorial->tier) tier</a></span>
        @endif
        @if($tutorial->type)
            <span class="mx-1">&middot;</span>
            <span class="inforow"><a href="{{route("search.do", ['type' => $tutorial->type])}}" class="text-dark"><img src="types/{{ucfirst($tutorial->type)}}.png"
                                                                                                                       alt="{{$tutorial->type}} type"
                                                                                                                       class="tinyicon bringupper mr-1">{{$tutorial->type}} type</a></span>
        @endif
        {{--    <span class="mx-2">&middot;</span>--}}
        <span class="inforow float-right"><img src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/clock.png"
                                               class="mr-1 bringupper tinyicon">Submitted {{\App\Http\Controllers\TimeHelper::timeElapsedString($tutorial->created_at)}}</span>
    </div>
</div>
</div>
