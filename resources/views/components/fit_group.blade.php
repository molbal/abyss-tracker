<table class="table table-responsive-sm table-sm w-100 mb-4">
    <tr>
        <td></td>
        <td>Item name</td>
    </tr>
    @forelse($items as $item)
        @component("components.fitslot", ['item' => $item])@endcomponent
        @empty
        <tr>
            <td colspan="2"><p class="text-center my-2">Nothing in {{$section}}</p></td>
        </tr>
    @endforelse
</table>
