<tr>
    <td>
        <a href="{{route("profile.index", ["id" => $item->CHAR_ID])}}" class="{{session()->get("login_id") == $item->CHAR_ID ? "text-danger" : "text-dark"}}">
            <img src="https://images.evetech.net/characters/{{$item->CHAR_ID}}/portrait?size=32" alt="" style="width: 24px; height: 24px; border: 1px solid white" class="rounded-circle shadow-sm mr-2">{{$item->NAME}}
        </a></td>
    <td class="text-right" @if($item->COUNT==420||$item->COUNT==69) data-toggle="tooltip" title="Nice"  @endif>{{$item->COUNT}} runs</td>
</tr>
