<div class="card card-body border-0 shadow-sm">
    <h5 class="font-weight-bold mb-2">{{$title}}</h5>
    <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
        <tr>
            <th>&nbsp;</th>
            <th>Duration</th>
            <th>Abyss type</th>
            <th>Abyss tier</th>
            <th class="text-right">Loot value</th>
            <th class="text-right">Submitted</th>
            <th> &nbsp;</th>
        </tr>
        @foreach($items as $item)
            @component("components.runs.row", ["item" => $item]) @endcomponent
        @endforeach
    </table>
</div>
<div class="card-footer">
    {!! $items->links() !!}
</div>
