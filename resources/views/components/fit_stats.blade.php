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
    <h5 class="font-weight-bold">Offense</h5>
    <pre>{{print_r($stats->offense, true)}}</pre>
</div>


<div class="card card-body border-0 shadow-sm mt-3">
    <h5 class="font-weight-bold">Defense</h5>
    <pre>{{print_r($stats->defense, true)}}</pre>
</div>

<div class="card card-body border-0 shadow-sm mt-3">
    <h5 class="font-weight-bold">Capacitor</h5>
    <pre>{{print_r($stats, true)}}</pre>
</div>
