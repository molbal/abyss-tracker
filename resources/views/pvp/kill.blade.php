@extends("layout.app")
@section("browser-title", "Killmail of ".$victim->character->name."'s ".$victim->ship_type->name." in ".$victim->pvp_event->name)
@section("content")

    <div class="row">
        @component('pvp.components.video-banner', ['event' => $victim->pvp_event]) @endcomponent
    </div>
    <div class="d-flex justify-content-between align-items-center mb-1 mt-5">
        <span class="fit-header-line">
            <h4 class="font-weight-bold fit-title d-inline-block mb-0">{{$victim->character->name}}'s {{$victim->ship_type->name}} </h4>
        </span>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Modules</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eft">Export</a></li>
                <li class="nav-item"><a class="nav-link" href="{{$victim->littlekill['url']}}" target="_blank">zKillboard <ion-icon name="link-outline"></ion-icon></a></li>
            </ul>

            <div class="card card-body border-0 shadow-sm pt-3">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        @component("components.fits.display-structured", [
		  'fit' => $fit,
		  'fit_quicklook' => $fit_quicklook,
		  'ship_name' => $ship_name,
		  'ship_price' => $ship_price,
		  'items_price' => $items_price,
		  'hiddenModules' => ['ammo','booster','cargo']]) @endcomponent
                        <div class="mb-3 card-footer border-0 rounded-t-none shadow-sm">
                            @component('components.info-line') Fit modules info from zKillboard, price info from Janice, EVE Workbench and Fuzzwork market data, fit stats from the Abyss Tracker @endcomponent
                        </div>
                    </div>
                    <div id="eft" class="tab-pane fade">
                        <h5 class="font-weight-bold">Export fit</h5>
                        @component("components.info-line", ['class' => 'mb-3 mt-1'])
                            On the left side of the ingame fitting window, click the wrench icon. Then at the bottom left of the page click 'Import &amp; Export' then 'Import from clipboard' to import this fit to EVE Online.
                        @endcomponent
                        <textarea class="w-100 form-control readonly" rows="20" readonly="readonly" onclick="this.focus();this.select()" style="font-family: 'Fira Code', 'Consolas', monospace">{{$victim->stats->eft}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card card-body shadow-sm border-0 text-center">
                @component('pvp.components.fit.victim', ["victim" => $victim]) @endcomponent
            </div>
            @component('pvp.components.fit.ship-type', ["victim" => $victim]) @endcomponent

            @if($victim->hasWorkingStats())
                @component('components.fit_stats', ["stats" => $victim->stats->stats]) @endcomponent
            @else
                <div class="card card-body border-0 shadow-sm text-center mt-3">
                    <div class="mb-0">
                        <img src="{{asset('loader.png')}}" style="width: 64px; height: 64px"/>
                        <h5 class="font-weight-bold">Calculating stats</h5>
                        <p class="mb-0">The Abyss Tracker is calculating stats for this fit - please hold on, it might take a few minutes.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Attackers info</h4>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 col-lg-4">
            <div class="mb-0 card card-body border-0 rounded-b-none shadow-sm">
                <div class="graph-container h-300px">
                    <h5 class="font-weight-bold">Damage dealt ({{number_format($victim->attackers()->sum('damage_done'), 0, ',')}})</h5>
                    {!! $top_damage_chart->container() !!}
                </div>
            </div>
            <div class="mb-3 card-footer border-0 rounded-t-none shadow-sm">
                @component('components.info-line') Data from EVE Online ESI @endcomponent
            </div>


            <div class="mb-0 card card-body border-0 shadow-sm pb-0">
                <table class="table table-sm text-small">
                    <tr><td>Date destroyed</td><td>{{$victim->created_at}}</td></tr>
                    <tr><td>Synced to the leaderboard</td><td>{{$victim->updated_at}}</td></tr>
                    <tr><td>Stats calculated</td><td>{{$victim->hasWorkingStats() ? $victim->stats->updated_at : 'In progress..'}}</td></tr>
                </table>
            </div>
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="card card-body border-0 shadow-sm pb-0">
                <table class="table table w-100">
                    <tr>
                        <th colspan="2">Attacker</th>
                        <th colspan="2">Ship</th>
                        <th colspan="2">Weapon</th>
                        <th class="text-right">Damage done</th>
                    </tr>
                    @forelse($victim->attackers as $attacker)
                        @if($attacker->isCapsuleer())
                            <tr class="">
                                <td style="width: 26px;"><img src="{{\App\Http\Controllers\HelperController::getCharImgLink($attacker->character->id)}}" alt="" class="rounded-circle shadow-sm pvp-icon-md"></td>
                                <td><a href="{{route('pvp.character', ['slug' => $victim->pvp_event->slug, 'id' => $attacker->character->id])}}">{{$attacker->character->name}}</a></td>

                                <td style="width: 26px;"><img src="{{\App\Http\Controllers\HelperController::getRenderImgLink($attacker->ship_type->id)}}" alt="" class="rounded-circle shadow-sm pvp-icon-sm"></td>
                                <td><a href="{{route('pvp.ship', ['slug' => $victim->pvp_event->slug, 'id' => $attacker->ship_type->id])}}" data-toggle="tooltip" title="{{$attacker->ship_type->name}}">{{Str::limit($attacker->ship_type->name, 12)}}</a></td>

                                @if($attacker->hasWeaponInfo())
                                    <td style="width: 26px;"><img src="{{\App\Http\Controllers\HelperController::getItemImgLink($attacker->weapon_type->id)}}" alt="" class="rounded-circle shadow-sm pvp-icon-sm"></td>
                                    <td><a href="{{route('pvp.item', ['slug' => $victim->pvp_event->slug, 'id' => $attacker->weapon_type->id])}}" data-toggle="tooltip" title="{{$attacker->weapon_type->name}}">{{Str::limit($attacker->weapon_type->name, 12)}}</a></td>
                                @else
                                    <td style="width: 26px;">&nbsp;</td>
                                    <td class="text-muted">Unknown</td>
                                @endif

{{--                                <td class="text-right">{{$attacker->security_status}}</td>--}}
                                <td class="text-right">{{number_format($attacker->damage_done, 0, ",")}}</td>
                            </tr>
                        @else
                            <tr class="">
                                <td style="width: 26px;"><img src="{{\App\Http\Controllers\HelperController::getItemImgLink($attacker->ship_type->id)}}" alt="" class="rounded-circle shadow-sm pvp-icon-md"></td>
                                <td colspan="5"><a href="{{route('pvp.ship', ['slug' => $victim->pvp_event->slug, 'id' => $attacker->ship_type->id])}}">NPC {{$attacker->ship_type->name}}</a></td>
                                <td class="text-right">{{number_format($attacker->damage_done, 0, ",")}}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="py-5 text-center text-muted">Unknown</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>


@endsection
@section("styles")
    <link rel="stylesheet" href="{{asset("css/fit-only.css")}}">
@endsection

@section("scripts")
    {!! $top_damage_chart->script() !!}
@endsection
