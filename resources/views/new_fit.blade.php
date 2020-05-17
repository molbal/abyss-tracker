@extends("layout.app")
@section("browser-title", "Add a new fit")
@section("content")
    <form action="{{route('fit_new_store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
            <h4 class="font-weight-bold"><img src="https://img.icons8.com/cotton/50/000000/hammer.png" style="width: 50px; height: 50px;"/> Add new fit</h4>
        </div>
        @if(isset($errors))
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm d-flex justify-content-between">
                    <img src="https://img.icons8.com/cotton/64/000000/cancel-2--v1.png">
                    <div style="width: 100%">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="font-weight-bold">EFT fit</h5>
                            <p>
                                Please paste here the fit in EFT format.
{{--                                If you need help in exporting the "EFT format" please see our guide <a href="#" target="_blank">here.</a>--}}
                            </p>
                        </div>
                        <div class="col-sm-8">
                            <div class="alert alert-danger shadow-sm font-weight-bold">
                                <h5 class="font-weight-bold">Important!</h5>
                                DPS is calculated if the weapons have loaded ammunition. This is written in the EFT after the weapons, divided by a comma.
                                <br>
                                Abyssal modules are currently not supported. <a target="_blank" href="https://github.com/molbal/abyss-tracker/issues/17">Bugtracker link</a>
                            </div>
                            <textarea name="eft" id="eft" class="w-100 form-control" rows="10" required></textarea>
                        </div>
                        <div class="col-sm-4">
                            <p class="h6">Import options</p>
                            <ul class="pl-3">
                                <li><a href="javascript:void(0);" class="text-muted" onclick="alert('Sorry, this is not yet supported.')">Import from EVE Online</a></li>
                                <li><a href="javascript:void(0);" class="text-muted" onclick="alert('Sorry, this is not yet supported.')">Import from zKillboard</a></li>
                                <li><a href="javascript:void(0);" class="text-muted" onclick="alert('Sorry, this is not yet supported.')">Import from Eve Workbench</a></li>
                            </ul>
                            <p class="h6">What is extracted from this?</p>
                            <ul class="pl-3">
                                <li>Ship name
                                    <img src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/info.png" data-toggle="tooltip"
                                         title="Only ships which can enter Abyssal Deadspace are supported!">
                                </li>
                                <li>Fit name</li>
                                <li>Damage output</li>
                                <li>Tank strength (resistances and repairs)</li>
                                <li>Capacitor stats</li>
                                <li>Targeting stats</li>
                                <li>Ship speed with propulsion mod turned on</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm container mt-3">

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="font-weight-bold">Description</h5>
                            <p>
                                Please write a few words about your fit and set whats the highest Abyss Tier you recommend it for.
                            </p>
                        </div>
                        <div class="col-sm-8">
                            <p>Good tips on what to write here: In which order should you destroy enemies (Eg. neuters, webbers first), how to deal with the rooms like the Karen room or the Leshaks room. You can use <a href="#" target="_blank">markdown</a> formatting.</p>
                            <textarea name="description" id="description" class="form-control w-100" rows="10" required></textarea>

                            <div class="form-group mt-3">
                                <label for="">Youtube video link <br> <small>If you have a video displaying the fit, it will be linked.<br>Please use a well formed Youtube link such as <a
                                            href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">https://www.youtube.com/watch?v=dQw4w9WgXcQ</a></small></label>
                                <input type="text" name="video_link" id="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">For Electrical</label>
                                <select name="ELECTRICAL" id="Electrical" class="form-control select2-nosearch">
                                    <option value="0"> Not recommended for any tier</option>
                                    <option value="1">Up to tier 1 (Calm)</option>
                                    <option value="2">Up to tier 2 (Agitated)</option>
                                    <option value="3">Up to tier 3 (Fierce)</option>
                                    <option value="4">Up to tier 4 (Raging)</option>
                                    <option value="5">Up to tier 5 (Chaotic)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">For Dark</label>
                                <select name="DARK" id="Dark" class="form-control select2-nosearch">
                                    <option value="0"> Not recommended for any tier</option>
                                    <option value="1">Up to tier 1 (Calm)</option>
                                    <option value="2">Up to tier 2 (Agitated)</option>
                                    <option value="3">Up to tier 3 (Fierce)</option>
                                    <option value="4">Up to tier 4 (Raging)</option>
                                    <option value="5">Up to tier 5 (Chaotic)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">For Exotic</label>
                                <select name="EXOTIC" id="Exotic" class="form-control select2-nosearch">
                                    <option value="0"> Not recommended for any tier</option>
                                    <option value="1">Up to tier 1 (Calm)</option>
                                    <option value="2">Up to tier 2 (Agitated)</option>
                                    <option value="3">Up to tier 3 (Fierce)</option>
                                    <option value="4">Up to tier 4 (Raging)</option>
                                    <option value="5">Up to tier 5 (Chaotic)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">For Firestorm</label>
                                <select name="FIRESTORM" id="Firestorm" class="form-control select2-nosearch">
                                    <option value="0"> Not recommended for any tier</option>
                                    <option value="1">Up to tier 1 (Calm)</option>
                                    <option value="2">Up to tier 2 (Agitated)</option>
                                    <option value="3">Up to tier 3 (Fierce)</option>
                                    <option value="4">Up to tier 4 (Raging)</option>
                                    <option value="5">Up to tier 5 (Chaotic)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">For Gamma</label>
                                <select name="GAMMA" id="Gamma" class="form-control select2-nosearch">
                                    <option value="0"> Not recommended for any tier</option>
                                    <option value="1">Up to tier 1 (Calm)</option>
                                    <option value="2">Up to tier 2 (Agitated)</option>
                                    <option value="3">Up to tier 3 (Fierce)</option>
                                    <option value="4">Up to tier 4 (Raging)</option>
                                    <option value="5">Up to tier 5 (Chaotic)</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm container mt-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="font-weight-bold">Privacy</h5>
                            <p>Please select what information should be visible about your fit</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 p-1">
                            <div class="pickerInputGroup">
                                <input id="privacy-public" name="privacy" value="public" type="radio" checked/>
                                <label for="privacy-public">
                                    <p class="mb-1 font-weight-bold text-uppercase">Public</p>
                                    <p class="mb-1 text-small">Public fitting with the modules and your name visible</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4 p-1">
                            <div class="pickerInputGroup">
                                <input id="privacy-incognito" name="privacy" value="incognito" type="radio"/>
                                <label for="privacy-incognito">
                                    <p class="mb-1 font-weight-bold text-uppercase">Anonym</p>
                                    <p class="mb-1 text-small">Anonym fitting with the modules visible, but your name hidden</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4 p-1">
                            <div class="pickerInputGroup">
                                <input id="privacy-private" name="privacy" value="private" type="radio"/>
                                <label for="privacy-private">
                                    <p class="mb-1 font-weight-bold text-uppercase">Private</p>
                                    <p class="mb-1 text-small">Private fitting with neither modules or your name visible</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm mt-3">
                    <p>After submitting a fit it will take a few minutes to calculate its statistics.</p>
                    <p>
                        <input type="submit" value="Save" class="btn btn-outline-primary">
                    </p>
                </div>
            </div>
        </div>
    </form>

@endsection

@section("styles")

    @if(App\Http\Controllers\ThemeController::isDarkTheme())
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/xcatliu/simplemde-theme-dark@master/dist/simplemde-theme-dark.min.css">

        <style>
            .editor-toolbar {
                background: transparent !important;
            }

            .editor-toolbar a {
                color: #d3d3d3 !important;
            }

            .editor-toolbar:hover a {
                color: #eee !important;
            }

            .CodeMirror {
                background-color: #060606 !important;
            }



        </style>
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    @endif
@endsection
@section("scripts")

    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        $(function () {
            var simplemde = new SimpleMDE({
                element: document.getElementById("description"),
                forceSync: true,
                spellChecker: false,
                status: false,
                hideIcons: ["guide"]
            });
            $('.CodeMirror textarea').attr('required', true);
        });
    </script>
@endsection
