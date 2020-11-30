<table class="table table-responsive-sm table-sm w-100 mb-4">
    @component("components.fit_group", ["items" => $fit_quicklook["high"], "section" => "High slot modules"])@endcomponent
    @component("components.fit_group", ["items" => $fit_quicklook["mid"], "section" => "Mid slot modules"])@endcomponent
    @component("components.fit_group", ["items" => $fit_quicklook["low"], "section" => "Low slot modules"])@endcomponent
    @component("components.fit_group", ["items" => $fit_quicklook["rig"], "section" => "Rigs"])@endcomponent
    @component("components.fit_group", ["items" => $fit_quicklook["drone"], "section" => "Drones"])@endcomponent
    @component("components.fit_group", ["items" => $fit_quicklook["ammo"], "section" => "Ammunition"])@endcomponent
    @component("components.fit_group", ["items" => $fit_quicklook["booster"], "section" => "Boosters"])@endcomponent
    @component("components.fit_group", ["items" => $fit_quicklook["cargo"], "section" => "Other cargo and implants"])@endcomponent
    <tr>
        <td colspan="3" class="font-weight-bold text-right">Total without ship: {{number_format($items_price, 0, ","," ")}} ISK</td>
    </tr>
    <tr>
        <td colspan="3" class="text-left text-uppercase font-weight-bold">Ship</td>
    </tr>
    <tr>
        <td style="width: 36px;">
            <img src="https://imageserver.eveonline.com/Type/{{$fit->SHIP_ID}}_64.png" alt="{{$ship_name}} icon" class="fit-item-icon">
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
