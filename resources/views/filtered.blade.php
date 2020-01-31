@extends("layout.app")
@section("content")

    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold">Displaying tier {{$tier}} {{$type}} records</h4>
        <p class="">Total count {{$items->total()}}</p>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            @if (count($items) > 0)
            <div class="card card-body border-0 shadow-sm p-0">
                <table class="table table-striped table-sm m-0 table-hover">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Ship name</th>
                        <th class="text-right">Loot value </th>
                        <th>Run at </th>
                        <th>&nbsp;</th>
                    </tr>
                    @foreach($items as $item)
                        <tr class="action-hover-only">
                            <td>
                                {!!$item->SHIP_NAME ? ($item->IS_CRUISER ? '<img src="/overview/cruiser.png" data-toggle="tooltip" title="Cruiser run">' : '<img src="/overview/frigate.png" data-toggle="tooltip" title="Frigate run">') : '' !!}
                                {!! $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run railed, ship and capsule lost"/>' !!}
                            </td>
                            <td>{!! $item->SHIP_NAME ?? '<em class="text-black-50">Unknown</em>' !!}</td>
                            <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
                            <td>{{$item->RUN_DATE}}</td>
                            <td class="td-action"><a href="{{route("view_single", ["id" => $item->ID])}}" title="Open"><img src="https://img.icons8.com/small/16/000000/view-file.png"></a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="mt-3">
                {{$items->links()}}
            </div>
                @else

                <div class="card card-body border-warning shadow-sm ">
                    <p class="mb-0">Sorry, we do not have a record for this yet. If you recently ran one please <a href="{{route("new")}}">contribute</a></p>
                </div>
            @endif
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
