<table class="table table-responsive-sm table-sm w-100 mb-4">
    @foreach([
'high' => "High slot modules",
'mid' => "Mid slot modules",
'low' => "Low slot modules",
'rig' => "Rigs",
'drone' => "Drones",
'ammo' => "Ammunition",
'booster' => "Boosters",
'cargo' => "Other cargo and implants",
] as $moduleType => $moduleDescription)
        @if (!in_array($moduleType, $hiddenModules ?? []))
            @component("components.fit_group", ["items" => $fit_quicklook[$moduleType], "section" => $moduleDescription]) @endcomponent
        @endif
    @endforeach
    <tr>
        <td colspan="3" class="font-weight-bold text-right">Total without ship: {{number_format($items_price, 0, ","," ")}} ISK</td>
    </tr>
    <tr>
        <td colspan="3" class="text-left text-uppercase font-weight-bold">Ship</td>
    </tr>
    <tr>
        <td style="width: 36px;">
            <img src="https://imageserver.eveonline.com/Type/{{$fit->SHIP_ID ?? 0}}_64.png" alt="{{$ship_name}} icon" class="fit-item-icon">
        </td>
        <td>
            {{$ship_name}}
        </td>
        <td class="text-right">
            {{number_format($ship_price, 0, ",", " ")}} ISK
        </td>
    </tr>
    <tr>
        <td colspan="3" class="font-weight-bold text-right">Total: {{number_format($ship_price+$items_price, 0, ","," ")}} ISK</td>
    </tr>
</table>
