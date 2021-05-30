<div class="card card-body shadow-sm border-0 mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="" style="width: 191px; text-align: center;">
                <img src="https://images.evetech.net/types/{{$victim->ship_type->id}}/render?size=128"
                     id="ship_prof">
                <br>
                <div>
                    <h2 class="font-weight-bold mb-0 mt-3" style="line-height: 1.6rem">
                        <a class="text-dark" href="{{route('pvp.ship', ['slug' => $victim->pvp_event->slug,'id' => $victim->ship_type->id])}}">{{$victim->ship_type->name}}</a>
                    </h2>
                    <small class="text-muted font-weight-bold">{{$victim->ship_type->group_type->name}}</small>
                </div>
            </div>
        </div>
        <div>
            <ul class="infolinks text-small">
                <li><a href="{{route('pvp.ship', ['slug' => $victim->pvp_event->slug,'id' => $victim->ship_type->id])}}" class="text-muted">ship usage</a></li>
                <li><a href="https://zkillboard.com/ship/{{$victim->ship_type->id}}/" target="_blank" class="text-muted">killboard</a></li>
            </ul>
        </div>
    </div>
</div>
