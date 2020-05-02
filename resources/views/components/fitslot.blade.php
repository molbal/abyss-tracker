<tr>
    <td style="width: 36px;">
        @if($item["id"])
            <img src="https://imageserver.eveonline.com/Type/{{$item["id"]}}_32.png" alt="{{$item["name"]}} icon" style="width: 32px;height: 32px;">
        @else

        @endif
    </td>
    <td>
        {{$item["name"]}}
        @if ($item["ammo"] != "" )
            <sub class="bringupper">with <img src="https://imageserver.eveonline.com/Type/{{$item["ammo_id"]}}_32.png" alt="{{$item["name"]}} icon" style="width: 16px;height: 16px;"> {{$item["ammo"]}}</sub>
        @endif
        @if ($item["count"] != "" && $item["count"] != 1)
            <sub class="bringupper">x{{$item["count"]}}</sub>
        @endif
    </td>
    <td class="text-right">
        {{number_format($item["count"]*$item["price"], 0, ",", " ")}} ISK
    </td>
</tr>
