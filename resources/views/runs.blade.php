@extends("layout.app")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">

            <h2 class="h4">Here you find a list of all recorded runs</h2>
            <p class="text-small">Displaying results <strong>{{$order_type}}</strong> by <strong>{{$order_by}}</strong></p>
        </div>
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm p-0">
                <table class="table table-striped table-sm m-0 table-hover">
                    <tr>
                        <th>Recorded by</th>
                        <th>Abyss type</th>
                        <th>Abyss tier</th>
                        <th class="text-right">Loot value</th>
                        <th>Survived</th>
                        <th>Run at</th>
                        <th>&nbsp;</th>
                    </tr>
                    @foreach($items as $item)
                        <tr class="action-hover-only">
                            <td>{!!$item->PUBLIC ? $item->NAME : '<em class="text-black-50">Pilot hidden</em>' !!}</td>
                            <td>{{$item->TYPE}}</td>
                            <td>{{$item->TIER}}</td>
                            <td class="text-right">{{number_format($item->LOOT_ISK, 0, " ",",")}} ISK</td>
                            <td>{!!$item->SURVIVED ? 'Survived' : '<img src="/dead.png"/>&nbsp;<span class="text-danger">Destroyed</span>'!!}</td>
                            <td>{{$item->RUN_DATE}}</td>
                            <td class="td-action"><img src="https://img.icons8.com/small/16/000000/view-file.png"></td>
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
