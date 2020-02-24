@extends("layout.app")
@section("browser-title", "$name")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">
            <img src="https://images.evetech.net/types/{{$id}}/render?size=64"
                 class="pull-left ml-2 rounded-circle shadow-sm"> {{$name}} overview</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Popularity over the last 3 months <small class="float-right">This graph shows the percentage of Abyss runs using/day using a {{$name}}</small></h5>
                {!! $pop_chart->container() !!}
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Ship usage by tier</h5>
                {!! $pop_tiers->container() !!}
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Ship usage by weather</h5>
                {!! $pop_types->container() !!}
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-8">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Last {{$name}} runs</h5>
                <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Duration</th>
                        <th>Abyss type</th>
                        <th>Abyss tier</th>
                        <th class="text-right">Loot value</th>
                        <th class="text-right" colspan="2">Submitted</th>
                    </tr>
                    @foreach($items as $item)
                        <tr class="action-hover-only">
                            <td>
                                {!! $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run railed, ship and capsule lost"/>' !!}
                            </td>
                            @if($item->RUNTIME_SECONDS)
                                <td>{{sprintf("%02d", floor($item->RUNTIME_SECONDS/60))}}:{{sprintf("%02d", $item->RUNTIME_SECONDS%60)}}</td>
                            @else
                                <td class="font-italic">Unknown runtime</td>
                            @endif
                            <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;"
                                     alt=""> {{$item->TYPE}}</td>
                            <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;"
                                     alt=""> {{$item->TIER}}</td>
                            <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
                            <td class="text-right">{{date("Y-m-d H:i:s", strtotime($item->CREATED_AT))}}</td>
                            <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}"
                                                     title="Open"><img
                                        src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/view-file.png"></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="card-footer">
                {!! $items->links() !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-4">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Death reasons</h5>
                {!! $death_chart->container() !!}
            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">Looting strategy</h5>
                {!! $loot_chart->container() !!}
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    {!! $pop_chart->script() !!}
    {!! $pop_tiers->script() !!}
    {!! $pop_types->script() !!}
    {!! $death_chart->script() !!}
    {!! $loot_chart->script() !!}
@endsection
