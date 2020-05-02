<tr>
    <td>
        @if($item["id"])
            <img src="https://imageserver.eveonline.com/Type/{{$item["id"]}}_32.png" alt="{{$item["name"]}} icon" style="width: 32px;height: 32px;">
        @else

        @endif
    </td>
    <td>
        {{$item["name"]}}
        @if ($item["ammo"])<sub>x{{$item["count"]}}</sub>
    </td>
</tr>
