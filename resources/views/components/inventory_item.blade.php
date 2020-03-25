<div style="display: inline-block; width: 72px; height: 96px; margin-right: 8px; margin-bottom: 8px; text-align: center; overflow: hidden"
     data-toggle="tooltip"
     title='
     <table class="table table-sm w-100 bright-theme-only-white mb-0">
    <tr class="">
        <td colspan="2" class="border-0 text-center font-weight-bold">{{$item->NAME}}</td>
</tr>
<tr>
    <td colspan="2" class="text-center font-italic">{{$item->GROUP_NAME}}</td>
</tr>
<tr>
    <td>Buy price / piece:</td>
    <td class="text-right">{{number_format($item->PRICE_BUY, 0, " ", " ")}} ISK</td>
</tr>
<tr>
    <td>Sell price / piece:</td>
    <td class="text-right">{{number_format($item->PRICE_SELL, 0, " ", " ")}} ISK</td>
</tr>
<tr>
    <td>Stack buy price:</td>
    <td class="text-right">{{number_format($item->PRICE_BUY*$item->COUNT, 0, " ", " ")}} ISK</td>
</tr>
<tr>
    <td>Stack sell price:</td>
    <td class="text-right">{{number_format($item->PRICE_SELL*$item->COUNT, 0, " ", " ")}} ISK</td>
</tr>
</table>'
    data-html="true"
    >
    <a href="{{route('item_single', ['item_id' => $item->ITEM_ID])}}"><img style="width: 64px; height: 64px" src="https://imageserver.eveonline.com/Type/{{$item->ITEM_ID}}_64.png" alt=""></a>
    <span class="text-right d-inline-block w-100" style="position:relative; top: -27px"><span class="badge badge-secondary shadow-sm">{{$item->COUNT}}</span></span>
    <span style="font-size: 0.8rem; position:relative; top: -27px;
  text-overflow: clip;
  white-space: nowrap;">{{$item->NAME}}</span>
</div>


