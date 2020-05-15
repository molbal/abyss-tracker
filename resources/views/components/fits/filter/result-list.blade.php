<table class="table table-sm table-responsive-md">
    <tr>
        <td>&nbsp;</td>
        <td class="text-muted text-left">Name</td>
        <td class="text-muted text-right">Total DPS</td>
        <td class="text-muted text-right">Total rep</td>
        <td class="text-muted text-right">Total ehp</td>
        <td class="text-muted text-right">Max speed</td>
        <td class="text-muted text-right">Total cost</td>
        <td class="text-muted text-right">Runs count</td>
    </tr>
    @forelse($results as $row)
        @component("components.fits.filter.result-row", ["row" => $row])@endcomponent
    @empty
        <tr>
            <td colspan="8" class="text-center py-2">No results<br><small><a href="{{route("fit_new")}}" target="_blank">Upload a new fit</a></small></td>
        </tr>
    @endforelse
</table>
