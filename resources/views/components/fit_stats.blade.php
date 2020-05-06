@php
$stats = json_decode($stats, false);
@endphp
<div class="card card-body border-0 shadow-sm mt-3">
    <h5 class="font-weight-bold">Resource usage</h5>
    <table class="table-sm w-100">
        <tr>
            <td class="tinyhead" colspan="3">&nbsp;</td>
            <td class="text-right text-small p-0 tinyhead">used</td>
            <td class="text-right text-small p-0 tinyhead">available</td>
        </tr>
        <tr>
            <td class="w-20p"><img src="/icons/fit/cpu.png" alt="CPU icon" class="tinyicon"></td>
            <td>CPU</td>
            <td>
                @if($stats->misc->ship->cpuMax<$stats->misc->ship->cpuUsed)
                    <img src="https://img.icons8.com/officexs/24/000000/box-important.png" style="width: 16px; height: 16px" data-toggle="tooltip" title="CPU usage is {{round($stats->misc->ship->cpuUsed/$stats->misc->ship->cpuMax*100, 2)}}%"/>
            @endif
            <td class="text-right {{$stats->misc->ship->cpuMax<$stats->misc->ship->cpuUsed ? 'text-danger font-weight-bold' : ''}}">{{number_format($stats->misc->ship->cpuUsed, 0, ",", "")}} tf</td>
            <td class="text-right">{{number_format($stats->misc->ship->cpuMax, 0, ",", "")}} tf</td>
        </tr>
        <tr>
            <td class="w-20p"><img src="/icons/fit/powergrid.png" alt="Powergrid icon" class="tinyicon"></td>
            <td>Powergrid</td>
            <td>
                @if($stats->misc->ship->powerMax<$stats->misc->ship->pgUsed)
                    <img src="https://img.icons8.com/officexs/24/000000/box-important.png" style="width: 16px; height: 16px" data-toggle="tooltip" title="CPU usage is {{round($stats->misc->ship->pgUsed/$stats->misc->ship->powerMax*100, 2)}}%"/>
            @endif
            <td class="text-right {{$stats->misc->ship->powerMax<$stats->misc->ship->pgUsed ? 'text-danger font-weight-bold' : ''}}">{{number_format($stats->misc->ship->pgUsed, 0, ",", "")}} MW</td>
            <td class="text-right">{{number_format($stats->misc->ship->powerMax, 0, ",", "")}} MW</td>
        </tr>
        <tr>
            <td class="w-20p"><img src="/icons/fit/drone.png" alt="Dronebay icon" class="tinyicon"></td>
            <td>Dronebay</td>
            <td>
                @if($stats->misc->drones->droneBayTotal<$stats->misc->drones->droneBayUsed)
                    <img src="https://img.icons8.com/officexs/24/000000/box-important.png" style="width: 16px; height: 16px" data-toggle="tooltip" title="CPU usage is {{round($stats->misc->drones->droneBayUsed/$stats->misc->drones->droneBayTotal*100, 2)}}%"/>
            @endif
            <td class="text-right {{$stats->misc->drones->droneBayTotal<$stats->misc->drones->droneBayUsed ? 'text-danger font-weight-bold' : ''}}">{{number_format($stats->misc->drones->droneBayUsed, 0, ",", "")}} m<sup>3</sup></td>
            <td class="text-right">{{number_format($stats->misc->drones->droneBayTotal, 0, ",", "")}} m<sup>3</sup></td>
        </tr>
    </table>
</div>


<div class="card card-body border-0 shadow-sm mt-3">
    <h5 class="font-weight-bold">Firepower</h5>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="h4 font-weight-bold mb-0" style="line-height: 1rem">{{round($stats->offense->totalDps)}} dps</p>
            <small class="text-muted my-0" style="line-height: 1rem">total dps</small>
        </div>
        <div>
            <table class="table-sm">
                <tr>
                    <td><img src="/icons/fit/turret_missile.png" class="tinyicon" alt=""></td>
                    <td>Weapons</td>
                    <td class="text-right">{{round($stats->offense->weaponDps)}}</td>
                    <td>dps</td>
                </tr>
                <tr>
                    <td><img src="/icons/fit/drone.png" class="tinyicon" alt=""></td>
                    <td>Drones</td>
                    <td class="text-right">{{round($stats->offense->droneDps)}}</td>
                    <td>dps</td>
                </tr>
                <tr>
                    <td><img src="/icons/fit/volley.png" class="tinyicon" alt=""></td>
                    <td>Volley</td>
                    <td class="text-right">{{round($stats->offense->totalVolley)}}</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
