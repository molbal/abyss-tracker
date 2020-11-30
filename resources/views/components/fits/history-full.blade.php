<table class="table table-sm w-100">
    <tr>
        <th>Datetime</th>
        <th>Event</th>
        <th>Fit version</th>
    </tr>
    @forelse($history as $item)
        @component("components.fits.fithistory", ['item'=>$item]) @endcomponent
    @empty
        <tr>
            <td colspan="3">
                <p class="py-5 text-center font-italic text-muted">No fit history available</p>
            </td>
        </tr>
    @endforelse
</table>
<hr>
@component("components.info-line")
    @lang("fits.records-notice", ['date' => config("tracker.fit.logs.initial-date")])
@endcomponent
