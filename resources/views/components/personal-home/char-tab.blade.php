<div class="tab-pane fade {{($show ?? false) ? 'active show' : ''}}" id="char_{{$char->id}}" role="tabpanel">
    <p class="text-center"><span class="font-weight-bold mx-auto">{{$char->name}}</span>'s stats</p>


    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card card-body border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/counter.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{$my_runs[$char->id]}}</h2>
                        <small class="text-muted font-weight-bold">Runs so far</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/average-2.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($my_avg_loot[$char->id]/1000000, 2, ".", " ")}}</h2>
                        <small class="text-muted font-weight-bold">Average loot (Million ISK)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/treasure-chest.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($my_sum_loot[$char->id]/1000000, 0, ",", " ")}}</h2>
                        <small class="text-muted font-weight-bold">Total loot (Million ISK)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/web-shield.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{sprintf("%1.2f", $my_survival_ratio[$char->id])}} %</h2>
                        <small class="text-muted font-weight-bold">Survival ratio</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="graph-container h-400px">
        {!! $timeline_charts[$char->id]->container(); !!}
    </div>
</div>
