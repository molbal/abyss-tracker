@php
    /** @var \App\Models\Models\Partners\NPC $npc */
    /** @var int $count */
@endphp
<div  class="text-dark d-inline-block p-2 m-1 npc rounded shadow-sm" >
    <small>{{$count}}x</small>
    <img loading="lazy"
         src="https://images.evetech.net/types/{{$npc->typeId}}/icon?size=128"
         alt=""
         style="border: 1px solid white"
         class="rounded-circle shadow-sm mx-2 h-24px">
    <a href="{{route("profile.index", ["id" => $npc->typeId])}}">{{$npc->typeName}}</a>
</div>
