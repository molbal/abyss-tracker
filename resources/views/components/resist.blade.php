<div>
{{--    <span class="inline-pie">{{$resist*100}},{{100-$resist*100}}</span>--}}
    <div class="resist-outer" style="background: {{$bg}}" data-toggle="tooltip" title="{{round($resist, 4)*100}}%">
        <div class="resist-inner" style="width: {{round($resist, 2)*100}}%; background: {{$fg}};">&nbsp;</div>
        <span class="resist-label">{{round($resist, 2)*100}}%</span>
    </div>
</div>
