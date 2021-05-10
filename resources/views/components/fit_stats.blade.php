@php
    $stats = json_decode($stats, false);
@endphp
<div class="card card-body border-0 shadow-sm mt-3">
    <h6>Resource usage</h6>
    <table class="table-sm w-100">
        <tr>
            <td class="tinyhead" colspan="3">&nbsp;</td>
            <td class="text-right text-small p-0 tinyhead">used</td>
            <td class="text-right text-small p-0 tinyhead">available</td>
        </tr>
        <tr>
            <td class="w-20p"><img loading="lazy" src="/_icons/fit/cpu.png" alt="CPU icon" class="tinyicon"></td>
            <td>CPU</td>
            <td>
                @if($stats->misc->ship->cpuMax<$stats->misc->ship->cpuUsed)
                    <img loading="lazy" src="https://img.icons8.com/officexs/24/000000/box-important.png" class="icon-overusage" data-toggle="tooltip"
                         title="CPU usage is {{round($stats->misc->ship->cpuUsed/$stats->misc->ship->cpuMax*100, 2)}}%"/>
            @endif
            <td class="text-right {{$stats->misc->ship->cpuMax<$stats->misc->ship->cpuUsed ? 'text-danger font-weight-bold' : ''}}">{{number_format($stats->misc->ship->cpuUsed, 0, ",", "")}}
                tf
            </td>
            <td class="text-right">{{number_format($stats->misc->ship->cpuMax, 0, ",", "")}} tf</td>
        </tr>
        <tr>
            <td class="w-20p"><img loading="lazy" src="/_icons/fit/powergrid.png" alt="Powergrid icon" class="tinyicon"></td>
            <td>Powergrid</td>
            <td>
                @if($stats->misc->ship->powerMax<$stats->misc->ship->pgUsed)
                    <img loading="lazy" src="https://img.icons8.com/officexs/24/000000/box-important.png" class="icon-overusage" data-toggle="tooltip"
                         title="CPU usage is {{round($stats->misc->ship->pgUsed/$stats->misc->ship->powerMax*100, 2)}}%"/>
            @endif
            <td class="text-right {{$stats->misc->ship->powerMax<$stats->misc->ship->pgUsed ? 'text-danger font-weight-bold' : ''}}">{{number_format($stats->misc->ship->pgUsed, 0, ",", "")}}
                MW
            </td>
            <td class="text-right">{{number_format($stats->misc->ship->powerMax, 0, ",", "")}} MW</td>
        </tr>
    </table>
</div>


<div class="card card-body border-0 shadow-sm mt-3">
    <div class="d-flex justify-content-between">
        <h6>Firepower</h6>
        @component("components.info-toggle")
            Stats are calculated with all modules active, but no modules overheated. Reload time is ignored while calculating these. Implants and boosters are factored in.
        @endcomponent
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="h4 font-weight-bold mb-0" style="line-height: 1rem;margin-top: 15px;">{{round($stats->offense->totalDps)}} dps</p>
            <small class="text-muted my-0" style="line-height: 1rem">total dps</small>
        </div>
        <div>
            <table class="table-sm">
                <tr>
                    <td><img loading="lazy" src="/_icons/fit/turret_missile.png" class="tinyicon" alt=""></td>
                    <td>Weapons</td>
                    <td class="text-right">{{round($stats->offense->weaponDps)}}</td>
                    <td><span class="text-small bringupper">dps</span></td>
                </tr>
                <tr>
                    <td><img loading="lazy" src="/_icons/fit/drone.png" class="tinyicon" alt=""></td>
                    <td>Drones</td>
                    <td class="text-right">{{round($stats->offense->droneDps)}}</td>
                    <td><span class="text-small bringupper">dps</span></td>
                </tr>
                <tr>
                    <td><img loading="lazy" src="/_icons/fit/volley.png" class="tinyicon" alt=""></td>
                    <td>Volley</td>
                    <td class="text-right">{{round($stats->offense->totalVolley)}}</td>
                    <td><span class="text-small bringupper">dmg</span></td>
                </tr>
            </table>
        </div>
    </div>
