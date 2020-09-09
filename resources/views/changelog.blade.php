@extends("layout.app")
@section("browser-title", "Changes")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-6 mb-3 offset-md-3">
            <div class="card card-body border-warning shadow-sm mb-3">
                <small class="text-capitalize font-weight-bold text-dark pt-0">IN DEVELOPMENT / PLANNED</small>
                <h4 class="mb-0 pb-0">Future releases</h4>
                <p>
                    The following features are planned (in no particular order or grouping).
                <ul>
                    <li>Blueprint price estimation</li>
                    <li>Dynamically adding and removing search filters</li>
                    <li>Dynamically adding and removing fit search filters</li>
                    <li>General search</li>
                </ul>

                </p>
            </div>
            <div class="card card-body border-danger shadow-sm mb-3 p-0">
                <img src="{{asset("home/1.5.6.jpg")}}" alt="1.5.6 release" class="w-100 shadow">
                <div class="p-3">
                    <small class="text-capitalize font-weight-bold text-danger pt-0">CURRENT</small>
                    <h4 class="mb-0 pb-0"><strong>1.5.6</strong> 'SOE' release</h4>
                    <small class="mt-0">2020 sept 9</small>
                    <p class="text-justify">
                        Tutorials release
                    </p>
                    <ul>
                        <li>Adds tutorials</li>
                        <li>Fixes broken Youtube embeds on fits</li>
                        <li>Switching light/dark themes will try to return you to the same page instead of the homepage</li>
                        <li>Performance optimizations</li>
                    </ul>
                    <small>The next release will consist of bugfixes and user requested enhanchements.</small>
                </div>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3 p-0">
                <img src="{{asset("home/1.5.5.jpg")}}" alt="1.5.5 release" class="w-100 shadow">
                <div class="p-3">
                    <h4 class="mb-0 pb-0"><strong>1.5.5</strong> 'Bolt' release</h4>
                    <small class="mt-0">2020 august 28</small>
                    <p class="text-justify">
                        This is a combined bugfix and new features release.
                    </p>
                    <ul>
                        <li>Infrastructure changes: Database version update to MariaDB 10.2.33, PHP version update to 7.4, Laravel update to 7.22. Host VPS increased to 4 vCPU cores (was 1) and 8GB (was 1.5GB) memory.</li>
                        <li>Adds EDENCOM ships to the supported ships list: Stormbringer and Skybreaker</li>
                        <li>Fixes broken icon pointing to 'My profile' in the navigation bar</li>
                        <li>On the homepage and infopages, the last runs section will now show run duration instead of submission time</li>
                        <li>Removed proving conduit from new run screen</li>
                        <li>Added "Remember cargo" toggle and made it clear in <a href="{{route("settings.index")}}">Settings</a></li>
                        <li>Added auto-redirect function for messages</li>
                        <li>Added "return immediately to new run after saving" button</li>
                        <li>Added donations display to homescreen</li>
                        <li>Adds ordering for fit search</li>
                    </ul>
                </div>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.5.4</strong> 'Circadian' release</h4>
                <small class="mt-0">2020 june 6</small>
                <p class="text-justify">
                    This is a combined bugfix and new features release.
                </p>
                <ul>
                    <li>Initial version of the Tier Overview pages.</li>
                    <li>Fixes bug: <em>Cannot unselect fit when adding new run <a href="https://github.com/molbal/abyss-tracker/issues/42" target="_blank">#42</a></em></li>
                    <li>Fixes bug: <em>Only filling the run minutes sets the duration as Unknown <a href="https://github.com/molbal/abyss-tracker/issues/40" target="_blank">#40</a></em></li>
                    <li>Fixes bug: <em>Http Error 500 on new run with emtpy rows <a href="https://github.com/molbal/abyss-tracker/issues/43" target="_blank">#43</a></em></li>
                    {{--                    <li>Fixes bug: <em>Fitting filter not re-applied after using browser "back" <a href="https://github.com/molbal/abyss-tracker/issues/34" target="_blank">#34</a></em></li>--}}
                    <li>Fixes bug: <em>Ship size filter doesn't work <a href="https://github.com/molbal/abyss-tracker/issues/36" target="_blank">#36</a></em></li>
                    <li>Fixes bug: <em>Cant select a fit when trying to "add a new run" <a href="https://github.com/molbal/abyss-tracker/issues/41" target="_blank">#41</a></em></li>
                </ul>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.5.3</strong> 'Depot' release</h4>
                <small class="mt-0">2020 june 10</small>
                <p class="text-justify">
                    New features
                </p>
                <ul>
                    <li>Updates site style (Footer, icons)</li>
                    <li>Improves "My stats" page layout</li>
                    <li>Fixes bug: <em>server error uploading fit <a href="https://github.com/molbal/abyss-tracker/issues/35" target="_blank">#35</a></em></li>
                    <li>Fixes bug: <em>Abyssal modules breaking import <a href="https://github.com/molbal/abyss-tracker/issues/17" target="_blank">#17</a></em></li>
                </ul>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.5.2</strong> 'Smokescreen' release</h4>
                <small class="mt-0">2020 june 6</small>
                <p class="text-justify">
                    This is a bugfix and stability release.
                </p>
                <ul>
                    <li>Upgrades the loot value estimator, removes Evepraisal data source and adds Fuzzwork Marketdata and EVE Workbench data source</li>
                    <li>Fixes bug: <em>Incorrect item price displayed in fit view <a href="https://github.com/molbal/abyss-tracker/issues/31" target="_blank">#31</a></em></li>
                    <li>Fixes bug: <em>Fit Picker not respecting fit privacy setting <a href="https://github.com/molbal/abyss-tracker/issues/30" target="_blank">#30</a></em></li>
                    <li>Fixes bug: <em>Fit picker: "Last viewed fit" not updating correctly <a href="https://github.com/molbal/abyss-tracker/issues/29" target="_blank">#29</a></em></li>
                    <li>Fixes bug: <em>Different detailed table ISK total and the summary total ISK show a different value <a href="https://github.com/molbal/abyss-tracker/issues/25" target="_blank">#25</a></em></li>
                    <li>Fixes bug: <em>Cargo parsing of before repackaged / after unpackaged items <a href="https://github.com/molbal/abyss-tracker/issues/14" target="_blank">#14</a></em></li>
                </ul>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.5.1</strong> 'Ligature' release</h4>
                <small class="mt-0">2020 may 26</small>
                <p class="text-justify">
                    New features
                </p>
                <ul>
                    <li>Lots of small bugfixes</li>
                    <li>Changes to new type bell graphs</li>
                    <li>"Unbreaks" old fits with pre-2020.05.26 patch module names</li>
                    <li>Improves site performance by caching fit related datasets</li>
                    <li>Adds runs to a fit's page</li>
                </ul>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.5.0</strong> 'Command' release</h4>
                <small class="mt-0">2020 may 17</small>
                <p class="text-justify">
                    New features
                </p>
                <ul>
                    <li class="font-weight-bold">Support for fits! 🎇🎇</li>
                    <li>Updates item table to Surgical Strike</li>
                    <li>Adds new metadata for fits: Linked fit and T5 bonus room</li>
                    <li>Lotts of little visibility improvements in the dark theme - which is now default</li>
                    <li>Tweaked the layout for ship display, adding search and fit links and switched the popularity graph to use 7 day averages which makes seeing trends easier
                    </li>
                    <li>Added new privacy selector for new run and new ship forms</li>
                    <li>Added run length to my runs table (xbigxgrizzlyx's request)</li>
                    <li>Reduced stopwatch location update frequency from 10 seconds to 7 seconds</li>
                </ul>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.4.2</strong> 'Wetu' release</h4>
                <small class="mt-0">2020 april 28</small>
                <p class="text-justify">
                    As you can see this project took a 2 weeks pause, that's because I prepared a different project to serve the Abyss Tracker with calculating the fits
                    capabilities. If you are interested you can see that
                    <a href="https://svcfitstat.eve-nt.uk/" target="_blank">project</a>. During this time some issues were found so this is just a quick bugfix release we'll use as
                    a stepping stone.
                    <br>
                    Little enhanchements and bugfixes:
                </p>
                <ul>
                    <li>Fixed drop rate calculation bug <a href="https://github.com/molbal/abyss-tracker/issues/10" target="_blank">(Issue 10)</a></li>
                    <li>Added a way to remove and reset the ESI token in settings <a href="https://github.com/molbal/abyss-tracker/issues/11" target="_blank">(Issue 11)</a></li>
                    <li>Automatic open of before/after cargo panels <a href="https://github.com/molbal/abyss-tracker/issues/9" target="_blank">(Issue 9)</a></li>
                    <li>If the last run had an after cargo and it was maximum 60 minutes ago, its after cargo will pre-fill the before-cargo text box<a
                            href="https://github.com/molbal/abyss-tracker/issues/12" target="_blank">(Issue 12)</a></li>
                </ul>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.4.1</strong> 'Accumulation' release</h4>
                <small class="mt-0">2020 march 25</small>
                <p>
                    This release adds:
                <ul>
                    <li>Your public profile will show you everything and display a privacy message if you are signed in - on your own profile only, of course</li>
                    <li>Adds EVE style loot display for your profile page, and a range filter for accumulated profiles</li>
                </ul>
                Little enhanchements:
                <ul>
                    <li><span class="badge badge-success">DONE</span> Allows changing run privacy</li>
                </ul>
                The following bugs were fixed:
                <ul>
                    <li><span class="badge badge-success">FIXED</span> <span>Daterange picker displayed incorrectly with the dark theme</span></li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.4</strong> 'Personage' release</h4>
                <small class="mt-0">2020 march 19</small>
                <p>
                    This release adds:
                <ul>
                    <li>Public profiles with settings</li>
                    <li>Adding averages to the homepage chart</li>
                </ul>

                The following bugs were fixed:
                <ul>
                    <li><span class="badge badge-success">FIXED</span> <span>Frigate profit calculation should be adjusted to use 3 filaments.</span></li>
                    <li><span class="badge badge-success">FIXED</span> <span>Reporting a run while being signed out results in an error</span></li>
                    <li><span class="badge badge-success">FIXED</span> <span>Proving conduit spawn and usage was saved incorrectly</span></li>
                    <li><span class="badge badge-success">FIXED</span> <span>Some search filters are not working properly</span></li>
                    <li><span class="badge badge-success">FIXED</span> <span>Error screen when viewing a run with a blueprint lost in cargo</span></li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.3.6</strong> 'Insight' release</h4>
                <small class="mt-0">2020 march 06</small>
                <p>
                    This release adds:
                <ul>
                    <li>Improved list displays: Tiers, Types and ship names are clickable, link goes to the general search results</li>
                    <li>Added export options for the item drop table and search results</li>
                    <li>Reorganized the menu</li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.3.5</strong> 'Perception ' release</h4>
                <small class="mt-0">2020 march 05</small>
                <p>
                    This release adds:
                <ul>
                    <li>Replaced pre-made filters with a flexible search function</li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.3.4</strong> 'Discharge' release</h4>
                <small class="mt-0">2020 february 27</small>
                <p>
                    This release adds:
                <ul>
                    <li>Found and fixed the bug with the loot isk calculation. It was caused by Evepraisal calculating impossible to fulfill buy orders.</li>
                    <li>Flagging runs now works</li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.3.3</strong> 'Carapace' release</h4>
                <small class="mt-0">2020 february 26</small>
                <p>
                    This release adds:
                <ul>
                    <li>More detailed run income/expenses/profit table</li>
                    <li>Consistent calculation of used filaments in the consumed items table</li>
                    <li>Server configuration changes for trying to achieve a more stable operation</li>
                    <li>Delete your own runs</li>
                    <li>Flagging of other capsuleer's runs</li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.3.2</strong> 'Vessel' release</h4>
                <small class="mt-0">2020 february 22</small>
                <p>
                    This release adds:
                <ul>
                    <li>Changed server configuration to prevent memory and swap related service disruptions</li>
                    <li>Added ship's info panel</li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.2</strong> 'Nocturnal' release</h4>
                <small class="mt-0">2020 february 4</small>
                <p>
                    This release adds:
                <ul>
                    <li>Dark mode!</li>
                </ul>
                </p>
            </div>
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-0 shadow-sm mb-3">
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
            <div class="card card-body border-danger border-0 shadow-sm mb-3">
                <h4 class="mb-0 pb-0"><strong>1.0</strong> Initial release</h4>
                <small class="mt-0">2020 january 27</small>
                <p>
                    This was the initial release of the website.
                </p>
            </div>
        </div>
    </div>
@endsection
