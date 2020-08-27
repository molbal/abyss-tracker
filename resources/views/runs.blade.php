@extends("layout.app")
@section("browser-title", "All runs")
@section("content")
    <div class="row mt-5">
        <div class="col-xs-12 col-sm-8 offset-md-2">
            <div class="alert alert-warning">
                This view is past its usefulness. I recommend you use <a class="btn btn-sm btn-secondary"
                                                                          href="{{route("search.index")}}">
                    <img src="https://img.icons8.com/small/32/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor("search.index" == Route::currentRouteName() || "search.index" == Route::currentRouteName())}}/search.png" class="smallicon mr-1">Search</a> as it might be removed in a future version.
            </div>
        </div>
        <div class="col-sm-12">
            <h4 class="font-weight-bold">Here you find a list of all recorded runs</h4>
            <p class="text-small">Displaying results <strong>{{$order_type}}</strong> by <strong>{{$order_by}}</strong></p>
        </div>
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm p-0">
                <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Ship name</th>
                        <th>Abyss type <a href="{{route("runs", ["order_by" => 'TYPE', "order_type" => "DESC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-down.png"></a><a href="{{route("runs", ["order_by" => 'TYPE', "order_type" => "ASC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-up.png"></a> </th>
                        <th>Abyss tier <a href="{{route("runs", ["order_by" => 'TIER', "order_type" => "DESC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-down.png"></a><a href="{{route("runs", ["order_by" => 'TIER', "order_type" => "ASC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-up.png"></a> </th>
                        <th class="text-right">Loot value <a href="{{route("runs", ["order_by" => 'LOOT_ISK', "order_type" => "DESC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-down.png"></a><a href="{{route("runs", ["order_by" => 'LOOT_ISK', "order_type" => "ASC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-up.png"></a> </th>
                        <th>Run at <a href="{{route("runs", ["order_by" => 'RUN_DATE', "order_type" => "DESC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-down.png"></a><a href="{{route("runs", ["order_by" => 'RUN_DATE', "order_type" => "ASC"])}}"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/sort-up.png"></a> </th>
                        <th>&nbsp;</th>
                    </tr>
                    @foreach($items as $item)
                        <tr class="action-hover-only">
                            <td>
                                {!!$item->SHIP_NAME ? ($item->IS_CRUISER ? '<img src="/overview/cruiser.png" data-toggle="tooltip" title="Cruiser run">' : '<img src="/overview/frigate.png" data-toggle="tooltip" title="Frigate run">') : '' !!}
                                {!! $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run railed, ship and capsule lost"/>' !!}
                            </td>
                            <td>
                                @if($item->SHIP_ID === null)
                                    <em class="font-italic text-black-50 ">Unknown</em>
                                @else
                                    <img src="https://imageserver.eveonline.com/Type/{{$item->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" height="24px" width="24px" alt="">&nbsp;
                                    <a class="text-dark" href="{{route("search.do", ["ship_id" => $item->SHIP_ID])}}">{{$item->SHIP_NAME}}</a>
                                @endif
                            </td>
                            <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["type" => $item->TYPE])}}">{{$item->TYPE}}</a></td>
                            <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="{{route("search.do", ["tier" => $item->TIER])}}">{{$item->TIER}}</a></td>
                            <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
                            <td>{{$item->RUN_DATE}}</td>
                            <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}" title="Open"><img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/view-file.png"></a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="mt-3">
                {{$items->links()}}
            </div>
        </div>
    </div>
@endsection

@section("scripts")

    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-0d'
        });

        // When ready.
        $(function () {

            var $form = $("form");
            var $input = $form.find("input#loot");

            $input.on("keyup", function (event) {

                // When user select text in the document, also abort.
                var selection = window.getSelection().toString();
                if (selection !== '') {
                    return;
                }

                // When the arrow keys are pressed, abort.
                if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                    return;
                }


                var $this = $(this);

                // Get the value.
                var input = $this.val();

                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt(input, 10) : 0;

                $this.val(function () {
                    return (input === 0) ? "" : input.toLocaleString("en-US");
                });
            });

            $form.submit(function (e) {
                $input.val($input.val().split(',').join(''));

            });
        });
    </script>
@endsection
