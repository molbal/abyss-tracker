<div class="card card-body border-0 shadow-sm mt-3">
    <h5 class="font-weight-bold"><img src="types/{{ucfirst(strtolower($info['info']->TYPE))}}.png"  class="tinyicon bringupper" alt=""> {{$info['info']->TYPE}}</h5>
    <p class="mb-1">
        This fit can do tier <strong>{{$info['info']->MAX_TIER}}</strong> runs. This fits' most probable total loot value is <strong>{{number_format($info["medianISK"]/1000000,2, ","," ")}}</strong> M ISK and usually finishes sites in <strong>{{$info["medianRuntimeFormatted"]}}</strong>.
    </p>
    <p class="mb-1">
        It will take <strong>{{$info['breakEvenTimeFormatted']}}</strong> (<strong>{{$info["breakEvenRuns"]}}</strong> runs) for the ship to pay for itself after purchase and fitting. ({{number_format($price/1000000, 2, ",", " ")}} M ISK)
    </p>
    <p class="mb-0">It is approximately net {{number_format($info["iskPerHour"]/1000000,2,","," ")}} M ISK/h</p>
</div>
