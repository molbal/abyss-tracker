<tr>

    <td>{{@$item->created_at->format("Y F d H:i:s")}}</td>
    <td>{{$item->event}}</td>
    <td><a href="{{route("fit_single", ['id' => $item->fit_it])}}">Fit #{{$item->fit_it}}</a></td>
</tr>
