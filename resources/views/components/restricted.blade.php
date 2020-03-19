@if($public)
    {{$slot}}
    @else
<div class="card card-body border-0 shadow-sm mt-3">
    <span class="py-3 text-italic"><img width="{{$icon_size ?? 32}}" height="{{$icon_size ?? 32}}" src="https://img.icons8.com/cotton/{{$icon_size ?? 32}}/000000/delete-shield.png"/> <strong>{{$title}}</strong> is hidden.</span>
</div>
@endif
