<div class="">
    <a href="{{route("tutorials.get", ['id' => $tutorial->id, 'slug' => Str::slug($tutorial->name)])}}" class="h4 text-dark">{{$tutorial->name}}</a><br>
    <a href="{{route("tutorials.creator", ['id' =>$tutorial->content_creator->id, 'slug' => Str::slug($tutorial->content_creator->NAME)])}}" class="text-dark">Created by {{$tutorial->content_creator->NAME}}</a>
    @if($tutorial->tier)
        <span class="mx-2">&middot;</span>
        <span class="inforow"><img src="tiers/{{$tutorial->tier}}.png" alt="{{$tutorial->tier}} tier" class="tinyicon"> @lang("tiers.".$tutorial->tier) tier</span>
    @endif
    @if($tutorial->type)
    <span class="mx-2">&middot;</span>
    <span class="inforow"><img src="types/{{ucfirst($tutorial->type)}}.png" alt="{{$tutorial->type}} type" class="tinyicon"> {{$tutorial->type}} type</span>
    @endif
    <span class="mx-2">&middot;</span>
    <span class="inforow">Uploaded {{\App\Http\Controllers\TimeHelper::timeElapsedString($tutorial->uploaded_at)}}</span>
</div>
