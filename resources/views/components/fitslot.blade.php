<tr>
    <td style="width: 36px;">
        @if($item["id"])
            <img src="https://imageserver.eveonline.com/Type/{{$item["id"]}}_32.png" alt="{{$item["price"]->getAveragePrice()}} icon" style="width: 32px;height: 32px;">
        @else

        @endif
    </td>
    <td>
        {{$item["price"]->getName()}}
        @if ($item["ammo"] != "" )
            <sub class="bringupper">with <img src="https://imageserver.eveonline.com/Type/{{$item["ammo_id"]}}_32.png" alt="{{$item["name"]}} icon" style="width: 16px;height: 16px;"> {{$item["ammo"]}}</sub>
        @endif
        @if ($item["count"] != "" && $item["count"] != 1)
            <sub class="bringupper">x{{$item["count"]}}</sub>
        @endif
    </td>
    <td class="text-right" data-toggle="tooltip"  data-html="true" title="Buy price: {{number_format($item["count"]*$item["price"]->getBuyPrice(), 0, ",", " ")}} ISK<br/>Sell price: {{number_format($item["count"]*$item["price"]->getSellPrice(), 0, ",", " ")}} ISK">
        {{number_format($item["count"]*$item["price"]->getAveragePrice(), 0, ",", " ")}} ISK
    </td>
</tr>
{{--<tr>--}}
{{--    <td colspan="3"><pre>{{print_r($item, 1)}}</pre></td>--}}
{{--</tr>--}}
