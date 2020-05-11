@php
$stats = json_decode($row->STATS)
@endphp
<tr class="text-down">
    <td rowspan="2">
        <a href="{{route("fit_single", ["id" => $row->ID])}}" data-toggle="tooltip" title="Click to open fit" style="vertical-align: middle">
            <img src="https://images.evetech.net/types/{{$row->SHIP_ID}}/render?size=64" class="rounded-circle shadow my-3" style="width: 48px; height: 48px; border: 2px solid #fff">
        </a>
    </td>
    <td><span class="h6 font-weight-bold mb-0" style="vertical-align: bottom">{{$row->NAME}}</span></td>
    <td rowspan="1" class="text-right"><span class="" style="vertical-align: bottom">{{round($stats->offense->totalDps)}} <small>dps</small></span></td>
    <td rowspan="1" class="text-right"><span class="" style="vertical-align: bottom">{{round($stats->defense->reps->burst->total)}} <small>ehp/s</small></span></td>
    <td rowspan="1" class="text-right"><span class="" style="vertical-align: bottom">{{round($stats->misc->maxSpeed)}} <small>m/s</small></span></td>
    <td rowspan="1" class="text-right"><span class="" style="vertical-align: bottom">{{number_format($row->PRICE/1000000, 0, ",", " ")}} M <small>ISK</small></span></td>
</tr>
<tr class="border-bottom" class="text-up">
    <!-- icon -->
    <td><span class="text-muted text-small"  style="vertical-align: top">{{$row->SHIP_NAME}}</span></td>
    <td colspan="4">
        @foreach($row->TAGS as $match)
            @if ($match->TAG_VALUE == 1)
                @component("components.fits.filter.fit-tag-sm") {{$match->TAG_NAME}} @endcomponent
            @endif
        @endforeach
    </td>
</tr>
