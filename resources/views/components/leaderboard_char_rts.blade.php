<tr>
    <td>
        <a href="{{route("profile.index", ["id" => $item->CHAR_ID])}}">
            <img src="https://images.evetech.net/characters/{{$item->CHAR_ID}}/portrait?size=32" alt="" style="width: 24px; height: 24px" class="rounded-circle shadow-sm">
            &nbsp;{{$item->NAME}}
        </a></td>
    <td class="text-right">{{sprintf("%02d", $item->AVG/60)}}:{{sprintf("%02d", $item->AVG%60)}}</td>
</tr>
