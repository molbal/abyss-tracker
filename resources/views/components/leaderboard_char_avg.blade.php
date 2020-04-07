<tr>
    <td>
        <a href="{{route("profile.index", ["id" => $item->CHAR_ID])}}" class="{{session()->get("login_id") == $item->CHAR_ID ? "text-danger" : "text-dark"}}">
            <img src="https://images.evetech.net/characters/{{$item->CHAR_ID}}/portrait?size=32" alt="" style="width: 24px; height: 24px" class="rounded-circle shadow-sm">
            &nbsp;{{$item->NAME}}
        </a></td>
    <td class="text-right">{{number_format($item->AVG/1000000, 2, ","," ")}}M ISK</td>
</tr>
