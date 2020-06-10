<tr>
    <td style="width: 36px;">
        @if($item->getTypeId())
            <img src="https://imageserver.eveonline.com/Type/{{$item->getTypeId()}}_32.png" alt="{{$item->getItemName()}} icon" style="width: 32px;height: 32px;">
        @else

        @endif
    </td>
    <td>
        {{$item->getItemName() ?? '[Unknown item - typeId: '.$item->getTypeId().']'}}
        @if ($item->hasAmmo())
            <sub class="bringupper">with <img src="https://imageserver.eveonline.com/Type/{{$item->getAmmoTypeId()}}_32.png" alt="{{$item->getAmmoName()}} icon"
                                              style="width: 16px;height: 16px;"> {{$item->getAmmoName()}}</sub>
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
