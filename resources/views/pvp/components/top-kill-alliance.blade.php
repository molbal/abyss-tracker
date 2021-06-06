<tr>
    <td class="font-weight-bold text-right">{{$i}}.</td>
    <td>
        <a href="{{route("pvp.alliance", ['slug' => $event->slug, "id" => $item->id])}}" class="{{\App\Http\Controllers\Auth\AuthController::isItMe($item->id) ? "text-danger" : "text-dark"}}" data-toggle="tooltip" title="{{$item->name}}">
            <img loading="lazy" src="https://images.evetech.net/alliances/{{$item->id}}/logo?size=32" alt="" style="width: 24px; height: 24px; border: 1px solid white" class="rounded-circle shadow-sm mr-2">{{Str::limit($item->name, 18)}}
        </a></td>
    <td class="text-right" @if($item->kills_count==420||$item->kills_count==69) data-toggle="tooltip" title="Nice"  @endif>{{$item->kills_count}} kills</td>
</tr>
<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>
