<tr>
    <td style="width: 36px;">
        @if($item->getTypeId())
            <img src="https://imageserver.eveonline.com/Type/{{$item->getTypeId()}}_64.png" alt="{{$item->getItemName()}} icon" class="fit-item-icon">
        @else

        @endif
    </td>
    <td>
        <a href="{{route('item_single', ['item_id' => $item->getTypeId()])}}">{{$item->getItemName() ?? '[Unknown item #'.$item->getTypeId().']'}}</a>
        @if ($item->hasAmmo())
            <sub class="bringupper">with <a href="{{route('item_single', ['item_id' => $item->getAmmoTypeId()])}}"><img src="https://imageserver.eveonline.com/Type/{{$item->getAmmoTypeId()}}_32.png" alt="{{$item->getAmmoName()}} icon" class="fit-ammo-icon">{{$item->getAmmoName()}}</a></sub>
        @endif
        @if ($item->getCount() > 1)
            <sub class="bringupper">x{{$item->getCount()}}</sub>
        @endif
    </td>
    @if ($item->getAveragePrice() > 0)
        <td class="text-right" >
            {{number_format($item->getCount()*$item->getAveragePrice(), 0, ",", " ")}} ISK
        </td>
    @else
        <td class="text-right"><span class="text-muted">??? ISK</span></td>
    @endif
</tr>
