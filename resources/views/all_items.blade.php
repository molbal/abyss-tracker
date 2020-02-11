@extends("layout.app")
@section("browser-title", "All item prices")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-8">
            <h4 class="font-weight-bold">Items that drop in the Abyssal Deadspace</h4>
            <p class="text-small">This information is gathered compiled from <strong>{{$cnt}}</strong> loot submissions
            </p>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="">Quick find an item</label>
                <select id="quickfind" class="form-control select2-default">
                    @foreach($items_select as $s)
                        <option value="{{$s->ITEM_ID}}">{{$s->NAME}} ({{$s->GROUP_NAME}})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm p-0">
                <table class="table table-striped table-sm m-0 table-hover  table-responsive-sm">
                    <tr>
                        <th colspan="2">Name</th>
                        <th>Group</th>
                        <th class="text-right">Sell price</th>
                        <th class="text-right">Buy price</th>
                        <th class="text-center">Drop rate</th>
                    </tr>
                    @foreach($items as $item)
                        <tr class="action-hover-only">
                            <td class="text-center" style="width: 48px;"><img
                                    src="https://imageserver.eveonline.com/Type/{{$item->ITEM_ID}}_32.png" alt=""></td>
                            <td><a href="{{route("item_single", ["item_id" => $item->ITEM_ID])}}">{{$item->NAME}}</a>
                            </td>
                            <td>
                                <a href="{{route("item_group", ["group_id" => $item->GROUP_ID])}}">{{$item->GROUP_NAME}}</a>
                            </td>
                            <td class="text-right">{{number_format($item->PRICE_SELL, 0, ",", " ")}} ISK</td>
                            <td class="text-right">{{number_format($item->PRICE_BUY, 0, ",", " ")}} ISK</td>
                            <td class="text-center">{{round($item->DROP_RATE*100,2)}}%</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="mt-3">
{{--                {{$items->links()}}--}}
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $("#quickfind").on('select2:select', function (e) {
                window.location="/loot/item/"+e.params.data.id;
            })
        });
    </script>
@endsection
