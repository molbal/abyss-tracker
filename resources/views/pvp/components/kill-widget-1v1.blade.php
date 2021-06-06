<div class="card card-body shadow-sm {{isset($loss) && $loss ? 'border-danger' : 'border-info'}} rounded mb-3">
    <table class="w-100">
        <tr>
            <td style="width:96px;text-align: center">
                @if($victim->firstAttacker())
                    @if($victim->firstAttacker()->isCapsuleer())
                        <a href="{{route('pvp.character',['slug' => $event->slug, 'id' => $victim->firstAttacker()->character->id])}}" data-toggle="tooltip" title="{{$victim->firstAttacker()->character->name ?? ""}}"><img src="{{\App\Http\Controllers\HelperController::getCharImgLink($victim->firstAttacker()->character->id ?? null)}}" class="mb-1 rounded-circle shadow-sm pvp-icon-lg"></a>
                        <br>
                        <a href="{{route('pvp.ship',['slug' => $event->slug, 'id' => $victim->firstAttacker()->ship_type->id ?? 0])}}" data-toggle="tooltip" title="{{$victim->firstAttacker()->ship_type->name ?? ""}}"><img src="{{\App\Http\Controllers\HelperController::getItemImgLink($victim->firstAttacker()->ship_type->id ?? 0)}}" class="mr-1 rounded-circle shadow-sm pvp-icon-md"></a>
                        @if($victim->firstAttacker()->hasWeaponInfo())
                            <a href="{{route('pvp.item',['slug' => $event->slug, 'id' => $victim->firstAttacker()->weapon_type->id])}}" data-toggle="tooltip" title="{{$victim->firstAttacker()->weapon_type->name ?? ""}}"><img src="{{\App\Http\Controllers\HelperController::getItemImgLink($victim->firstAttacker()->weapon_type->id ?? $victim->firstAttacker()->ship_type->id)}}" class="mr-1 rounded-circle shadow-sm pvp-icon-md"></a>
                        @endif
                    @else
                        <a href="{{route('pvp.item',['slug' => $event->slug, 'id' => $victim->firstAttacker()->ship_type->id])}}"><img src="{{\App\Http\Controllers\HelperController::getItemImgLink($victim->firstAttacker()->ship_type->id ?? 0)}}" class="mr-1 rounded-circle shadow-sm pvp-icon-lg"></a>
                    @endif
                @else
                    <img src="{{\App\Http\Controllers\ThemeController::getGlitchIcon()}}" class="mr-1 rounded-circle shadow-sm pvp-icon-lg" style="object-fit: cover;">
                @endif
            </td>
            <td style="text-align: center; width: 33%"  >
                @if($victim->firstAttacker())
                    @if($victim->firstAttacker()->isNpc())
                        <a href="{{route('pvp.item',['slug' => $event->slug, 'id' => $victim->firstAttacker()->ship_type->id])}}"><span class="h5 font-weight-bold text-capitalize">NPC {{$victim->firstAttacker()->ship_type->name}}</span></a>
                    @else
                        <a href="{{route('pvp.character',['slug' => $event->slug, 'id' => $victim->firstAttacker()->character->id])}}"><span class="h5 font-weight-bold text-capitalize">{{$victim->firstAttacker()->character->name ?? ""}}</span></a><br>
                        <small class="text-muted">flying </small><br>
                        <a href="{{route('pvp.ship',['slug' => $event->slug, 'id' => $victim->firstAttacker()->ship_type->id ?? 0])}}"><span class="h6">{{$victim->firstAttacker()->ship_type->name ?? ""}}</span></a>
                    @if($victim->firstAttacker()->hasWeaponInfo())
                        <small class="text-muted">with</small>
                            <a href="{{route('pvp.item',['slug' => $event->slug, 'id' => $victim->firstAttacker()->weapon_type->id])}}" data-toggle="tooltip" title="{{$victim->firstAttacker()->weapon_type->name ?? ""}}"><span class="h6">{{Str::limit($victim->firstAttacker()->weapon_type->name ?? "", 12)}}</span></a>
                        @endif
                    @endif
                    @if($victim->attackers->count() > 1)
                            <br><span class="text-muted">+{{$victim->attackers->count()-1}} more</span>
                    @endif
                @else
                    <span class="text-muted">Unknown attackers <br><small>Abyss Tracker error</small></span>
                @endif
            </td>
            <td>
                <a data-toggle="tooltip" title="Open killmail" href="{{route('pvp.kill', ['id' => $victim->killmail_id])}}" style="text-decoration: underline">killed</a>
            </td>
            <td style="text-align: center;; width: 33%">
                <a href="{{route('pvp.character',['slug' => $event->slug, 'id' => $victim->character->id])}}"><span class="h5 font-weight-bold text-capitalize">{{$victim->character->name ?? ""}}</span></a><br>
                <small class="text-muted">flying</small><br>
                <a href="{{route('pvp.ship',['slug' => $event->slug, 'id' => $victim->ship_type->id])}}"><span class="h6">{{$victim->ship_type->name ?? ""}}</span></a>
            </td>
            <td style="width:96px;text-align: center">
                <a href="{{route('pvp.character',['slug' => $event->slug, 'id' => $victim->character->id])}}" data-toggle="tooltip" title="{{$victim->character->name ?? ""}}"><img src="https://images.evetech.net/characters/{{$victim->character->id}}/portrait?size=128" class="mb-1 rounded-circle shadow-sm pvp-icon-lg"></a><br>
                <a href="{{route('pvp.ship',['slug' => $event->slug, 'id' => $victim->ship_type->id])}}" data-toggle="tooltip" title="{{$victim->ship_type->name ?? ""}}"><img src="https://imageserver.eveonline.com/Type/{{$victim->ship_type->id}}_64.png" class="mr-1 rounded-circle shadow-sm pvp-icon-md"></a>
            </td>
        </tr>
    </table>
</div>
{{--<div class="card-footer">--}}
{{--    <a href="{{$victim->littlekill['url']}}">zkill</a>--}}
{{--</div>--}}
