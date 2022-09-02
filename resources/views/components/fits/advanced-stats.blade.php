<table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
    <tr>
        <th>Type</th>
        <th>Tier</th>
        <td class="text-right">Runs</td>
        <th class="text-right">Time</th>
        <th class="text-right">ISK/Run</th>
        <th class="text-right">ISK/Hour</th>
        <td class="text-right">Runs 80</td>
        <th class="text-right">Time 80</th>
        <th class="text-right">ISK/Run 80</th>
        <th class="text-right">ISK/Hour 80</th>
    </tr>

    @forelse($advanced_stats as $s)
        <tr>
            <td>
                <img src="types/{{$s->TYPE}}.png" style="width:16px;height:16px;" alt="">
                <a class="text-dark" href="{{route("search.do", ["type" => $s->TYPE])}}">{{$s->TYPE}}</a>
            </td>
            <td>
                <img src="tiers/{{$s->TIER}}.png" style="width:16px;height:16px;" alt="">
                <a class="text-dark" href="{{route("search.do", ["tier" => $s->TIER])}}">{{$s->TIER}}</a>
            </td>
            <td class="text-right">{{$s->COUNT}}</td>
{{--            <td class="text-right">{{sprintf("%02d", floor($s->AVERAGE_TIME/60))}}:{{sprintf("%02d", $s->AVERAGE_TIME%60)}}</td>--}}
            <td class="text-right">{{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($s->AVERAGE_TIME)}}</td>
            <td class="text-right">{{number_format($s->AVERAGE_ISK/1000000,2,","," ")}} M ISK</td>
            <td class="text-right">{{number_format($s->AVERAGE_ISK_BY_HR/1000000,2,","," ")}} M ISK</td>
            <td class="text-right">{{$s->COUNT_80}}</td>
{{--            <td class="text-right">{{sprintf("%02d", floor($s->AVERAGE_TIME_80/60))}}:{{sprintf("%02d", $s->AVERAGE_TIME_80%60)}}</td>--}}
            <td class="text-right">{{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($s->AVERAGE_TIME_80)}}</td>
            <td class="text-right">{{number_format($s->AVERAGE_ISK_80/1000000,2,","," ")}} M ISK</td>
            <td class="text-right">{{number_format($s->AVERAGE_ISK_BY_HR_80/1000000,2,","," ")}} M ISK</td>
        </tr>
        @empty
        <tr>
            <td colspan="10"><p class="y5 text-center font-italic">No advanced stats yet.</p></td>
        </tr>
    @endforelse
</table>
