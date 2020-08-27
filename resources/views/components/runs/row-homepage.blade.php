<tr class="action-hover-only">
    <td>
        {!!$item->SHIP_NAME ? "<img src='".\App\Http\Controllers\ThemeController::getShipSizeIconPath($item->IS_CRUISER ? 'cruiser' : 'frigate')."' style='width:20px;height:20px;' alt='Ship class icon'>" : '' !!}
        {!! $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run failed, ship and capsule lost"/>' !!}
    </td>
    <td>
        @if($item->SHIP_ID === null)
            <em class="font-italic text-black-50 ">Unknown</em>
        @else
            <img src="https://imageserver.eveonline.com/Type/{{$item->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" style="border: 1px solid #fff" height="24px" width="24px" alt="">&nbsp;
            <a class="text-dark" href="{{route("search.do", ["ship_id" => $item->SHIP_ID])}}">{{$item->SHIP_NAME}}</a>
        @endif
    </td>
    <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["type" => $item->TYPE])}}">{{$item->TYPE}}</a></td>
    <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["tier" => $item->TIER])}}">{{$item->TIER}}</a></td>
    <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
    <td class="text-right">

        @if($item->RUNTIME_SECONDS == 0)
            <em class="font-italic text-black-50 ">Unknown</em>
        @else
            {{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($item->RUNTIME_SECONDS ?? 0)}}
        @endif
    </td>
    <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}"
                             title="Open"><img
                src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/view-file.png"></a>
    </td>
</tr>
