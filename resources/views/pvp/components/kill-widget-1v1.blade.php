<div class="card shadow-sm border-0 rounded-t mb-3 card-body">
    <div>
    <img src="https://images.evetech.net/characters/{{$victim->character->id}}/portrait?size=64" class="mr-1 rounded-circle shadow-sm smallicon" style="border: 1px solid #fff;">{{$victim->character->name}}'s <img src="https://imageserver.eveonline.com/Type/{{$victim->ship_type->id}}_64.png" class="mr-1 rounded-circle shadow-sm smallicon" style="border: 1px solid #fff;">{{$victim->ship_type->name}} was killed
    @if($victim->attackers->pluck('character.name')->filter()->isEmpty())
        <span class="text-muted">by NPCs only</span>
    @else
        @foreach($victim->attackers as $attacker)
            @if(!$attacker->character) @continue @endif
            <img src="https://images.evetech.net/characters/{{$attacker->character->id}}/portrait?size=64" class="mr-1 rounded-circle shadow-sm smallicon" style="border: 1px solid #fff;">{{$attacker->character->name}}
        @endforeach
    @endif
    </div>
</div>
{{--<div class="card-footer rounded-b rounded-t-none mb-3">e</div>--}}