</div>


<div class="card card-body border-0 shadow-sm mt-3">
    <div class="d-flex justify-content-between">
        <h6>Hitpoints</h6>
        @component("components.info-toggle")
            Stats are calculated with all modules active, but no modules overheated. Implants and boosters are factored in.
        @endcomponent
    </div>
    <table class="table table-sm w-100">
        <tr>
            <td></td>
            <td class="text-center" data-toggle="tooltip" title="EM resistance"><img loading="lazy" class="smallicon" src="/_icons/fit/em.png"></td>
            <td class="text-center" data-toggle="tooltip" title="Thermal resistance"><img loading="lazy" class="smallicon" src="/_icons/fit/therm.png"></td>
            <td class="text-center" data-toggle="tooltip" title="Kinetic resistance"><img loading="lazy" class="smallicon" src="/_icons/fit/kin.png"></td>
            <td class="text-center" data-toggle="tooltip" title="Explosive resistance"><img loading="lazy" class="smallicon" src="/_icons/fit/exp.png"></td>
            <td class="text-right" data-toggle="tooltip" title="Effective Hitpoints (EHP) - with resistance calculated in"><img loading="lazy" class="smallicon" src="/_icons/fit/hp.png"></td>
        </tr>
        <tr>
            <td data-toggle="tooltip" title="Shield"><img loading="lazy" class="smallicon" src="/_icons/fit/shield.png"></td>
            @component('components.resist_columns', ['resists' => $stats->defense->resists->shield])@endcomponent
            <td class="text-right">{{number_format($stats->defense->ehp->shield, 0, ",", " ")}} <span class="text-small bringupper">ehp</span></td>
        </tr>
        <tr>
            <td data-toggle="tooltip" title="Armor"><img loading="lazy" class="smallicon" src="/_icons/fit/armor.png"></td>
            @component('components.resist_columns', ['resists' => $stats->defense->resists->armor])@endcomponent
            <td class="text-right">{{number_format($stats->defense->ehp->armor, 0, ",", " ")}} <span class="text-small bringupper">ehp</span></td>
        </tr>
        <tr>
            <td data-toggle="tooltip" title="Hull"><img loading="lazy" class="smallicon" src="/_icons/fit/hull.png"></td>
            @component('components.resist_columns', ['resists' => $stats->defense->resists->hull])@endcomponent
            <td class="text-right">{{number_format($stats->defense->ehp->hull, 0, ",", " ")}} <span class="text-small bringupper">ehp</span></td>
        </tr>
        <tr>
            <td colspan="6" class="text-right font-weight-bold">
                Total: {{number_format($stats->defense->ehp->total, 0, ",", " ")}} <span class="text-small bringupper">ehp</span>
            </td>
        </tr>
    </table>
</div>

<div class="card card-body border-0 shadow-sm mt-3">
    <div class="d-flex justify-content-between">
        <h6>Repairs</h6>
        @component("components.info-toggle")
            Stats are calculated with all modules active, but no modules overheated. Implants and boosters are factored in.
        @endcomponent
    </div>
    <table class="table table-sm w-100">
        <tr>
            <td>&nbsp;</td>
            <td class="text-right" data-toggle="tooltip" title="Passive shield recharge"><img loading="lazy" class="smallicon" src="/_icons/fit/shield_recharge.png"></td>
            <td class="text-right" data-toggle="tooltip" title="Shield boost"><img loading="lazy" class="smallicon" src="/_icons/fit/shield_boost.png"></td>
            <td class="text-right" data-toggle="tooltip" title="Armor repair"><img loading="lazy" class="smallicon" src="/_icons/fit/armor_repair.png"></td>
            <td class="text-right" data-toggle="tooltip" title="Hull repair"><img loading="lazy" class="smallicon" src="/_icons/fit/hull_repair.png"></td>
        </tr>
        <tr>
            <td class="text-center" data-toggle="tooltip" title="Burst repairs"><img loading="lazy" class="smallicon" src="/_icons/fit/burst.png"></td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->burst->shieldRegen])@endcomponent</td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->burst->shieldBoost])@endcomponent</td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->burst->armor])@endcomponent</td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->burst->hull])@endcomponent</td>
        </tr>
        <tr>
            <td class="text-center" data-toggle="tooltip" title="Sustained repairs"><img loading="lazy" class="smallicon" src="/_icons/fit/sustained.png"></td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->sustained->shieldRegen])@endcomponent</td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->sustained->shieldBoost])@endcomponent</td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->sustained->armor])@endcomponent</td>
            <td>@component('components.rep', ['value' => $stats->defense->reps->sustained->hull])@endcomponent</td>
        </tr>
        </tr>
    </table>
