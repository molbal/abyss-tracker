@php
    $stats = @json_decode($row->STATS)
@endphp
<tr class="text-down">
    <td rowspan="2" class="text-center">
        <a href="{{route("fit_single", ["id" => $row->ID])}}" data-toggle="tooltip" title="Click to open fit" style="vertical-align: middle; height: 48px;" class="d-inline-block">
            <img src="https://images.evetech.net/types/{{$row->SHIP_ID}}/render?size=64" class="rounded-circle shadow" style="width: 48px; height: 48px; border: 2px solid #fff">
        </a>
    </td>
    <td><span class="h6 font-weight-bold mb-0 moveabitdown" style="vertical-align: bottom">
            <a href="{{route("fit_single", ["id" => $row->ID])}}" data-toggle="tooltip" title="Click to open fit" class="text-dark">{{$row->NAME}}
            </a></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round($stats->offense->totalDps ?? 0)}} <small>dps</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round($stats->defense->reps->burst->total ?? 0)}} <small>ehp/s</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round(($stats->defense->ehp->total ?? 0)/1000)}} <small>k ehp</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{round($stats->misc->maxSpeed ?? 0)}} <small>m/s</small></span></td>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{number_format($row->PRICE/1000000, 0, ",", " ")}} M <small>ISK</small></span>
    <td rowspan="1" class="text-right"><span class="moveabitdown" style="vertical-align: bottom">{{number_format($row->RUNS_COUNT, 0, ",", " ")}} </span>
    </td>
</tr>
<tr class="{{$admin == false ? "border-bottom" : ""}} text-up">
    <!-- icon -->
    <td>
        <span class="text-muted text-small moveabitup" style="vertical-align: top">
            <a href="{{route("fit.search", ["SHIP_ID" => $row->SHIP_ID])}}" target="_blank">{{$row->SHIP_NAME}}</a> &centerdot;
            <a href="{{route("fit.search", ["SHIP_GROUP" => $row->GROUP])}}" target="_blank">{{$row->GROUP}}</a>
        </span>
    </td>
    <td colspan="6">
        <div class="moveabitup d-flex justify-content-between">
            <div>
            @if($row->VIDEO_LINK)
                @component("components.fits.filter.fit-tag-sm", ['prefix' => '<img src="https://img.icons8.com/ios-glyphs/10/ffffff/video-call.png"/>']) TagVideo @endcomponent
            @endif
            @foreach($row->TAGS as $match)
                @if ($match->TAG_VALUE == 1)
                    @component("components.fits.filter.fit-tag-sm") {{$match->TAG_NAME}} @endcomponent
                @endif
            @endforeach
            </div>
        </div>
    </td>
</tr>
@if($admin)
    <tr class="border-bottom text-up">
        <td colspan="2">
            <span>Privacy status: <STRONG>{{$row->PRIVACY}}</STRONG></span>
        </td>
        <td colspan="5">
            <span>Set privacy to: </span>
            <a href="{{route("fit.change_privacy", ['id' => $row->ID, 'privacySetting' => 'public'])}}" class="text-dark font-weight-bold">Public</a>
            <span class="d-inline-block mx-1">&middot;</span>
            <a href="{{route("fit.change_privacy", ['id' => $row->ID, 'privacySetting' => 'incognito'])}}" class="text-dark font-weight-bold">Incognito</a>
            <span class="d-inline-block mx-1">&middot;</span>
            <a href="{{route("fit.change_privacy", ['id' => $row->ID, 'privacySetting' => 'private'])}}" class="text-dark font-weight-bold">Private</a>
        </td>
{{--        <td colspan="2" class="text-right">--}}
{{--            <span>Uploaded {{\App\Http\Controllers\TimeHelper::timeElapsedString($row->Submitted)}}</span>--}}
{{--        </td>--}}
        <td colspan="2" class="text-right">
            <a href="{{route("fit.delete", ['id' => $row->ID])}}" class="text-danger">Delete fit <img src="https://img.icons8.com/color/48/000000/delete-sign.png" class="tinyicon bringupper"/></a>
        </td>
    </tr>
@endif
