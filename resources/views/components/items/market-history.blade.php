<div class="card card-body border-0 shadow-sm px-0 pt-0 pb-2">
    <h5 class="font-weight-bold p-3">Market history {{$itemName ?? null ? "for $itemName" : ""}}</h5>
    <div class="h-400px graph-container">{{$marketHistory->container()}}</div>
</div>
<div class="card-footer">
    @component("components.info-line")
        Data source: ESI &middot; Cached for up to 12 hours &middot; Data displays Forge region aggregates
    @endcomponent
</div>