</div>


<div class="card card-body border-0 shadow-sm mt-3">
    <div class="d-flex justify-content-between">
        <h6>Capacitor</h6>
        @component("components.info-toggle")
            Stats are calculated with all modules active, but no modules overheated. Implants and boosters are factored in.
        @endcomponent
    </div>
    <table class="table-sm w-100">
        <tr>
            @if($stats->misc->capacitor->stable)
                <td colspan="3" class="text-center">
                    <span class="text-uppercase font-weight-bold">Stable at {{round($stats->misc->capacitor->stableAt, 1)}}%</span>
                </td>
            @else
                <td colspan="3" class="text-center">
                    <span class="text-uppercase font-weight-bold">Lasts for {{number_format($stats->misc->capacitor->lastsSeconds, 0, ",", " ")}} seconds</span>
                </td>
            @endif
        <tr>
            <td><img loading="lazy" src="/_icons/fit/capacitor.png" class="smallicon" alt="Icon">&nbsp;Capacity</td>
            <td class="text-right">{{number_format($stats->misc->capacitor->capacity, 0, ",", " ")}}</td>
            <td><span class="text-small bringupper">GJ</span></td>
        </tr>
        </tr>
    </table>
</div>

<div class="card card-body border-0 shadow-sm mt-3">
    <div class="d-flex justify-content-between">
        <h6>Targeting &amp; speed</h6>
        @component("components.info-toggle")
            Stats are calculated with all modules active, but no modules overheated. Implants and boosters are factored in.
        @endcomponent
    </div>
    <table class="table-sm w-100">
        <tr>
            <td><img loading="lazy" src="/_icons/fit/propulsion.png" alt="Icon" class="smallicon">&nbsp;Speed</td>
            <td class="text-right">{{number_format($stats->misc->maxSpeed, 0, ",", " ")}}</td>
            <td><span class="text-small bringupper">m/s</span></td>
        </tr>
        <tr>
            <td><img loading="lazy" src="/_icons/fit/tp.png" alt="Icon" class="smallicon">&nbsp;Signature radius</td>
            <td class="text-right">{{number_format($stats->misc->signature, 1, ",", " ")}}</td>
            <td><span class="text-small bringupper">m</span></td>
        </tr>
        <tr>
            <td><img loading="lazy" src="/_icons/fit/targeting_range.png" alt="Icon" class="smallicon">&nbsp;Targeting range</td>
            <td class="text-right">{{number_format($stats->misc->targeting->range, 0, ",", " ")}}</td>
            <td><span class="text-small bringupper">m</span></td>
        </tr>
        <tr>
            <td><img loading="lazy" src="/_icons/fit/targeting_resolution.png" alt="Icon" class="smallicon">&nbsp;Scan resolution</td>
            <td class="text-right">{{number_format($stats->misc->targeting->resolution, 0, ",", " ")}}</td>
            <td><span class="text-small bringupper">mm</span></td>
        </tr>
        <tr>
            <td><img loading="lazy" src="/_icons/fit/targeting_strength.png" alt="Icon" class="smallicon">&nbsp;Sensor strength</td>
            <td class="text-right">{{$stats->misc->targeting->strength}}</td>
            <td><span class="text-small bringupper">str</span></td>
        </tr>
    </table>
</div>
