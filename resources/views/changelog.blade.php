@extends("layout.app")
@section("browser-title", "Changes")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-danger shadow-sm mb-3">
                <small class="text-capitalize font-weight-bold text-danger pt-0">CURRENT</small>
                <h4 class="mb-0 pb-0"><strong>1.3</strong> 'Epoch' release</h4>
                <small class="mt-0">2020 february 12</small>
                <p>
                    This release adds:
                <ul>
                    <li>Stopwatch for runs with ESI</li>
                    <li>Run's length display</li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.2.3</strong> 'Agility' release</h4>
                <small class="mt-0">2020 february 11</small>
                <p>
                    This release adds:
                <ul>
                    <li>Added side-scroll to tables for easier mobile display</li>
                    <li>Separation of frigate and cruiser runs for average tier loot calculation</li>
                    <li>Separation of frigate and cruiser runs for abyssal activity calculation</li>
                    <li>Added most common ships view</li>
                </ul>
                </p>
                <p>
                    This release prepares:
                <ul>
                    <li>Automated stopwatch based on ESI data to measure how much time you spent in the Abyss</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.2.2</strong> 'Declutter' release</h4>
                <small class="mt-0">2020 february 7</small>
                <p>
                    This release adds:
                <ul>
                    <li>Advanced cargo analyser: You now have the option to add before and after cargo - the site will
                        calculate which items you used up and what items you looted.
                    </li>
                    <li>Canon death reason (auto generated)</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.2.1</strong> 'Acumen' release</h4>
                <small class="mt-0">2020 february 6</small>
                <p>
                    This release adds:
                <ul>
                    <li>More interesting homescreen</li>
                    <li>Loot drop rate display in items list</li>
                </ul>
                </p>
                <p>
                    This release improves:
                <ul>
                    <li>Site performance when opening runs or opening item</li>
                </ul>
                </p>
                <p>This release fixes:
                <ul>
                    <li>In some cases when the loot contains a previously unknown item, the tracker failed to calculate
                        a drop rate for it and showed a nasty error. Not any more!
                    </li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.2</strong> 'Nocturnal' release</h4>
                <small class="mt-0">2020 february 4</small>
                <p>
                    This release adds:
                <ul>
                    <li>Dark mode!</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.1.3</strong> 'Hoarder' release</h4>
                <small class="mt-0">2020 february 2</small>
                <p>
                    This release adds:
                <ul>
                    <li>Adds loot table list</li>
                    <li>Adds item group listing</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.1.2</strong> 'Retrospection' release</h4>
                <small class="mt-0">2020 february 2</small>
                <p>
                    This release adds:
                <ul>
                    <li>While adding a new run, <strong>Abyss Type</strong>, <strong>Tier</strong>,
                        <strong>Ship</strong>, <strong>Loot strategy</strong> and <strong>Name visibility</strong> is
                        remembered from the last run
                    </li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.1.1</strong> Drops rate release</h4>
                <small class="mt-0">2020 february 2</small>
                <p>
                    This release adds:
                <ul>
                    <li>Drop rate table for drop items</li>
                    <li>Drop rate column for run details loot table</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.1</strong> Feature extension release</h4>
                <small class="mt-0">2020 january 31</small>
                <p>
                    This release adds:
                <ul>
                    <li>zKillboard link</li>
                    <li>Loot type</li>
                    <li>Updated run screen</li>
                </ul>
                And prepares the database for the next update:
                <ul>
                    <li>Filament prices</li>
                    <li>Item drop rates</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.0.9</strong> Partial feature extension release</h4>
                <small class="mt-0">2020 january 30</small>
                <p>
                    This release adds:
                <ul>
                    <li>Evepraisal loot value estimation</li>
                    <li>ESI points for getting item group</li>
                    <li>More Detailed data entry</li>
                    <li>Ship type</li>
                    <li>This screen 😜</li>
                    <li>Set the default visibility to private</li>
                </ul>
                And prepares the database for the next update:
                <ul>
                    <li>Filament prices</li>
                    <li>Better reporting</li>
                    <li>More detailed run display</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mb-3">
            <div class="card card-body border-danger border-0 shadow-sm">
                <h4 class="mb-0 pb-0"><strong>1.0</strong> Initial release</h4>
                <small class="mt-0">2020 january 27</small>
                <p>
                    This was the initial release of the website.
                </p>
            </div>
        </div>
    </div>
@endsection
