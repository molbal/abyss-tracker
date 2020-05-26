<div class="card card-body border-0 shadow-sm mt-3">
    <div class="d-flex justify-content-between">
        <h6>Profitability</h6>
        @component("components.info-toggle")
            Runtimes are calculated with seconds. User submitted median values are used to find most probable outcomes.
        @endcomponent
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="h4 font-weight-bold mb-0" style="line-height: 1rem;margin-top: 15px;">{{number_format($info["iskPerHour"]/1000000,2,","," ")}}</p>
            <small class="text-muted my-0" style="line-height: 1rem">M ISK/h</small>
        </div>
        <div>
            <table class="table-sm">
                <tr>
                    <td><img src="tiers/{{$info['info']->MAX_TIER}}.png" class="tinyicon" alt=""></td>
                    <td>Tier</td>
                    <td class="text-left">{{$info['info']->MAX_TIER}}</td>
{{--                    <td><span class="text-small bringupper">dps</span></td>--}}
                </tr>
                <tr>
                    <td><img src="types/{{ucfirst(strtolower($info['info']->TYPE))}}.png" class="tinyicon" alt=""></td>
                    <td>Type</td>
                    <td class="text-left">{{$info['info']->TYPE}}</td>
{{--                    <td><span class="text-small bringupper">dps</span></td>--}}
                </tr>
                <tr>
            </table>
        </div>
    </div>
</div>
<div class="card card-body border-0 shadow-sm mt-3">
    <div class="d-flex justify-content-between">
        <h6>Break even point</h6>
        @component("components.info-toggle")
            Runtimes are calculated with seconds. User submitted median values are used to find most probable outcomes.
        @endcomponent
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="h4 font-weight-bold mb-0" style="line-height: 1rem;margin-top: 15px;">{{$info['breakEvenTimeFormatted']}}</p>
            <small class="text-muted my-0" style="line-height: 1rem">hh:mm:ss</small>
        </div>
        <div>
            <table class="table-sm">
                <tr>
                    {{--                    <td><img src="tiers/{{$info['info']->MAX_TIER}}.png" class="tinyicon" alt=""></td>--}}
                    <td>Avg. ISK/run</td>
                    <td class="text-right">{{number_format($info["medianISK"]/1000000,2, ","," ")}}</td>
                    <td><span class="text-small bringupper">M ISK</span></td>
                </tr>
                <tr>
                    {{--                    <td><img src="tiers/{{$info['info']->MAX_TIER}}.png" class="tinyicon" alt=""></td>--}}
                    <td>Avg. run duration</td>
                    <td class="text-right">{{$info["medianRuntimeFormatted"]}}</td>
                    <td><span class="text-small bringupper">time</span></td>
                </tr>
                <tr>
                    {{--                    <td><img src="tiers/{{$info['info']->MAX_TIER}}.png" class="tinyicon" alt=""></td>--}}
                    <td>Break even point</td>
                    <td class="text-right">{{$info["breakEvenRuns"]}}</td>
                    <td><span class="text-small bringupper">runs</span></td>
                </tr>
                <tr>
            </table>
        </div>
    </div>
</div>
