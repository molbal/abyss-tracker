<tr>
    <td colspan="3" class="text-left text-uppercase font-weight-bold"><p class="mb-0 pt-2">{{$section}}</p></td>
</tr>
@forelse($items as $item)
    @component("components.fitslot", ['item' => $item])@endcomponent
    @empty
    <tr>
        <td colspan="2"><p class="text-center my-1 text-muted">Nothing in {{$section}}</p></td>
    </tr>
@endforelse
