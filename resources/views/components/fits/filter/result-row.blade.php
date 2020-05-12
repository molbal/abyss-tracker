@php
    $stats = json_decode($row->STATS)
@endphp
<tr class="text-down">
    <td rowspan="2" class="text-center">
        <a href="{{route("fit_single", ["id" => $row->ID])}}" data-toggle="tooltip" title="Click to open fit" style="vertical-align: middle; height: 48px;" class="d-inline-block">
            <img src="https://images.evetech.net/types/{{$row->SHIP_ID}}/render?size=64" class="rounded-circle shadow" style="width: 48px; height: 48px; border: 2px solid #fff">
        </a>
    </td>
    <td><span class="h6 font-weight-bold mb-0 moveabitdown" style="vertical-align: bottom">{{$row->NAME}}</span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round($stats->offense->totalDps)}} <small>dps</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round($stats->defense->reps->burst->total)}} <small>ehp/s</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round($stats->defense->ehp->total/1000)}} <small>k ehp</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round($stats->misc->maxSpeed)}} <small>m/s</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{number_format($row->PRICE/1000000, 0, ",", " ")}} M <small>ISK</small></span>
    </td>
</tr>
<tr class="border-bottom text-up">
    <!-- icon -->
    <td><span class="text-muted text-small moveabitup" style="vertical-align: top">{{$row->SHIP_NAME}} {{$row->RUNS_COUNT}}</span></td>
    <td colspan="4">
        <div class="moveabitup">
            @if($row->VIDEO_LINK)
                @component("components.fits.filter.fit-tag-sm", ['prefix' => '<img src="https://img.icons8.com/ios-glyphs/10/ffffff/video-call.png"/>']) TagVideo @endcomponent
            @endif
            @foreach($row->TAGS as $match)
                @if ($match->TAG_VALUE == 1)
                    @component("components.fits.filter.fit-tag-sm") {{$match->TAG_NAME}} @endcomponent
                @endif
            @endforeach
        </div>
    </td>
</tr>
