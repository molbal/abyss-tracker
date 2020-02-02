@extends("layout.app")
@section("browser-title", "Home")
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold">Welcome to Veetor's Abyss Loot Tracker</h4>
        <p>Home of {{$abyss_num}} saved runs</p>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Filament types</h5>
                {!! $loot_types_chart->container(); !!}
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Tier levels</h5>
                {!! $tier_levels_chart->container(); !!}
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Survival</h5>
                {!! $survival_chart->container(); !!}
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Average loot per tiers</h5>
                {!! $loot_tier_chart->container(); !!}
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Abyss activity</h5>
                {!! $daily_add_chart->container(); !!}
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mt-3">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">What is this site?</h5>
                <p class="text-justify">Welcome,<br>
                This is a website to track and compare your Abyss runs, how much your loot is worth, and what kind of filaments are popular.
                    <br>
                If you also add your Abyssal deadspace runs we will have a better idea on how much loot spawns in Abyssal sites (which is really hectic).</p>
                <p>Cheers, <br>
                    <img src="https://images.evetech.net/characters/93940047/portrait?size=32" alt="" class="rounded-circle shadow-sm"> Veetor Nara
                    </p>
            </div>
        </div>
    </div>

@endsection

@section("scripts")
    {!! $loot_types_chart->script(); !!}
    {!! $tier_levels_chart->script(); !!}
    {!! $survival_chart->script(); !!}
    {!! $loot_tier_chart->script(); !!}
    {!! $daily_add_chart->script(); !!}
    <script type="text/javascript">
    </script>
@endsection
