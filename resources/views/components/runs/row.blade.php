<tr class="action-hover-only">
    <td>
        {!! $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run railed, ship and capsule lost"/>' !!}
    </td>
    @if($item->RUNTIME_SECONDS)
        <td>{{sprintf("%02d", floor($item->RUNTIME_SECONDS/60))}}:{{sprintf("%02d", $item->RUNTIME_SECONDS%60)}}</td>
    @else
        <td class="font-italic">Unknown runtime</td>
    @endif
    <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["type" => $item->TYPE])}}">{{$item->TYPE}}</a></td>
    <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["tier" => $item->TIER])}}">{{$item->TIER}}</a></td>
    <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
    <td class="text-right">{{date("Y-m-d H:i:s", strtotime($item->CREATED_AT))}}</td>
    <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}"
                             title="Open"><img
                src="https://img.icons8.com/small/24/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/chevron-right.png" class="tinyicon"></a>
    </td>
</tr>
