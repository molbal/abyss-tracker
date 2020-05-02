<tr>
    <td colspan="3" class="text-left text-uppercase font-weight-bold">{{$section}}</td>
</tr>
@forelse($items as $item)
    @component("components.fitslot", ['item' => $item])@endcomponent
    @empty
    <tr>
        <td colspan="2"><p class="text-center my-2">Nothing in {{$section}}</p></td>
    </tr>
@endforelse
