<div class="text-small">
    <img src="https://images.evetech.net/characters/{{$victim->character->id ?? 1}}/portrait?size=256" alt="{{$victim->character->name ?? "Unknown"}}"  id="char_prof">
    <br>
    <a href="{{route("pvp.character", ['slug' => $victim->pvp_event->slug,'id' => $victim->character->id ?? 1])}}" class="h5 font-weight-bold text-dark mb-1 d-inline-block">{{$victim->character->name ?? "Unknown"}}</a>
    <br>
    <a href="{{route("pvp.corporation", ['slug' => $victim->pvp_event->slug,'id' => $victim->corporation->id ?? 1])}}" class="h6 font-weight-bold text-dark mb-1 d-inline-block">{{$victim->corporation->name ?? "Unknown"}}</a>
    @if($victim->hasAlliance())
        <span class="mx-2">&centerdot;</span>
        <a href="{{route("pvp.alliance", ['slug' => $victim->pvp_event->slug,'id' => $victim->alliance->id ?? 1])}}" class="h6 font-weight-bold text-dark mb-1 d-inline-block">{{$victim->alliance->name ?? "Unknown"}}</a>
    @endif
    <br>
    <a href="{{route("pvp.character", ['slug' => $victim->pvp_event->slug,'id' => $victim->character->id ?? 1])}}" class="text-muted mx-1 ">event profile</a> &centerdot;
    <a href="{{route("profile.index", ['id' => $victim->character->id ?? 1])}}" class="text-muted mx-1 ">Abyss Tracker profile</a> &centerdot;
    <a href="https://zkillboard.com/character/{{$victim->character->id ?? 1}}/" target="_blank" class="text-muted mx-1 ">zKillboard</a>
</div>
