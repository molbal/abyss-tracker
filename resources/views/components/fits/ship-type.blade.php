<div class="card card-body shadow-sm border-0 mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="" style="width: 191px; text-align: center;">
                <img src="https://images.evetech.net/types/{{$fit->SHIP_ID}}/render?size=128"
                     id="ship_prof">
                <br>
                <div>
                    <h2 class="font-weight-bold mb-0 mt-3" style="line-height: 1.6rem">
                        <a class="text-dark" href="{{route("ship_single", ["id" => $fit->SHIP_ID])}}">{{$ship_name}}</a>
                    </h2>
                    <small class="text-muted font-weight-bold">{{$ship_type}}</small>
                </div>
            </div>
        </div>
        <div>
            <ul class="infolinks text-small">
                <li><a href="{{route('ship_single', ['id' => $fit->SHIP_ID])}}" class="text-muted">ship usage</a></li>
                <li><a href="{{route('fit.search', ['SHIP_ID' => $fit->SHIP_ID])}}" class="text-muted">ship fits</a></li>
                <li><a href="https://zkillboard.com/ship/{{$fit->SHIP_ID}}/" target="_blank" class="text-muted">killboard</a></li>
                <li><a href="https://www.eveworkbench.com/fitting/search?ships={{$fit->SHIP_ID}}" target="_blank" class="text-muted">eve wbench</a></li>
            </ul>
        </div>
    </div>
</div>