</div>


<div class="card card-body border-0 shadow-sm mt-3">
    <h5 class="font-weight-bold">Hitpoints</h5>
    <table class="table table-sm w-100">
        <tr>
            <td></td>
            <td class="text-center" data-toggle="tooltip" title="EM resistance"><img class="smallicon" src="/icons/fit/em.png"></td>
            <td class="text-center" data-toggle="tooltip" title="Thermal resistance"><img class="smallicon" src="/icons/fit/therm.png"></td>
            <td class="text-center" data-toggle="tooltip" title="Kinetic resistance"><img class="smallicon" src="/icons/fit/kin.png"></td>
            <td class="text-center" data-toggle="tooltip" title="Explosive resistance"><img class="smallicon" src="/icons/fit/exp.png"></td>
            <td class="text-right" data-toggle="tooltip" title="Effective Hitpoints (EHP) - with resistance calculated in"><img class="smallicon" src="/icons/fit/hp.png"></td>
        </tr>
        <tr>
            <td data-toggle="tooltip" title="Shield"><img class="smallicon" src="/icons/fit/shield.png"></td>
            @component('components.resist_columns', ['resists' => $stats->defense->resists->shield])@endcomponent
            <td class="text-right">{{number_format($stats->defense->ehp->shield, 0, ",", " ")}} ehp</td>
        </tr>
        <tr>
            <td data-toggle="tooltip" title="Armor"><img class="smallicon" src="/icons/fit/armor.png"></td>
            @component('components.resist_columns', ['resists' => $stats->defense->resists->armor])@endcomponent
            <td class="text-right">{{number_format($stats->defense->ehp->armor, 0, ",", " ")}} ehp</td>
        </tr>
        <tr>
            <td data-toggle="tooltip" title="Hull"><img class="smallicon" src="/icons/fit/hull.png"></td>
            @component('components.resist_columns', ['resists' => $stats->defense->resists->hull])@endcomponent
            <td class="text-right">{{number_format($stats->defense->ehp->hull, 0, ",", " ")}} ehp</td>
        </tr>
        <tr>
            <td colspan="6" class="text-right font-weight-bold">
                Total: {{number_format($stats->defense->ehp->total, 0, ",", " ")}} ehp
            </td>
        </tr>
    </table>
</div>

<div class="card card-body border-0 shadow-sm mt-3">
    <h5 class="font-weight-bold">Repairs</h5>
    <table class="table table-sm w-100">
        <tr>
            <td>&nbsp;</td>
            <td class="text-center"  data-toggle="tooltip" title="Passive shield recharge"><img class="smallicon" src="/icons/fit/shield_recharge.png"></td>
            <td class="text-center"  data-toggle="tooltip" title="Shield boost"><img class="smallicon" src="/icons/fit/shield_boost.png"></td>
            <td class="text-center"  data-toggle="tooltip" title="Armor repair"><img class="smallicon" src="/icons/fit/armor_repair.png"></td>
            <td class="text-center"  data-toggle="tooltip" title="Hull repair"><img class="smallicon" src="/icons/fit/hull_repair.png"></td>
        </tr>
        <tr>
            <td class="text-center"  data-toggle="tooltip" title="Burst repairs"><img class="smallicon" src="/icons/fit/burst.png"></td>
        </tr>
        <tr>
            <td class="text-center"  data-toggle="tooltip" title="Sustained repairs"><img class="smallicon" src="/icons/fit/sustained.png"></td>
        </tr>
    </table>
    <pre>{{print_r($stats->defense->reps, true)}}</pre>
</div>
